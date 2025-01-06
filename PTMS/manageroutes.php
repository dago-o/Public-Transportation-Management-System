<?php
// Include the database connection file
include 'connection.php';

// Variables to hold form values (for pre-populating in case of updates)
$update = false;
$route_id = '';
$origin = '';
$destination = '';
$distance = '';
$fare = '';

// Add a new route
if (isset($_POST['add_route'])) {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $distance = $_POST['distance'];
    $fare = $_POST['fare'];

    $sql = "INSERT INTO Routes (origin, destination, distance, route_fare) 
            VALUES ('$origin', '$destination', $distance, $fare)";

    if ($conn->query($sql) === TRUE) {
        echo "New route added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update an existing route
if (isset($_POST['update_route'])) {
    $route_id = $_POST['route_id'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $distance = $_POST['distance'];
    $fare = $_POST['fare'];

    $sql = "UPDATE Routes 
            SET origin='$origin', destination='$destination', distance=$distance, route_fare=$fare 
            WHERE route_id=$route_id";

    if ($conn->query($sql) === TRUE) {
        echo "Route updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch the route to update
if (isset($_GET['edit'])) {
    $route_id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM Routes WHERE route_id=$route_id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $origin = $row['origin'];
        $destination = $row['destination'];
        $distance = $row['distance'];
        $fare = $row['route_fare'];
    }
}

// Delete a route
if (isset($_GET['delete'])) {
    $route_id = $_GET['delete'];

    $sql = "DELETE FROM Routes WHERE route_id=$route_id";
    if ($conn->query($sql) === TRUE) {
        // echo "Route deleted successfully!";
        echo '<script>alert("Route deleted successfully")</script>';
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
}

// Fetch all routes to display
$routes = $conn->query("SELECT * FROM Routes");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Routes</title>
    <link rel="stylesheet" href="adimin.css">
</head>
<body>

<div style="text-align: center; width: 100%;">
    <h2 style="margin-bottom: 10px; color:red">Available Routes</h2>

    <table border="1" style="margin: 0 auto; width: 80%;">
        <tr>
            <th>Route ID</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Distance</th>
            <th>Fare</th>
            <th>Action</th>
        </tr>

        <?php while($row = $routes->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['route_id']; ?></td>
                <td><?php echo $row['origin']; ?></td>
                <td><?php echo $row['destination']; ?></td>
                <td><?php echo $row['distance']; ?> km</td>
                <td><?php echo $row['route_fare']; ?> USD</td>
                <td>
                    <!-- Edit Button -->
                    <a href="manageroutes.php?edit=<?php echo $row['route_id']; ?>">Edit</a>

                    <!-- Delete Button -->
                    <a href="manageroutes.php?delete=<?php echo $row['route_id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this route?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

<!-- Form for Adding/Updating Routes -->
<form method="POST" action="manageroutes.php">
    <h1>Manage Routes</h1>
    <input type="hidden" name="route_id" value="<?php echo $route_id; ?>">
    <label for="origin">Origin:</label>
    <input type="text" name="origin" value="<?php echo $origin; ?>" required><br>

    <label for="destination">Destination:</label>
    <input type="text" name="destination" value="<?php echo $destination; ?>" required><br>

    <label for="distance">Distance (km):</label>
    <input type="number" name="distance" value="<?php echo $distance; ?>" required><br>

    <label for="fare">Fare:</label>
    <input type="number" name="fare" value="<?php echo $fare; ?>" required><br>

    <?php if ($update): ?>
        <button type="submit" name="update_route">Update Route</button>
    <?php else: ?>
        <button type="submit" name="add_route">Add Route</button>
    <?php endif; ?>
</form>

</body>
</html>

