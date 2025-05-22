<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Include the MySQLi connection from db.php
require_once 'db.php'; // This sets up $conn

$input = json_decode(file_get_contents('php://input'), true);

$firstName    = isset($input['firstName'])    ? trim($input['firstName'])    : '';
$lastName     = isset($input['lastName'])     ? trim($input['lastName'])     : '';
$email        = isset($input['email'])        ? trim($input['email'])        : '';
$dob          = isset($input['dob'])          ? trim($input['dob'])          : '';
$contact      = isset($input['contact'])      ? trim($input['contact'])      : '';
$course       = isset($input['course'])       ? trim($input['course'])       : '';
$address      = isset($input['address'])      ? trim($input['address'])      : '';
$profilePhoto = isset($input['profilePhoto']) ? trim($input['profilePhoto']) : '';
$user_id      = $_SESSION['user_id'];

try {
    // Prepare an UPDATE statement
    $stmt = $conn->prepare("UPDATE users SET 
        first_name=?, last_name=?, email=?, dob=?, contact=?, course=?, address=?, profile_photo=?
        WHERE id=?");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssssssi", $firstName, $lastName, $email, $dob, $contact, $course, $address, $profilePhoto, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . $stmt->error]);
    }
    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();
?>