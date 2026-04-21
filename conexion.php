<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "xiaomi_sv";

$conn = new mysqli("localhost", "root", "", "xiaomi_sv");
if ($conn->connect_error) { die("Error: " . $conn->connect_error); }
// Establecer charset para evitar problemas con tildes y ñ
$conn->set_charset("utf8");
?>