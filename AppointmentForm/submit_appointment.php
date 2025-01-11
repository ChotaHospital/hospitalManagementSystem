<?php
// Database configuration
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "hospital_db"; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $patientId = $_POST['patient-id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $department = $_POST['department'];
    $doctor = $_POST['doctor'];
    $timeSlot = $_POST['time-slot'];

    // Construct the address field
    $address = $street . ", " . $city . ", " . $state;

    // Prepare SQL query to insert data
    $sql = "INSERT INTO appointments (firstname, lastname, gender, date_of_birth, patient_id, mobile, email, address, city, state, department, doctor, time_slot)
            VALUES ('$firstName', '$lastName', '$gender', '$dob', '$patientId', '$phone', '$email', '$address', '$city', '$state', '$department', '$doctor', '$timeSlot')";

    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/hospitalmanagementsystem/AppointmentForm/confirmationPage.html");
    exit();

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
