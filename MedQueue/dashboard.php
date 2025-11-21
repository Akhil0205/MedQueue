<?php
session_start();
require 'db.php';

// Recover user from session if stringified
$user = $_SESSION['user'];
if (is_string($user)) {
    $user = json_decode($user, true);
    $_SESSION['user'] = $user;
}

// Protect access
if (!isset($user['id'])) {
    header("Location: login.php");
    exit();
}

// Join appointments and queue
$stmt = $conn->prepare("
    SELECT 
        a.doctor_name, 
        a.department, 
        a.created_at, 
        q.token_number
    FROM appointments a
    LEFT JOIN queue q ON a.id = q.appointment_id
    WHERE a.user_id = ?
    ORDER BY a.created_at DESC
");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - MedQueue</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen">

  <!-- Header -->
  <header class="bg-blue-200 p-4 shadow flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-900">🏥 MedQueue Dashboard</h1>
    <nav class="space-x-4 text-blue-900 font-medium">
      <a href="index.php" class="hover:underline">Home</a>
      <a href="logout.php" class="hover:underline text-red-700">Logout</a>
    </nav>
  </header>

  <!-- Welcome Message -->
  <section class="p-6 text-center">
    <h2 class="text-3xl font-bold text-blue-800">👋 Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h2>
    <p class="text-gray-600">Here are your booked appointments with token numbers.</p>
  </section>

  <!-- Appointments Table -->
  <main class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <?php if (count($appointments) > 0): ?>
      <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-blue-100 text-blue-800">
            <th class="px-4 py-2 text-left">Doctor</th>
            <th class="px-4 py-2 text-left">Department</th>
            <th class="px-4 py-2 text-left">Token</th>
            <th class="px-4 py-2 text-left">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appointments as $appt): ?>
            <tr class="border-b hover:bg-blue-50">
              <td class="px-4 py-2"><?= htmlspecialchars($appt['doctor_name']) ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($appt['department']) ?></td>
              <td class="px-4 py-2 text-blue-700 font-bold"><?= $appt['token_number'] ?? '—' ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($appt['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-gray-600 text-center">You haven't booked any appointments yet.</p>
    <?php endif; ?>
  </main>

</body>
</html>
