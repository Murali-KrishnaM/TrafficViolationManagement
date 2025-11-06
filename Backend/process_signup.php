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
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    // Check if username already exists (Prevent duplicates)
    $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Redirect with an error message if username exists
        header("Location: ../signup.html?error=user_exists");
        exit();
    }
    $check_stmt->close();

    // Insert New User
    $stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $user_type);

    if ($stmt->execute()) {
        // ✅ Show a pop-up and redirect to login page using JavaScript
        echo "<script>
                alert('Account created successfully!');
                window.location.href = '../login.html';
              </script>";
              flush();
              header("Location: ../login.html");
        exit();
    } else {
        // Redirect to signup page with an error message
        header("Location: ../signup.html?error=signup_failed");
        exit();
    }
    $stmt->close();
}
$conn->close();
?>
