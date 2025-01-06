<?php
// Include the database connection file
include 'connection.php';
session_start(); // Start the session

// Initialize variables
$error = '';

// Handle the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to find the user
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user ID, role, and username in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];  // Storing username in session

            // Redirect based on role
            if ($_SESSION['role'] == 'admin') {
                header('Location: admin.php'); // Redirect to admin dashboard
            } else {
                header('Location: passenger.php'); // Redirect to passenger dashboard
            }
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="signup.css"> <!-- Link to external CSS file -->
</head>
<body>

    

    <!-- Display error message if exists -->
    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    
    <form method="POST" action="login.php">
    <h1>Login</h1>
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

</body>
</html>
