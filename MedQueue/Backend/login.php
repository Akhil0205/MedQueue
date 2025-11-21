<?php
require '../db.php';
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $user = $res->fetch_assoc();
    if (password_verify($password, $user["password"])) {
        $_SESSION['user'] = $user; // ✅ store as associative array (not string)
        header("Location: ../index.php");
    } else {
        echo "Invalid password!";
    }
} else {
    echo "User not found!";
}
?>
