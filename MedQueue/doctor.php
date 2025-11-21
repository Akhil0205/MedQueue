<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Doctor Page - MedQueue</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen">

  <!-- Header -->
  <header class="bg-blue-200 p-4 shadow flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-900">🏥 Smart Doctor Queue</h1>
    <nav class="space-x-4">
      <a href="index.php" class="text-blue-800 hover:underline">Home</a>
      <a href="about.html" class="text-blue-800 hover:underline">About</a>
      <a href="dashboard.php" class="text-blue-800 hover:underline font-semibold">My Dashboard</a>
      <a href="logout.php" class="text-red-700 hover:underline">Logout</a>
    </nav>
  </header>

  <!-- Filter -->
  <div class="p-4 text-center space-x-2">
    <button onclick="filterDoctors('all')" class="bg-gray-300 px-4 py-1 rounded">All</button>
    <button onclick="filterDoctors('General')" class="bg-green-300 px-4 py-1 rounded">General</button>
    <button onclick="filterDoctors('Specialist')" class="bg-blue-300 px-4 py-1 rounded">Specialist</button>
    <button onclick="filterDoctors('Diagnostics')" class="bg-purple-300 px-4 py-1 rounded">Diagnostics</button>
  </div>

  <!-- Doctor Cards -->
  <main class="p-6">
    <div id="doctor-container" class="space-y-10"></div>
  </main>

  <script>
    const doctors = [
      { id: "general", name: "Dr. Sharma", type: "General", specialty: "General Checkup", available: true, img: "d1.png", time: "9AM - 1PM", seats: 12 },
      { id: "emergency", name: "Dr. Meena", type: "Specialist", specialty: "Emergency", available: true, img: "d3.png", time: "24x7", seats: "N/A" },
      { id: "pediatrics", name: "Dr. Anil", type: "General", specialty: "Pediatrics", available: true, img: "d2.png", time: "10AM - 4PM", seats: 10 },
      { id: "orthopedics", name: "Dr. Kavita", type: "Specialist", specialty: "Orthopedics", available: true, img: "d4.png", time: "2PM - 6PM", seats: 8 },
      { id: "dermatology", name: "Dr. Reena", type: "Specialist", specialty: "Dermatology", available: true, img: "d5.png", time: "11AM - 3PM", seats: 9 },
      { id: "cardiology", name: "Dr. Raghav", type: "Diagnostics", specialty: "Cardiology", available: true, img: "d6.png", time: "9AM - 12PM", seats: 6 },
      { id: "neurology", name: "Dr. Swati", type: "Diagnostics", specialty: "Neurology", available: true, img: "d7.png", time: "3PM - 7PM", seats: 4 },
    ];

    function createDoctorCard(doc) {
      const container = document.createElement("div");
      container.className = "bg-white shadow rounded-lg p-6 group hover:bg-blue-50 transition";

      container.innerHTML = `
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
          <div class="flex-1">
            <h3 class="text-xl font-bold text-blue-900 mb-1">${doc.name} - ${doc.specialty}</h3>
            <p class="text-sm text-gray-600 mb-2">Type: <span class="font-semibold">${doc.type}</span></p>
            <div class="text-xs text-gray-600 mb-2">
              <p>⏱️ Timing: ${doc.time}</p>
              <p>🪑 Seats: ${doc.seats}</p>
            </div>

            <form method="POST" action="Backend/book.php" class="bg-gray-100 p-4 rounded space-y-3">
              <input type="hidden" name="doctor_name" value="${doc.name}">
              <input type="hidden" name="department" value="${doc.specialty}">
              <input type="text" name="patient_name" placeholder="Your Name" class="w-full px-2 py-1 border rounded" required>
              <input type="number" name="age" placeholder="Age" class="w-full px-2 py-1 border rounded" required>
              <label class="block text-sm">Emergency?
                <select name="is_emergency" class="w-full mt-1 px-2 py-1 border rounded">
                  <option value="0">No</option>
                  <option value="1">Yes</option>
                </select>
              </label>
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Book Appointment</button>
            </form>
          </div>

          <div class="w-40">
            <img src="/Htmlfiles/images/${doc.img}" alt="${doc.name}" class="w-full rounded shadow-lg" />
          </div>
        </div>
      `;

      container.setAttribute('data-type', doc.type);
      document.getElementById("doctor-container").appendChild(container);
    }

    function filterDoctors(type) {
      const all = document.querySelectorAll('#doctor-container > div');
      all.forEach(card => {
        card.style.display = (type === 'all' || card.dataset.type === type) ? 'block' : 'none';
      });
    }

    // Init
    doctors.forEach(createDoctorCard);
  </script>
</body>
</html>
