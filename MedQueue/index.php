<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome to MedQueue</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50">

  <!-- Navbar -->
  <header class="bg-blue-200 shadow-md py-4 px-8 flex justify-between items-center">
    <div class="text-2xl font-bold text-blue-800 flex items-center gap-2">
      <svg class="w-6 h-6 text-blue-800" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 20a2 2 0 01-2-2v-6H6a2 2 0 01-2-2V8a2 2 0 012-2h2V2a2 2 0 114 0v4h2a2 2 0 012 2v2a2 2 0 01-2 2h-2v6a2 2 0 01-2 2z" />
      </svg>
      MedQueue
    </div>

    <nav class="space-x-6 text-blue-900 font-medium">
      <a href="index.php" class="hover:underline">Home</a>
      <a href="doctor.php" class="hover:underline">Doctor</a>
      <a href="about.php" class="hover:underline">About</a>

      <?php if ($user): ?>
        <a href="dashboard.php" class="hover:underline text-green-700">Dashboard</a>
        <a href="logout.php" class="hover:underline text-red-700">Logout</a>
      <?php else: ?>
        <a href="login.php" class="hover:underline text-blue-600">Login</a>
        <a href="register.php" class="hover:underline text-blue-600">Register</a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-100 text-center py-12 px-6 md:px-20">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-10">
      <!-- Text -->
      <div class="md:w-1/2">
        <h1 class="text-4xl md:text-5xl font-bold text-blue-800 mb-4">Welcome to Our Hospital Queue System</h1>
        <p class="text-lg text-gray-700 mb-4">
          Fast. Digital. Patient-friendly. No more long lines — just smart healthcare.
        </p>

        <p class="text-lg font-semibold text-blue-900 mb-6" id="welcomeText">
          <?= $user ? "Welcome back, " . htmlspecialchars($user['full_name']) . "!" : "Hello, welcome to MedQueue! Please register or login to continue." ?>
        </p>

        <?php if (!$user): ?>
        <div class="flex gap-4 justify-center md:justify-start">
          <a href="register.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition hover:scale-105">Register</a>
          <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition hover:scale-105">Login</a>
        </div>
        <?php endif; ?>
      </div>

      <!-- Image -->
      <div class="md:w-1/2">
        <img src="/images/doctors.jpg" alt="Doctors" class="w-full max-w-md mx-auto rounded-xl shadow-lg" />
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-12 text-center bg-white">
    <h2 class="text-3xl font-bold text-blue-800 mb-6">Key Features of MedQueue</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 max-w-5xl mx-auto">
      <div class="bg-gray-200 p-6 rounded-lg shadow-md hover:shadow-lg">
        <h3 class="text-xl font-semibold text-blue-800">Digital Queue</h3>
        <p class="text-gray-600">Seamless token-based digital appointment system.</p>
      </div>
      <div class="bg-gray-200 p-6 rounded-lg shadow-md hover:shadow-lg">
        <h3 class="text-xl font-semibold text-blue-800">24/7 Access</h3>
        <p class="text-gray-600">Book appointments any time from anywhere.</p>
      </div>
      <div class="bg-gray-200 p-6 rounded-lg shadow-md hover:shadow-lg">
        <h3 class="text-xl font-semibold text-blue-800">Real-Time Tracking</h3>
        <p class="text-gray-600">See live queue updates and timings.</p>
      </div>
    </div>
  </section>

</body>
</html>
