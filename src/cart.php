<!-- Cart Drawer -->
  <div id="cartDrawer" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div id="backdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    <!-- Drawer -->
    <div class="absolute right-0 top-0 h-full w-full sm:max-w-md bg-gray-900/80 backdrop-blur-xl shadow-2xl border-l border-indigo-500/20 transition-transform duration-500 ease-in-out transform translate-x-full" id="drawerPanel">
      <div class="p-6 flex flex-col h-full">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-indigo-400">Your Cart</h2>
          <button id="closeCart" class="text-gray-300 hover:text-red-400 text-xl">
            ✕
          </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto space-y-6">
          <!-- Item -->
          <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl shadow hover:scale-[1.01] transition">
            <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/shopping-cart-page-04-product-01.jpg" class="w-20 h-20 object-cover rounded-lg border border-indigo-500/30" />
            <div class="flex-1">
              <h4 class="font-semibold text-indigo-200">Hip Bag</h4>
              <p class="text-gray-400 text-sm">Salmon Orange</p>
              <p class="text-indigo-400 mt-1">$90.00</p>
            </div>
            <button class="text-sm text-red-400 hover:underline">Remove</button>
          </div>

          <!-- Item 2 -->
          <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl shadow hover:scale-[1.01] transition">
            <img src="https://tailwindcss.com/plus-assets/img/ecommerce-images/shopping-cart-page-04-product-02.jpg" class="w-20 h-20 object-cover rounded-lg border border-indigo-500/30" />
            <div class="flex-1">
              <h4 class="font-semibold text-indigo-200">Satchel</h4>
              <p class="text-gray-400 text-sm">Blue</p>
              <p class="text-indigo-400 mt-1">$32.00</p>
            </div>
            <button class="text-sm text-red-400 hover:underline">Remove</button>
          </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 border-t border-indigo-500/20 pt-4">
          <div class="flex justify-between mb-4 text-lg">
            <span class="text-white">Subtotal</span>
            <span class="text-indigo-300">$122.00</span>
          </div>
          <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow transition">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    const openCartBtn = document.getElementById('openCart');
    const closeCartBtn = document.getElementById('closeCart');
    const cartDrawer = document.getElementById('cartDrawer');
    const drawerPanel = document.getElementById('drawerPanel');
    const backdrop = document.getElementById('backdrop');

    openCartBtn.addEventListener('click', () => {
      cartDrawer.classList.remove('hidden');
      setTimeout(() => drawerPanel.classList.remove('translate-x-full'), 10);
    });

    function closeDrawer() {
      drawerPanel.classList.add('translate-x-full');
      setTimeout(() => cartDrawer.classList.add('hidden'), 500);
    }

    closeCartBtn.addEventListener('click', closeDrawer);
    backdrop.addEventListener('click', closeDrawer);
  </script>
