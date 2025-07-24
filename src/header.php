<header class="bg-transparent shadow sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      
      <div class="flex items-center space-x-8">
        <a href="#" class="text-orange-700 text-xl font-extrabold select-none">Petstore</a>
        <nav class="hidden md:flex space-x-6 text-orange-600 font-medium">
          <a href="#" class="hover:text-orange-800 transition">Home</a>
          <a href="#" class="hover:text-orange-800 transition">Shop</a>
          <a href="#" class="hover:text-orange-800 transition">Collection</a>
          <a href="#" class="hover:text-orange-800 transition">Blogs</a>
          <a href="#" class="hover:text-orange-800 transition">Contact</a>
        </nav>
      </div>

      <!-- Right side: Icons -->
      <div class="flex items-center space-x-6">
        <!-- Search -->
        <button aria-label="Search" class="text-orange-600 hover:text-orange-800 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7" />
            <line x1="21" y1="21" x2="16.65" y2="16.65" />
          </svg>
        </button>

        <!-- User -->
        <button aria-label="User Account" class="text-orange-600 hover:text-orange-800 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M4 21v-2a4 4 0 0 1 3-3.87" />
            <circle cx="12" cy="7" r="4" />
          </svg>
        </button>

        <!-- Cart -->
        <button id="openCart" aria-label="Shopping Cart" class="text-orange-600 hover:text-orange-800 transition relative">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1" />
            <circle cx="20" cy="21" r="1" />
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
          </svg>
          <span
            class="absolute -top-2 -right-2 bg-orange-600 text-white text-xs rounded-full px-1.5 py-0.5 font-bold">3</span>
        </button>
      </div>

      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button id="mobile-menu-btn" aria-label="Open menu" class="text-orange-600 hover:text-orange-800 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="18" x2="21" y2="18" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <nav id="mobile-menu" class="hidden md:hidden bg-orange-100 px-4 pt-4 pb-6 space-y-3 text-orange-600 font-medium">
    <a href="#" class="block hover:text-orange-800 transition">Home</a>
    <a href="#" class="block hover:text-orange-800 transition">Shop</a>
    <a href="#" class="block hover:text-orange-800 transition">Collection</a>
    <a href="#" class="block hover:text-orange-800 transition">Blogs</a>
    <a href="#" class="block hover:text-orange-800 transition">Contact</a>
  </nav>

  <script>
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</header>