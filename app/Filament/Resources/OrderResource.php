<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use NumberFormatter;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
                        TextInput::make('order_number')
                            ->label('Order ID')
                            ->disabled()
                            ->required()
                            ->formatStateUsing(fn(?string $state, Get $get) => $get('order_number')),

                        TextInput::make('user.full_name')
                            ->label('Customer')
                            ->disabled()
                            ->required()
                            ->formatStateUsing(fn(?string $state, Get $get) => $get('user.full_name')),

                        ToggleButtons::make('status')
                            ->inline()
                            ->default('pending')
                            ->required()
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->colors([
                                'pending' => 'info',
                                'processing' => 'warning',
                                'shipped' => 'success',
                                'delivered' => 'success',
                                'cancelled' => 'warning',
                            ]),

                        TextInput::make('shipping_service')
                            ->label('Courier Service')
                            ->required()
                            ->formatStateUsing(fn(string $state): string => strtoupper(str_replace('_', ' ', $state))),

                        TextInput::make('shipping_cost')
                            ->label('Shipping Cost')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                    ])->columns(1),

                    Section::make('Order Items')->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->distinct()
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Set $set) => $set('unit_price', Product::find($state)?->price ?? 0))
                                    ->afterStateUpdated(fn($state, Set $set) => $set('total_price', Product::find($state)?->price ?? 0)),

                                TextInput::make('unit_price')
                                    ->numeric()
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(3),

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Set $set, Get $get) => $set('total_price', $state * $get('unit_price'))),

                                TextInput::make('total_price')
                                    ->numeric()
                                    ->required()
                                    ->dehydrated()
                                    ->columnSpan(3),
                            ])->columns(12)
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $total = 0;
                                foreach ($get('items') ?? [] as $item) {
                                    $total += $item['total_price'] ?? 0;
                                }
                                $set('total_price', $total);
                            }),

                        // Subtotal
                        Placeholder::make('items_total_placeholder')
                            ->label(' ')
                            ->content(function (Get $get) {
                                $total = 0;
                                foreach ($get('items') ?? [] as $item) {
                                    $total += $item['total_price'] ?? 0;
                                }
                                $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                                return 'Subtotal = ' . $formatter->formatCurrency($total, 'IDR');
                            })
                            ->columnSpan(6),

                        // Shipping Cost
                        Placeholder::make('shipping_cost_placeholder')
                            ->label(' ')
                            ->content(function (Get $get) {
                                $shippingCost = $get('shipping_cost') ?? 0;
                                $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                                return 'Shipping Cost = ' . $formatter->formatCurrency($shippingCost, 'IDR');
                            })
                            ->columnSpan(6),

                        // Tax (10%)
                        Placeholder::make('tax_amount_placeholder')
                            ->label(' ')
                            ->content(function (Get $get) {
                                $total = 0;
                                foreach ($get('items') ?? [] as $item) {
                                    $total += $item['total_price'] ?? 0;
                                }
                                $taxAmount = $total * 0.1;
                                $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                                return 'Tax (10%) = ' . $formatter->formatCurrency($taxAmount, 'IDR');
                            })
                            ->columnSpan(6),

                        // Grand Total (with larger font)
                        Placeholder::make('total_amount_placeholder')
                            ->label('----------------------------------')
                            ->content(function (Get $get) {
                                $total = 0;
                                foreach ($get('items') ?? [] as $item) {
                                    $total += $item['total_price'] ?? 0;
                                }
                                $shippingCost = $get('shipping_cost') ?? 0;
                                $taxAmount = $total * 0.1;
                                $totalAmount = $total + $shippingCost + $taxAmount;

                                $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                                return 'Total = ' . $formatter->formatCurrency($totalAmount, 'IDR');
                            })
                            ->columnSpan(6)
                            ->extraAttributes(['style' => 'font-size: 1.25rem; font-weight: bold;']), // Larger font size for "Total"

                        // Hidden Total Amount
                        Hidden::make('total_amount')
                            ->default(0)
                    ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('order_number')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_amount')
                    ->sortable()
                    ->money('IDR'),

                TextColumn::make('shipping_service')
                    ->label('Courier Service')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => strtoupper(str_replace('_', ' ', $state))),

                SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}