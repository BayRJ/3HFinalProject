<?php
header('Content-Type: application/json');

$servername = "localhost"; // Change this to your server name
$username = "egnjhnrnld"; // Change this to your database username
$password = "16231458910"; // Change this to your database password
$dbname = "booking_system"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT id, name, price, duration, popularity FROM services";
$result = $conn->query($sql);

$services = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

echo json_encode($services);

$conn->close();
?>