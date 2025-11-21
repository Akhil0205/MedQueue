<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - MedQueue</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">

  <form action="Backend/login.php" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-md space-y-4">
    <h2 class="text-2xl font-bold text-blue-800 mb-4 text-center">🔐 Patient Login</h2>

    <input name="username" type="text" placeholder="Username" class="w-full px-4 py-2 border rounded" required>
    <input name="password" type="password" placeholder="Password" class="w-full px-4 py-2 border rounded" required>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>

    <p class="text-sm text-center">No account? <a href="register.php" class="text-blue-700 underline">Register</a></p>
  </form>

</body>
</html>
