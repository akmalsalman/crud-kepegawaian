<?php
require 'db_connection.php';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "DELETE FROM departemen WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: departemen.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>