<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "traffic_violation_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $vehicle_id = isset($_POST['vehicle_id']) ? trim($_POST['vehicle_id']) : '';
    $owner_name = isset($_POST['owner_name']) ? trim($_POST['owner_name']) : '';
    $vehicle_model = isset($_POST['vehicle_model']) ? trim($_POST['vehicle_model']) : '';
    $violation_type = isset($_POST['violation_type']) ? trim($_POST['violation_type']) : '';
    $violation_date = isset($_POST['violation_date']) ? trim($_POST['violation_date']) : '';
    $fine_amount = isset($_POST['fine_amount']) ? (int)$_POST['fine_amount'] : 0;
    $payment_status = isset($_POST['payment_status']) ? trim($_POST['payment_status']) : '';

    // Ensure payment_status is either "Pending" or "Paid"
    if (!in_array($payment_status, ['Pending', 'Paid'])) {
        header("Location: ../add_violation.html?error=1");
        exit();
    }

    // Check if required fields are filled
    if (empty($vehicle_id) || empty($owner_name) || empty($vehicle_model) || empty($violation_type) || empty($violation_date) || empty($fine_amount)) {
        header("Location: ../add_violation.html?error=1");
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO Violation (vehicle_id, owner_name, vehicle_model, violation_type, violation_date, fine_amount, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssis", $vehicle_id, $owner_name, $vehicle_model, $violation_type, $violation_date, $fine_amount, $payment_status);

    // Execute statement and handle errors
    if ($stmt->execute()) {
        header("Location: ../add_violation.html?success=1");
        exit();
    } else {
        header("Location: ../add_violation.html?error=1");
        exit();
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
