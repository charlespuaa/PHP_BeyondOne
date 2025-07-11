<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "etierproducts";

$conn = new mysqli($server, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connection_error);
}