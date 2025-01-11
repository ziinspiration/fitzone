<footer class="bg-white pb-8">
    <!-- Newsletter Section -->
    @auth
        <div class="mx-auto px-4 bg-black text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Text Section -->
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-2xl font-bold mb-2">BUY THE BEST SPORTS SHOES AT FITZONE</h3>
                        <p class="text-lg">GET INFO AND EXCLUSIVE OFFERS ON YOUR FAVORITE SHOES</p>
                    </div>
                    <!-- Button Section -->
                    <div>
                        <a href="/products">
                            <button type="submit" class="bg-white text-black px-6 py-2 hover:bg-gray-200">
                                SHOP NOW!
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
    <div class="mx-auto px-4 bg-black text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Text Section -->
                <div class="mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold mb-2">REGISTER YOUR EMAIL</h3>
                    <p class="text-lg">TO RECEIVE INFO AND EXCLUSIVE OFFERS</p>
                </div>
                <!-- Button Section -->
                <div>
                    <a href="/signup">
                        <button type="submit" class="bg-white text-black px-6 py-2 hover:bg-gray-200">
                            SIGN UP FOR FREE →
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endauth
  <!-- Main Footer Links -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Product Column -->
          <div>
              <h4 class="font-bold mb-4">PRODUK</h4>
              <ul class="space-y-2">
                  <li><a href="#" class="hover:underline">Sepatu</a></li>
                  <li><a href="#" class="hover:underline">Pakaian</a></li>
                  <li><a href="#" class="hover:underline">Aksesoris</a></li>
              </ul>

              <h4 class="font-bold mt-8 mb-4">FEATURED</h4>
              <ul class="space-y-2">
                  <li><a href="#" class="hover:underline">New Arrivals</a></li>
                  <li><a href="#" class="hover:underline">Impossible is Nothing</a></li>
                  <li><a href="#" class="hover:underline">Sale</a></li>
                  <li><a href="#" class="hover:underline">Last Chance</a></li>
              </ul>
          </div>

          <!-- Sports Column -->
          <div>
              <h4 class="font-bold mb-4">SPORT</h4>
              <ul class="space-y-2">
                  <li><a href="#" class="hover:underline">Predator Football Boots</a></li>
                  <li><a href="#" class="hover:underline">X Football Boots</a></li>
                  <li><a href="#" class="hover:underline">Copa Football Boots</a></li>
                  <li><a href="#" class="hover:underline">Manchester United</a></li>
                  <li><a href="#" class="hover:underline">Juventus</a></li>
                  <li><a href="#" class="hover:underline">Real Madrid</a></li>
                  <li><a href="#" class="hover:underline">Arsenal</a></li>
                  <li><a href="#" class="hover:underline">Bayern München</a></li>
                  <li><a href="#" class="hover:underline">Boost Shoes</a></li>
                  <li><a href="#" class="hover:underline">Ultraboost</a></li>
              </ul>
          </div>

          <!-- Collection Column -->
          <div>
              <h4 class="font-bold mb-4">KOLEKSI</h4>
              <ul class="space-y-2">
                  <li><a href="#" class="hover:underline">Stan Smith</a></li>
                  <li><a href="#" class="hover:underline">Superstar</a></li>
                  <li><a href="#" class="hover:underline">Ultraboost</a></li>
                  <li><a href="#" class="hover:underline">NMD</a></li>
                  <li><a href="#" class="hover:underline">adidas Exclusive</a></li>
              </ul>
          </div>

          <!-- Support Column -->
          <div>
              <h4 class="font-bold mb-4">LEGAL</h4>
              <ul class="space-y-2">
                  <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                  <li><a href="#" class="hover:underline">Syarat dan Ketentuan</a></li>
                  <li><a href="#" class="hover:underline">Ketentuan Pengiriman</a></li>
              </ul>

              <h4 class="font-bold mt-8 mb-4">SUPPORT</h4>
              <ul class="space-y-2">
                  <li><a href="#" class="hover:underline">Hubungi Kami</a></li>
                  <li><a href="#" class="hover:underline">Panduan Ukuran</a></li>
                  <li><a href="#" class="hover:underline">Cara Berbelanja</a></li>
                  <li><a href="#" class="hover:underline">Promo & Voucher</a></li>
                  <li><a href="#" class="hover:underline">Pembayaran</a></li>
                  <li><a href="#" class="hover:underline">Pengiriman</a></li>
                  <li><a href="#" class="hover:underline">Retur dan Pengembalian Dana</a></li>
                  <li><a href="#" class="hover:underline">Tentang Produk adidas</a></li>
                  <li><a href="#" class="hover:underline">Cara Menggunakan Situs Kami</a></li>
                  <li><a href="#" class="hover:underline">Akun Anda</a></li>
                  <li><a href="#" class="hover:underline">Cek Status Pesanan</a></li>
              </ul>
          </div>
      </div>
  </div>

  <!-- Bottom Footer -->
  <div class="container mx-auto px-4 mt-12 pt-8 border-t border-gray-800">
      <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="flex items-center mb-4 md:mb-0">
              <span class="mr-2">🇮🇩</span>
              <span>Indonesia</span>
          </div>
          <div class="flex space-x-4 text-sm">
              <a href="#" class="hover:underline">Privacy Policy</a>
              <span>|</span>
              <a href="#" class="hover:underline">Terms and Conditions</a>
              <span>|</span>
              <span>© 2025 Fitzone, Inc. All rights reserved</span>
          </div>
      </div>
  </div>
</footer