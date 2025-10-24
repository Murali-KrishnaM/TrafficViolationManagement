<?php
session_start();
include 'db_connection.php'; // Make sure this file exists and connects properly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $user_type = $_POST['user_type'];

    // Validate if fields are empty
    if (empty($username) || empty($password) || empty($user_type)) {
        header("Location: ../login.html?error=empty_fields");
        exit();
    }

    // Query to check user
    $query = "SELECT user_id, username, password, user_type FROM users WHERE username=? AND user_type=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Store user session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            
            // Redirect based on user type
            if ($user['user_type'] === 'officer') {
                header("Location: ../officer_dashboard.html");
            } else {
                header("Location: ../civilian_dashboard.html");
            }
            exit();
        } else {
            header("Location: ../login.html?error=incorrect_password");
            exit();
        }
    } else {
        header("Location: ../login.html?error=user_not_found");
        exit();
    }
}

$conn->close();
?>
