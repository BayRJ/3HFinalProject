<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "egnjhnrnld", "16231458910", "booking_system");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
$service_id = $data['service_id'];
$category_id = $data['category_id'];

$sql = "INSERT INTO service_categories (service_id, category_id) VALUES ('$service_id', '$category_id')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => "Service category created successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>