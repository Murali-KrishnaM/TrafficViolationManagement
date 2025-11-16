<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "traffic_violation_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if vehicle_id is provided
if (!isset($_GET['vehicle_id']) || empty($_GET['vehicle_id'])) {
    die("<h3>No vehicle ID provided.</h3>");
}

$vehicle_id = $_GET['vehicle_id'];

// Prepare SQL query
$stmt = $conn->prepare("SELECT * FROM Violation WHERE vehicle_id = ?");
$stmt->bind_param("s", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<div class='container my-5'>";
echo "<h1>Violations for Vehicle ID: $vehicle_id</h1>";

if ($result->num_rows > 0) {
    echo "<table class='table table-striped table-hover mt-3'>
            <thead>
              <tr>
                <th>Violation ID</th>
                <th>Violation Type</th>
                <th>Date</th>
                <th>Fine Amount</th>
                <th>Payment Status</th>
              </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['violation_id']}</td>
                <td>{$row['violation_type']}</td>
                <td>{$row['violation_date']}</td>
                <td>₹{$row['fine_amount']}</td>
                <td>{$row['payment_status']}</td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<h3>No violations found for this vehicle.</h3>";
}

$stmt->close();
$conn->close();
echo "</div>";
?>
