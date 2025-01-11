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

// Get POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if 'ids' are provided
if (isset($data['ids']) && is_array($data['ids'])) {
    $ids = array_map('intval', $data['ids']);
    $idList = implode(',', $ids); // Prepare the list of IDs to delete

    // SQL delete query
    $sql = "DELETE FROM appointments WHERE id IN ($idList)";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => count($ids) . ' appointments deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting appointments.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

$conn->close();
?>
