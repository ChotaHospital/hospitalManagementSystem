<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "hospital_db"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from POST request
$department = $_POST['department'];
$doctor = $_POST['doctor'];
$time_slot = $_POST['time_slot'];

// Update appointment with department, doctor, and time slot
$patient_id = $_POST['patient_id']; // Use the same patient_id from form1 if it's needed

$sql = "UPDATE appointments SET department='$department', doctor='$doctor', time_slot='$time_slot' WHERE patient_id='$patient_id'";

if ($conn->query($sql) === TRUE) {
    echo "Appointment updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
