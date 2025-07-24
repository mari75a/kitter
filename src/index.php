<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
</head>
<body class="font-sans">

  
  <?php
include 'header.php';
?>


  <!-- Hero Section -->
  <section
  class="relative w-full h-screen bg-cover bg-center flex items-center justify-center"
  style="background-image: url('./img/hero-banner.jpg');"
>
  <!-- Overlay for better text readability -->
  <!-- <div class="absolute inset-0 bg-black bg-opacity-40"></div> -->

  <!-- Content on top -->
  <div class="relative max-w-4xl text-center px-6">
    <h2 class="text-5xl md:text-6xl font-extrabold text-white mb-6 drop-shadow-lg">
      Find Everything Your Pet Needs!
    </h2>
    <p class="text-xl md:text-2xl text-white mb-8 drop-shadow-md">
      From healthy food to playful toys – We’ve got it all.
    </p>
    <a
      href="#items"
      class="inline-block bg-orange-500 hover:bg-orange-600 text-white text-lg font-semibold px-8 py-4 rounded-lg shadow-lg transition"
    >
      Shop Now
    </a>
  </div>
</section>

  <!-- Categories -->
  <section id="categories" class="max-w-7xl mx-auto py-12 px-6">
    <h3 class="text-3xl font-bold text-center text-orange-700 mb-8">Shop by Category</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <?php
include 'connection.php';
$rs = Database::search("SELECT * FROM categories");
while ($row = $rs->fetch_assoc()) {
  echo '<a href="category.php?cat_id=' . $row['category_id'] . '" class="block">';
  echo '<div class="bg-white shadow p-4 rounded-lg text-center hover:scale-105 transition">';
  echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" class="w-full h-32 object-cover mx-auto mb-2">';
  echo '<p class="mt-2 font-semibold">' . $row['name'] . '</p>';
  echo '</div>';
  echo '</a>';
}
?>
      
    </div>
  </section>

  <!-- Featured Items -->
  <section id="items" class="bg-orange-100 py-12 px-6">
    <h3 class="text-3xl font-bold text-center text-orange-800 mb-8">Featured Products</h3>
    <div class="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto">
      <!-- Item -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <img src="https://source.unsplash.com/400x250/?dog-food" class="w-full h-48 object-cover">
        <div class="p-4">
          <h4 class="text-lg font-bold">Organic Dog Food</h4>
          <p class="text-gray-600">$25.00</p>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <img src="https://source.unsplash.com/400x250/?cat-toy" class="w-full h-48 object-cover">
        <div class="p-4">
          <h4 class="text-lg font-bold">Interactive Cat Toy</h4>
          <p class="text-gray-600">$15.00</p>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <img src="https://source.unsplash.com/400x250/?pet-bed" class="w-full h-48 object-cover">
        <div class="p-4">
          <h4 class="text-lg font-bold">Comfy Pet Bed</h4>
          <p class="text-gray-600">$40.00</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Sales Section -->
  <section class="py-16 bg-gradient-to-r from-yellow-100 to-orange-100 text-center">
    <h3 class="text-4xl font-bold text-orange-700 mb-4">🎉 Summer Sale!</h3>
    <p class="text-lg text-gray-700 mb-6">Up to 50% off on select items.</p>
    <a href="#items" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700">Explore Deals</a>
  </section>

  <!-- Image Slider -->
  <section class="py-12">
    <h3 class="text-3xl font-bold text-center text-orange-700 mb-6">Popular Picks</h3>
    <div class="flex overflow-x-auto gap-6 px-6 snap-x max-w-7xl mx-auto">
      <img src="https://source.unsplash.com/300x200/?puppy" class="snap-start rounded-lg shadow-md">
      <img src="https://source.unsplash.com/300x200/?kitten" class="snap-start rounded-lg shadow-md">
      <img src="https://source.unsplash.com/300x200/?hamster" class="snap-start rounded-lg shadow-md">
      <img src="https://source.unsplash.com/300x200/?parrot" class="snap-start rounded-lg shadow-md">
    </div>
  </section>

  <!-- Contact Us -->
  <section id="contact" class="bg-orange-100 py-16 px-6">
    <div class="max-w-xl mx-auto text-center">
      <h3 class="text-3xl font-bold text-orange-800 mb-4">Contact Us</h3>
      <p class="mb-6 text-gray-700">Have questions? Reach out and we’ll get back to you!</p>
      <form class="space-y-4">
        <input type="text" placeholder="Your Name" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
        <input type="email" placeholder="Email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
        <textarea rows="4" placeholder="Your Message" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
        <button class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Send Message</button>
      </form>
    </div>
  </section>
  <section class="bg-white py-12">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-6">
    <div class="text-center">
      <img src="img/icon-shipping.svg" class="mx-auto mb-4 w-12" />
      <h3 class="text-xl font-semibold">Free Shipping</h3>
      <p class="text-gray-600">On orders above Rs. 2,500</p>
    </div>
    <div class="text-center">
      <img src="img/icon-vet.svg" class="mx-auto mb-4 w-12" />
      <h3 class="text-xl font-semibold">Vet Approved</h3>
      <p class="text-gray-600">Safe & healthy for your pets</p>
    </div>
    <div class="text-center">
      <img src="img/icon-support.svg" class="mx-auto mb-4 w-12" />
      <h3 class="text-xl font-semibold">24/7 Support</h3>
      <p class="text-gray-600">Always here to help</p>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="bg-orange-200 py-4 text-center text-orange-800 text-sm">
    © 2025 PetZone. All rights reserved.
  </footer>
  <?php include 'cart.php'; ?>
</body>
</html>