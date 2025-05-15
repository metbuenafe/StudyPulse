<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'];
$name = $data['name'];
$prelim = $data['prelim'];
$midterm = $data['midterm'];
$final = $data['final'];

$stmt = $conn->prepare("INSERT INTO courses (user_id, name, prelim, midterm, final) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isiii", $user_id, $name, $prelim, $midterm, $final);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
