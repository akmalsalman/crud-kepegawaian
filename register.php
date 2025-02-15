<?php
require 'db_connection.php';


$username = "admin"; 
$hashed_password = password_hash($password, PASSWORD_DEFAULT); 

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "User berhasil ditambahkan!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
