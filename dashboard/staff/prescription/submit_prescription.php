<?php

// Display errors for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Include the FPDF library
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

// Create an instance of your extended PDF class
$pdf = new PDF();


// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_db';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Safely get and sanitize form data
$doctorName = isset($_POST['doctorName']) ? mysqli_real_escape_string($conn, $_POST['doctorName']) : '';
$firstName = isset($_POST['first_name']) ? mysqli_real_escape_string($conn, $_POST['first_name']) : '';
$lastName = isset($_POST['last_name']) ? mysqli_real_escape_string($conn, $_POST['last_name']) : '';
$dob = isset($_POST['dob']) ? mysqli_real_escape_string($conn, $_POST['dob']) : '';
$age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
$gender = isset($_POST['gender']) ? substr(mysqli_real_escape_string($conn, $_POST['gender']), 0, 1) : ''; 
$mobile = isset($_POST['mobile']) ? mysqli_real_escape_string($conn, $_POST['mobile']) : '';
$address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';
$diagnosedWith = isset($_POST['diagnosedWith']) ? mysqli_real_escape_string($conn, $_POST['diagnosedWith']) : '';
$bloodPressure = isset($_POST['bloodPressure']) ? mysqli_real_escape_string($conn, $_POST['bloodPressure']) : '';
$pulseRate = isset($_POST['pulseRate']) ? mysqli_real_escape_string($conn, $_POST['pulseRate']) : '';
$weight = isset($_POST['weight']) ? mysqli_real_escape_string($conn, $_POST['weight']) : '';
$height = isset($_POST['height']) ? mysqli_real_escape_string($conn, $_POST['height']) : '';
$chiefComplaints = isset($_POST['chiefComplaints']) ? mysqli_real_escape_string($conn, $_POST['chiefComplaints']) : '';
$clinicalFindings = isset($_POST['clinicalFindings']) ? mysqli_real_escape_string($conn, $_POST['clinicalFindings']) : '';
$medications = isset($_POST['medications']) && is_array($_POST['medications']) ? $_POST['medications'] : [];
$advice = isset($_POST['advice']) ? mysqli_real_escape_string($conn, $_POST['advice']) : '';
$followUp = isset($_POST['followUp']) ? mysqli_real_escape_string($conn, $_POST['followUp']) : '';
$info = isset($_POST['info']) ? mysqli_real_escape_string($conn, $_POST['info']) : '';
$info = str_replace("\\n", "\n", $info); // Convert literal "\n" to actual newlines
$info = str_replace("\\r", "", $info); // Convert literal "\n" to actual newlines

// Ensure that $dob and $followUp are in a valid date format before formatting
if ($dob) {
    $dob = (new DateTime($dob))->format('d-m-Y'); // Format DOB as dd-mm-yy
}

if ($followUp) {
    $followUp = (new DateTime($followUp))->format('d-m-Y'); // Format Follow-up as dd-mm-yy
}



// Check if medications data exists
if (empty($medications)) {
    die("Error: Medications data is missing.");
}

// Create the prescriptions directory if it doesn't exist
$prescriptionDir = 'prescriptions';
if (!is_dir($prescriptionDir)) {
    mkdir($prescriptionDir, 0777, true);
}

// Generate PDF using FPDF


$date = date('d-m-Y');


$pdf = new PDF();
$pdf->AddPage();

// Header Section
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, "Chota Hospital", 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, "B/503, Business Center, MG Road, Pune - 411000", 0, 1, 'C');
$pdf->Cell(0, 7, "Ph: 5465647658, Timing: 09:00 AM - 12:00 PM, 01:00 PM - 04:00PM, 05:00 PM - 09:00 PM", 0, 1, 'C');
$pdf->Cell(0, 7, "Closed: Sunday", 0, 1, 'C');
$pdf->Ln(10);

$pdf->Line(10, $pdf->GetY() + 5, 200, $pdf->GetY() + 5);
$pdf->Ln(10);

// Doctor and Patient Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, "Doctor: $doctorName", 0, 0, 'L');
$pdf->Cell(0, 7, "Date: $date", 0, 1, 'R');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, "Patient: $firstName $lastName ($gender)", 0, 1);
$pdf->Cell(0, 7, "DOB: $dob", 0, 1);
$pdf->Cell(0, 7, "Age: $age Y", 0, 1);
$pdf->Cell(0, 7, "Blood Pressure: $bloodPressure mm Hg | Pulse Rate: $pulseRate bpm", 0, 1);
$pdf->Cell(0, 7, "Weight: $weight kg", 0, 1);
$pdf->Ln(10);


// Diagnosis
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, "Diagnosis:", 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 7, $diagnosedWith);
$pdf->Ln(10);

// Medications Table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, "Medications:", 0, 1);

// Header for Medications Table
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(80, 7, "Medicine Name", 1, 0, 'C');
$pdf->Cell(40, 7, "Dosage", 1, 0, 'C');
$pdf->Cell(40, 7, "Remarks", 1, 0, 'C');
$pdf->Ln();

// Iterate over medications and print each row in the table
$pdf->SetFont('Arial', '', 10);



foreach ($medications as $medication) {
    $cellWidths = [80, 40, 40]; // Define widths for each column
    $cellData = [$medication['name'], $medication['dosage'], $medication['remark']];

    // Calculate the maximum number of lines in the row
    $maxLines = 0;
    foreach ($cellData as $i => $data) {
        $maxLines = max($maxLines, $pdf->NbLines($cellWidths[$i], $data));
    }

    $rowHeight = $maxLines * 5; // Adjust row height based on line count and line spacing

    // Draw the cells with consistent height
    foreach ($cellData as $i => $data) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Draw the cell as a rectangle
        $pdf->Rect($x, $y, $cellWidths[$i], $rowHeight);
        $pdf->MultiCell($cellWidths[$i], 5, $data, 0, 'L');

        // Move the cursor to the next cell's position
        $pdf->SetXY($x + $cellWidths[$i], $y);
    }

    // Move the cursor to the start of the next row
    $pdf->Ln($rowHeight);
}



// Add some space before the Additional Info section
$pdf->Ln(10);  

// Additional Info Section for the patient
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, "Additional Information for Patient:", 0, 1);

// Display Patient's Additional Info (e.g., from the info input)
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 7, $info); // MultiCell will now handle newlines correctly
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, "Follow UP: $followUp", 0, 1);



// Save the PDF to the "prescriptions" directory with a unique name
$pdfPath = $prescriptionDir . "/" . uniqid() . ".pdf";
$pdf->Output('F', $pdfPath);

// Get Patient ID
$patientId = isset($_POST['patient_id']) ? mysqli_real_escape_string($conn, $_POST['patient_id']) : '';

// Check if patient ID and name are valid
$patientName = $firstName . " " . $lastName;
if (empty($patientName) || empty($patientId)) {
    die("Error: Patient name or patient ID is missing.");
}

// Prepare medications data for storage (serialize or JSON encode the array)
$medicationsData = json_encode($medications);

// Insert the prescription details into the database
$stmt = $conn->prepare("INSERT INTO prescriptions (doctor_name, patient_id, medications, patient_name, pdf_path) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $doctorName, $patientId, $medicationsData, $patientName, $pdfPath);

// Execute the query and handle success or failure
if ($stmt->execute()) {
    echo "Prescription saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();


?>


