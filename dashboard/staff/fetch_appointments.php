<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT firstname, lastname, doctor, time_slot, department FROM appointments";
$result = $conn->query($sql);

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
    echo "<p>No appointments scheduled for today.</p>";
}

$conn->close();
?>
