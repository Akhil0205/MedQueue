<?php
session_start();
require '../db.php';

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    die("Unauthorized access.");
}

$user = $_SESSION['user'];
if (is_string($user)) {
    $user = json_decode($user, true);
}

// Collect form data
$doctorName = $_POST['doctor_name'] ?? '';
$department = $_POST['department'] ?? '';
$patientName = $_POST['patient_name'] ?? '';
$age = $_POST['age'] ?? 0;
$isEmergency = isset($_POST['is_emergency']) && $_POST['is_emergency'] == "1" ? 1 : 0;

// Input validation
if (!$doctorName || !$department || !$patientName || !$age) {
    die("❌ Missing required fields.");
}

// Step 1: Insert the appointment
$stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_name, department, patient_name, age, is_emergency) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssii", $user['id'], $doctorName, $department, $patientName, $age, $isEmergency);

if (!$stmt->execute()) {
    die("❌ Error booking appointment: " . $stmt->error);
}

$appointmentId = $stmt->insert_id;
$stmt->close();

// Step 2: Generate token number for queue
// Count how many appointments already exist for this department (basic circular simulation)
$countQuery = $conn->query("SELECT COUNT(*) AS count FROM appointments WHERE department = '$department'");
$countRow = $countQuery->fetch_assoc();
$tokenNumber = ($countRow['count']) % 100 + 1; // Circular reset at 100

// Step 3: Insert into queue table
$stmt2 = $conn->prepare("INSERT INTO queue (appointment_id, token_number) VALUES (?, ?)");
$stmt2->bind_param("ii", $appointmentId, $tokenNumber);
if (!$stmt2->execute()) {
    die("❌ Error adding to queue: " . $stmt2->error);
}
$stmt2->close();

// ✅ Redirect to dashboard or confirmation page
header("Location: ../dashboard.php");
exit();
?>
