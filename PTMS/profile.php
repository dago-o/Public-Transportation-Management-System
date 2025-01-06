<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You need to log in to access your profile.";
    exit();
}

include "connection.php";

// Fetch user data
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password before storing
    $email = $_POST['email'];

    // Update user data in the database
    $stmt = $conn->prepare("UPDATE users SET username=?, password=?, email=? WHERE username=?");
    $stmt->bind_param("ssss", $username, $password, $email, $_SESSION['username']);

    if ($stmt->execute()) {
        // Success message and redirect
        echo "<script>alert('Profile updated successfully!');</script>";
        echo "<script>window.location.href = 'passenger.php';</script>";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="boardes.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #333;
            margin: 0;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            /* Aligns form to the left */
            margin-left: 0; 
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color:cornflowerblue;
            color: white;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
        <img class="logoimage" src="profile.png" alt="Logo"
        style="width: 100px; border: 4px solid green;
        border-radius:50%">
            <h2>Profile</h2>
        </div>
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label  for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br>

            <label  for="password">Password:</label>
            <input type="password" id="password" name="password" value=""><br>

            <label  for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>

            <input type="submit" name="submit" value="Update">
        </form>
    </div>
</body>
</html>
