<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "egnjhnrnld", "16231458910", "booking_system");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);
$email = $data['email'];

$sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => "User created successfully"]);
} else {
    echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
}

$conn->close();
?>