<?php
include 'db.php';

$user_id = $_GET['user_id'];

$result = $conn->query("SELECT * FROM courses WHERE user_id = $user_id");

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode($courses);
?>
