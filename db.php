<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//mongodb+srv://Dev_Quarm:LaGata#1221@cluster0.ckxpq.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0

