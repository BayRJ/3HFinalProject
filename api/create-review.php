<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "egnjhnrnld", "16231458910", "booking_system");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'];
$service_id = $data['service_id'];
$rating = $data['rating'];
$comment = $data['comment'];

$sql = "INSERT INTO reviews (user_id, service_id, rating, comment) VALUES ('$user_id', '$service_id', '$rating', '$comment')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => "Review created successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>