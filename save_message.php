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
<?php
$secretKey = "YOUR_SECRET_KEY"; 
$responseKey = $_POST['g-recaptcha-response'];
$remoteIP = $_SERVER['REMOTE_ADDR'];

$googleURL = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$remoteIP";
$response = file_get_contents($googleURL);
$responseKeys = json_decode($response, true);

if ($responseKeys["success"]) {
    echo "reCAPTCHA verified!";
} else {
    echo "Failed reCAPTCHA verification.";
}
?>


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