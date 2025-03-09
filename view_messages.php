<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_messages";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, email, message, created_at FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);

echo "<h2>Messages Received</h2>";
echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Received At</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["message"] . "</td><td>" . $row["created_at"] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>No messages yet</td></tr>";
}

echo "</table>";
$conn->close();
?>