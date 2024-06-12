<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "1234"; // Your MySQL password
$dbname = "contact_form_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) &&
        isset($_POST['address']) && isset($_POST['dob']) && isset($_POST['gender'])) {
        
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, address, dob, gender) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssssss", $name, $phone, $email, $address, $dob, $gender);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "All form fields are required.";
    }
}

$conn->close();
?>
