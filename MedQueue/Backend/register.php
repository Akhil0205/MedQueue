<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $username, $password);

    if ($stmt->execute()) {
        header("Location: ../login.php");
    } else {
        echo "Registration failed: " . $stmt->error;
    }
}
?>
