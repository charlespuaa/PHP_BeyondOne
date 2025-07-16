<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "etierproducts"; // or "etierregistration" if you want to connect to the registration database

$conn = new mysqli($server, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connection_error);
}