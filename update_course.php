<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$name = $data['name'];
$prelim = $data['prelim'];
$midterm = $data['midterm'];
$final = $data['final'];

$stmt = $conn->prepare("UPDATE courses SET name = ?, prelim = ?, midterm = ?, final = ? WHERE id = ?");
$stmt->bind_param("siiii", $name, $prelim, $midterm, $final, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
