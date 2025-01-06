<?php
// Include the database connection file
include 'connection.php';

// Add a new driver
if (isset($_POST['add_driver'])) {
    $driver_name = $_POST['driver_name'];
    $driver_license = $_POST['driver_license'];
    $contact_number = $_POST['contact_number'];

    $sql = "INSERT INTO Drivers (driver_name, driver_license, contact_number) 
            VALUES ('$driver_name', '$driver_license', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New driver added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update an existing driver
if (isset($_POST['update_driver'])) {
    $driver_id = $_POST['driver_id'];
    $driver_name = $_POST['driver_name'];
    $driver_license = $_POST['driver_license'];
    $contact_number = $_POST['contact_number'];

    $sql = "UPDATE Drivers 
            SET driver_name='$driver_name', driver_license='$driver_license', contact_number='$contact_number' 
            WHERE driver_id=$driver_id";

    if ($conn->query($sql) === TRUE) {
        echo "Driver updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete a driver
if (isset($_GET['delete'])) {
    $driver_id = $_GET['delete'];

    $sql = "DELETE FROM Drivers WHERE driver_id=$driver_id";
    if ($conn->query($sql) === TRUE) {
        echo "Driver deleted successfully!";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch all drivers to display
$drivers = $conn->query("SELECT * FROM Drivers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Drivers</title>
    <link rel="stylesheet" href="adimin.css">
</head>
<body>
<h2 style="color: red;">Available Drivers</h2>
<table>
    <tr>
        <th>Driver ID</th>
        <th>Driver Name</th>
        <th>License</th>
        <th>Contact Number</th>
        <th>Action</th>
    </tr>

    <?php while($row = $drivers->fetch_assoc()) { ?>
        <tr>
            <td data-label="Driver ID"><?php echo $row['driver_id']; ?></td>
            <td data-label="Driver Name"><?php echo $row['driver_name']; ?></td>
            <td data-label="License"><?php echo $row['driver_license']; ?></td>
            <td data-label="Contact Number"><?php echo $row['contact_number']; ?></td>
            <td data-label="Action">
                <!-- Update Button -->
                <form method="POST" action="managedrivers.php" style="display:inline;">
                    <input type="hidden" name="driver_id" value="<?php echo $row['driver_id']; ?>">
                    <input type="hidden" name="driver_name" value="<?php echo $row['driver_name']; ?>">
                    <input type="hidden" name="driver_license" value="<?php echo $row['driver_license']; ?>">
                    <input type="hidden" name="contact_number" value="<?php echo $row['contact_number']; ?>">
                    <button type="submit" name="update_driver">Update</button>
                </form>

                <!-- Delete Button -->
                <a href="managedrivers.php?delete=<?php echo $row['driver_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this driver?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<h1 style="color: red;">Manage Drivers</h1>

<!-- Form for Adding/Updating Drivers -->
<form method="POST" action="managedrivers.php">
    <input type="hidden" name="driver_id" value="<?php echo isset($_POST['driver_id']) ? $_POST['driver_id'] : ''; ?>">
    
    <label for="driver_name">Driver Name:</label>
    <input type="text" name="driver_name" required value="<?php echo isset($_POST['driver_name']) ? $_POST['driver_name'] : ''; ?>">

    <label for="driver_license">Driver License:</label>
    <input type="text" name="driver_license" required value="<?php echo isset($_POST['driver_license']) ? $_POST['driver_license'] : ''; ?>">

    <label for="contact_number">Contact Number:</label>
    <input type="text" name="contact_number" required value="<?php echo isset($_POST['contact_number']) ? $_POST['contact_number'] : ''; ?>">

    <button type="submit" name="add_driver">Add Driver</button>
    <button type="submit" name="update_driver" style="<?php echo isset($_POST['driver_id']) ? '' : 'display:none;'; ?>">Update Driver</button>
</form>



</body>
</html>
