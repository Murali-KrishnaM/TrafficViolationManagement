<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "traffic_violation_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check for Connection Errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure Request is a POST Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $violation_id = $_POST['violation_id'];
    $payment_amount = $_POST['payment_amount'];

    // Verify if violation exists and get fine details
    $stmt = $conn->prepare("SELECT fine_amount, payment_status FROM violation WHERE violation_id = ?");
    $stmt->bind_param("i", $violation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fine_amount = $row['fine_amount']; // Correct variable usage

        // Check if already paid
        if ($row['payment_status'] === 'Paid') {
            echo "<script>
                    alert('Fine already Paid!');
                    window.location.href = '../pay_violation.html';
                  </script>";
            exit();
        } 

        // Check for partial payment
        if ($payment_amount < $fine_amount) {
            $new_fine_amount = $fine_amount - $payment_amount;
            $update_query = "UPDATE violation SET fine_amount = ?, payment_status = 'Pending' WHERE violation_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("di", $new_fine_amount, $violation_id);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Partial payment of $payment_amount accepted. Remaining fine amount: $new_fine_amount.');
                        window.location.href = '../civilian_dashboard.html';
                      </script>";
                exit();
            } else {
                echo "Error updating fine amount: " . $stmt->error;
            }
        } else {
            // Full payment case
            $update_stmt = $conn->prepare("UPDATE violation SET payment_status = 'Paid', fine_amount = 0 WHERE violation_id = ?");
            $update_stmt->bind_param("i", $violation_id);
            if ($update_stmt->execute()) {
                echo "<script>
                        alert('Payment Successful!');
                        window.location.href = '../civilian_dashboard.html';
                      </script>";
                exit();
            } else {
                echo "Error processing payment.";
            }
            $update_stmt->close();
        }
    } else {
        echo "<script>
                alert('Violation ID not found.');
                window.location.href = '../pay_violation.html';
              </script>";
        exit();
    }
    $stmt->close();
}
$conn->close();
?>
