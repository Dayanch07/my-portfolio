<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_messages";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// reCAPTCHA verification
$recaptchaSecret = '6LcnyuwqAAAAAPjFDYNm2xWTJssUODkXqQZJt2bH';
$recaptchaResponse = $_POST['g-recaptcha-response'];

$recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
$response = file_get_contents($recaptchaVerifyUrl . "?secret=" . $recaptchaSecret . "&response=" . $recaptchaResponse);
$responseKeys = json_decode($response, true);

if (intval($responseKeys["success"]) !== 1) {
    echo json_encode(['success' => false, 'error' => 'reCAPTCHA verification failed']);
    exit;
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prevent SQL injection with prepared statements
$stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>