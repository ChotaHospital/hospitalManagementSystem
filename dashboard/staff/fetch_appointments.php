<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_db';

// Establish the database connection
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected time slot from the GET request
$timeSlot = isset($_GET['time_slot']) ? $_GET['time_slot'] : 'all';

// SQL query to fetch appointments
if ($timeSlot === 'all') {
    $sql = "SELECT firstname, lastname, doctor, time_slot, department FROM appointments";
} else {
    $sql = "SELECT firstname, lastname, doctor, time_slot, department 
            FROM appointments 
            WHERE time_slot = ?";
}

$stmt = $conn->prepare($sql);

if ($timeSlot !== 'all') {
    $stmt->bind_param("s", $timeSlot);
}

$stmt->execute();
$result = $stmt->get_result();

// Display appointments
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullName = $row['firstname'] . ' ' . $row['lastname'];

        echo "
            <div class='appointment meeting'>
                <div class='patient_name'>$fullName</div>
                <div class='time'>{$row['time_slot']}</div>
                <div class='details'>
                    Meeting with {$row['doctor']}<br /><em>{$row['department']}</em>
                </div>
            </div>
        ";
    }
} else {
    echo "<p>No appointments found for the selected time slot.</p>";
}

$stmt->close();
$conn->close();
?>
