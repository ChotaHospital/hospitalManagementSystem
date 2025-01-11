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
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$patient_id = $_POST['patient_id'] ?? null; // If patient_id is empty, set it to null

// Insert data into appointments table
$sql = "INSERT INTO appointments (firstname, lastname, gender, date_of_birth, patient_id)
        VALUES ('$firstname', '$lastname', '$gender', '$date_of_birth', '$patient_id')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
