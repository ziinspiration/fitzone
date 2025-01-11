<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key', '7ca97b87feadc1323b83a1da133d8597');
        $this->baseUrl = config('rajaongkir.base_url', 'https://api.rajaongkir.com/starter/');

        if (!$this->apiKey) {
            Log::error('RajaOngkir API key not configured.');
        }

        if (!filter_var($this->baseUrl, FILTER_VALIDATE_URL)) {
            Log::error('Invalid RajaOngkir base URL configuration.');
        }
    }

    public function getProvinces()
    {
        try {
            $response = Http::withHeaders(['key' => $this->apiKey])
                ->get('https://api.rajaongkir.com/starter/province');

            if ($response->successful()) {
                return $response->json()['rajaongkir']['results'] ?? [];
            }

            Log::warning('RajaOngkir Province API Error', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir Province API Exception: ' . $e->getMessage());
            return [];
        }
    }

    public function getCities($provinceId)
    {
        $cacheKey = "cities_province_{$provinceId}";

        return Cache::remember($cacheKey, 86400, function () use ($provinceId) {
            try {
                $response = Http::withHeaders(['key' => $this->apiKey])
                    ->get('https://api.rajaongkir.com/starter/city', [
                        'province' => $provinceId,
                    ]);

                if ($response->successful()) {
                    return $response->json()['rajaongkir']['results'] ?? [];
                }

                Log::warning('RajaOngkir City API Error', [
                    'province_id' => $provinceId,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('RajaOngkir City API Exception: ' . $e->getMessage());
                return [];
            }
        });
    }

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        $cacheKey = "shipping_{$origin}_{$destination}_{$weight}_{$courier}";

        return Cache::remember($cacheKey, 3600, function () use ($origin, $destination, $weight, $courier) {
            try {
                $response = Http::withHeaders(['key' => $this->apiKey])
                    ->post('https://api.rajaongkir.com/starter/cost', [
                        'origin' => $origin,
                        'destination' => $destination,
                        'weight' => $weight,
                        'courier' => $courier,
                    ]);

                if ($response->successful()) {
                    return $response->json()['rajaongkir']['results'] ?? [];
                }

                Log::warning('RajaOngkir Cost API Error', [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);

                return [];
            } catch (\Exception $e) {
                Log::error('RajaOngkir Cost API Exception: ' . $e->getMessage());
                return [];
            }
        });
    }
}
