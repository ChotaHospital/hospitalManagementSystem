<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "HMS");
if (!$conn) {
    die("Failed to connect: " . mysqli_connect_error());
}

// Validate and fetch POST data
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    // Convert username to lowercase
    $username = strtolower(mysqli_real_escape_string($conn, $_POST['username']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if username and password exist and fetch the profile column
    $stmt = $conn->prepare("SELECT profile FROM login WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // "ss" means two strings

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch profile type
        $row = $result->fetch_assoc();
        $profile = $row['profile'];

        // Redirect based on profile type
        if ($profile === 'staff') {
            header("Location: http://localhost/hospitalmanagementsystem/dashboard/staff/dashboard.php");
        } elseif ($profile === 'patient') {
            header("Location: http://localhost/hospitalmanagementsystem/dashboard/patient/dashboard.html");
        } else {
            echo "Invalid profile type!";
        }
        exit(); // Stop script execution after redirection
    } else {
        // Invalid credentials
        echo "Invalid username or password!";
    }

    $stmt->close();
} else {
    echo "Username or Password cannot be empty!";
}

mysqli_close($conn);

?>
