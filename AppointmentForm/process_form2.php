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
$mobile = $_POST['mobile'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];

// Check if the patient_id is passed and exists in the database
$patient_id = $_POST['patient_id']; 

// Debugging: Check if the patient_id is valid
if (empty($patient_id)) {
    die("Patient ID is missing. Please make sure to provide it.");
}

// Prepare SQL query to update contact information
$sql = "UPDATE appointments SET mobile='$mobile', email='$email', address='$address', city='$city', state='$state' WHERE patient_id='$patient_id'";

// Execute the query and check for errors
if ($conn->query($sql) === TRUE) {
    echo "Contact information updated successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
