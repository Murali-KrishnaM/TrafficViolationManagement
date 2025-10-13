<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "traffic_violation_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (!isset($_GET['vehicle_id']) || empty($_GET['vehicle_id'])) {
    echo "<tr><td colspan='5'>No Vehicle ID provided.</td></tr>";
    exit();
}

$vehicle_id = $_GET['vehicle_id'];
$stmt = $conn->prepare("SELECT * FROM Violation WHERE vehicle_id = ?");
$stmt->bind_param("s", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['violation_id']}</td>
                <td>{$row['violation_type']}</td>
                <td>{$row['violation_date']}</td>
                <td>₹{$row['fine_amount']}</td>
                <td>{$row['payment_status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No violations found for this vehicle.</td></tr>";
}

$stmt->close();
$conn->close();
?>
