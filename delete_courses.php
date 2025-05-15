<?php
include 'db.php';

$id = $_GET['id'];

$conn->query("DELETE FROM courses WHERE id = $id");

echo json_encode(["status" => "deleted"]);
?>
