<?php
// Include the database connection file
include 'connection.php';

$error = ''; // Initialize an error variable
$success = ''; // Initialize a success message variable

// Handle the registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to insert a new user
    $sql = "INSERT INTO Users (username, password, email, role) 
            VALUES ('$username', '$hashed_password', '$email', '$role')";

    if ($conn->query($sql) === TRUE) {
        $success = "Registration successful! You can now log in.";
    } else {
        $error = "Error: " . $conn->error; // Display error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="signup.css"> <!-- Link to external CSS file -->
</head>
<body>

    

    <!-- Display success message if exists -->
    <?php if ($success): ?>
    <?php echo "<script>
        alert('You Registered successfully!');
        window.location.href = 'login.php';
    </script>"; ?>
<?php endif; ?>


    <!-- Display error message if exists -->
    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>
  
    <!-- Registration Form -->
    <form method="POST" action="register.php">
    <h1>Registration</h1>
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="role">Role:</label>
        <select name="role" required>
            <option value="passenger">Passenger</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Register</button>
    </form>

</body>
</html>
