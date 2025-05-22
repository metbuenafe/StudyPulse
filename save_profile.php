<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Get the POSTed JSON data
$input = json_decode(file_get_contents('php://input'), true);

// You should validate/sanitize all inputs here
$user_id = $_SESSION['user_id'];
$firstName = $input['firstName'];
$lastName = $input['lastName'];
$email = $input['email'];
$dob = $input['dob'];
$contact = $input['contact'];
$course = $input['course'];
$address = $input['address'];
$profilePhoto = $input['profilePhoto'];

// TODO: Connect to your database (mysqli or PDO)
// Example with PDO:
try {
    $pdo = new PDO('mysql:host=localhost;dbname=your_db', 'db_user', 'db_password');

    $stmt = $pdo->prepare("UPDATE users SET 
        first_name = ?, last_name = ?, email = ?, dob = ?, contact = ?, course = ?, address = ?, profile_photo = ?
        WHERE id = ?");
    $stmt->execute([$firstName, $lastName, $email, $dob, $contact, $course, $address, $profilePhoto, $user_id]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>