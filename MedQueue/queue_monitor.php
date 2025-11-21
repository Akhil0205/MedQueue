<?php
require 'db.php';

// Get list of all doctors with queues
$sql = "
SELECT 
    a.doctor_name,
    a.department,
    MAX(q.token_number) as last_token,
    COUNT(q.id) as total_queue
FROM appointments a
JOIN queue q ON a.id = q.appointment_id
GROUP BY a.doctor_name, a.department
ORDER BY a.department
";
$result = $conn->query($sql);
$queues = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Queue Monitor - MedQueue</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen">

  <!-- Header -->
  <header class="bg-blue-200 p-4 shadow flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-900">📊 Queue Monitor</h1>
    <nav class="space-x-4 text-blue-900 font-medium">
      <a href="index.php" class="hover:underline">Home</a>
      <a href="dashboard.php" class="hover:underline">Dashboard</a>
    </nav>
  </header>

  <section class="p-6">
    <h2 class="text-xl font-bold text-center text-blue-800 mb-6">🔄 Current Token Queue Status</h2>

    <?php if (count($queues) > 0): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
        <?php foreach ($queues as $q): ?>
          <div class="bg-white shadow-md p-6 rounded-lg border-l-4 border-blue-500">
            <h3 class="text-xl font-semibold text-blue-800"><?= htmlspecialchars($q['doctor_name']) ?></h3>
            <p class="text-gray-600 mb-2">🧪 Department: <strong><?= htmlspecialchars($q['department']) ?></strong></p>
            <p class="text-green-700 font-bold text-lg">Last Token: <?= $q['last_token'] ?></p>
<p class="text-sm text-gray-700 mb-3">Total in Queue: <?= $q['total_queue'] ?></p>

<form onsubmit="callNextToken(event, '<?= $q['doctor_name'] ?>', '<?= $q['department'] ?>')">
  <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">Call Next</button>
</form>
<div id="result-<?= md5($q['doctor_name'] . $q['department']) ?>" class="text-sm mt-2 text-gray-700"></div>

          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-600">No active queues at the moment.</p>
    <?php endif; ?>
  </section>
  <script>
function callNextToken(e, doctor, department) {
  e.preventDefault();

  fetch('Backend/call_next.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `doctor=${encodeURIComponent(doctor)}&department=${encodeURIComponent(department)}`
  })
  .then(res => res.json())
  .then(data => {
    const key = doctor + department;
    const resultId = 'result-' + md5(key);
    document.getElementById(resultId).textContent = data.message;
    setTimeout(() => location.reload(), 2000);
  });
}

// Simple JS hash (MD5-like) to match PHP md5()
function md5(str) {
  return btoa(unescape(encodeURIComponent(str))).slice(0, 12).replace(/[^a-z0-9]/gi, '');
}
</script>

</body>
</html>
