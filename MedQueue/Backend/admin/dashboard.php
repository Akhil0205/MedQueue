<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
require '../db.php';

// Get all appointments
$result = $conn->query("SELECT a.*, u.full_name FROM appointments a JOIN users u ON a.user_id = u.id");
$appointments = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <h1 class="text-3xl font-bold mb-6 text-blue-800">🩺 Admin Dashboard</h1>
  <a href="logout.php" class="text-red-600 underline">Logout</a>

  <div class="mt-6 bg-white p-4 rounded shadow">
    <h2 class="text-xl font-semibold mb-3">All Appointments</h2>
    <table class="w-full table-auto">
      <thead class="bg-blue-100">
        <tr>
          <th class="px-3 py-2 text-left">User</th>
          <th class="px-3 py-2 text-left">Department</th>
          <th class="px-3 py-2 text-left">Doctor</th>
          <th class="px-3 py-2 text-left">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($appointments as $appt): ?>
        <tr class="border-b">
          <td class="px-3 py-2"><?= htmlspecialchars($appt['full_name']) ?></td>
          <td class="px-3 py-2"><?= htmlspecialchars($appt['department']) ?></td>
          <td class="px-3 py-2"><?= htmlspecialchars($appt['doctor_name']) ?></td>
          <td class="px-3 py-2"><?= htmlspecialchars($appt['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
