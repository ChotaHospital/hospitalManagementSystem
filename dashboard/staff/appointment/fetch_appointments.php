<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_db';

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch appointments
$sql = "SELECT id, firstname, lastname, gender, date_of_birth, mobile, doctor, time_slot, department FROM appointments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullName = $row['firstname'] . ' ' . $row['lastname'];
        $age = date_diff(date_create($row['date_of_birth']), date_create('today'))->y;

        echo "
        <div class='appointment-card' data-id='{$row['id']}' data-status='scheduled'>
            <label class='select-checkbox-wrapper'>
                <input type='checkbox' class='select-checkbox'>
            </label>
            <div class='card-header'>
                <div class='patient-info'>
                    <img src='https://i0.wp.com/sbcf.fr/wp-content/uploads/2018/03/sbcf-default-avatar.png?w=300&ssl=1' alt='$fullName' class='patient-photo'>
                    <h4>$fullName</h4>
                    <p id='age'>Age : $age yrs</p>
                </div>
                <p id='time'>{$row['time_slot']}</p>
            </div>
            <div class='card-details'>
                <p id='fontt'><strong>Doctor:</strong> {$row['doctor']}</p>
                <p id='fontt'><strong>Department:</strong> {$row['department']}</p>
                <p id='fontt'><strong>Contact:</strong> {$row['mobile']}</p>
                <br>
            </div>
            <button class='toggle-details'>View Details</button>
        </div>
        ";
    }
} else {
    echo "<p>No appointments scheduled for today.</p>";
}

$conn->close();
?>
