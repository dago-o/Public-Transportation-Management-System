<?php
// Include the database connection file
include 'connection.php';

// Variables to hold form values (for pre-populating in case of updates)
$update = false;
$schedule_id = '';
$route_id = '';
$departure_time = '';
$arrival_time = '';
$bus_number = '';
$available_seats = 0;

// Add a new schedule
if (isset($_POST['add_schedule'])) {
    $route_id = $_POST['route_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $bus_number = $_POST['bus_number'];
    $available_seats = $_POST['available_seats'];

    $sql = "INSERT INTO Schedule (route_id, departure_time, arrival_time, bus_number, available_seats) 
            VALUES ($route_id, '$departure_time', '$arrival_time', '$bus_number', $available_seats)";

    if ($conn->query($sql) === TRUE) {
        echo "New schedule added successfully!";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update an existing schedule
if (isset($_POST['update_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    $route_id = $_POST['route_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $bus_number = $_POST['bus_number'];
    $available_seats = $_POST['available_seats'];

    $sql = "UPDATE Schedule 
            SET route_id=$route_id, departure_time='$departure_time', arrival_time='$arrival_time', bus_number='$bus_number', available_seats=$available_seats
            WHERE schedule_id=$schedule_id";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("schedule updated successfully!")</script>';
    } else {
        echo "Error updating schedule: " . $conn->error;
    }
}

// Fetch the schedule to update
if (isset($_GET['edit'])) {
    $schedule_id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM Schedule WHERE schedule_id=$schedule_id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $route_id = $row['route_id'];
        $departure_time = $row['departure_time'];
        $arrival_time = $row['arrival_time'];
        $bus_number = $row['bus_number'];
        $available_seats = $row['available_seats'];
    }
}

// Delete a schedule
if (isset($_GET['delete'])) {
    $schedule_id = $_GET['delete'];

    $sql = "DELETE FROM Schedule WHERE schedule_id=$schedule_id";
    if ($conn->query($sql) === TRUE) {
        echo "Schedule deleted successfully!";
    } else {
        echo "Error deleting schedule: " . $conn->error;
    }
}

// Fetch all schedules to display
$schedules = $conn->query("SELECT Schedule.*, Routes.origin, Routes.destination 
                           FROM Schedule 
                           JOIN Routes ON Schedule.route_id = Routes.route_id");

$routes = $conn->query("SELECT * FROM Routes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules</title>
    <link rel="stylesheet" href="adimin.css">
</head>
<body>



<div class="container">
    <!-- Available Schedules Table -->
    <div class="table-container">
        <h2 style="text-align: center;">Available Schedules</h2>
        <table>
            <tr>
                <th>Schedule ID</th>
                <th>Route</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Bus Number</th>
                <th>Available Seats</th>
                <th>Action</th>
            </tr>

            <?php while($row = $schedules->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['schedule_id']; ?></td>
                    <td><?php echo $row['origin'] . ' - ' . $row['destination']; ?></td>
                    <td><?php echo $row['departure_time']; ?></td>
                    <td><?php echo $row['arrival_time']; ?></td>
                    <td><?php echo $row['bus_number']; ?></td>
                    <td><?php echo $row['available_seats']; ?></td>
                    <td class="action-links">
                        <!-- Edit Button -->
                        <a href="manageschedules.php?edit=<?php echo $row['schedule_id']; ?>">Edit</a>
                        <!-- Delete Button -->
                        <a href="manageschedules.php?delete=<?php echo $row['schedule_id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Form for Adding/Updating Schedules -->
    <div class="form-container">
        <form method="POST" action="manageschedules.php">
        <h2>Manage Schedules</h2>
            <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
            
            <label for="route_id">Route:</label>
            <select name="route_id" required>
                <?php while($row = $routes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['route_id']; ?>" <?php if ($row['route_id'] == $route_id) echo 'selected'; ?>>
                        <?php echo $row['origin'] . ' - ' . $row['destination']; ?>
                    </option>
                <?php } ?>
            </select><br>

            <label for="departure_time">Departure Time:</label>
            <input type="time" name="departure_time" value="<?php echo $departure_time; ?>" required><br>

            <label for="arrival_time">Arrival Time:</label>
            <input type="time" name="arrival_time" value="<?php echo $arrival_time; ?>" required><br>

            <label for="bus_number">Bus Number:</label>
            <input type="text" name="bus_number" value="<?php echo $bus_number; ?>" required><br>

            <label for="available_seats">Available Seats:</label>
            <input type="number" name="available_seats" value="<?php echo $available_seats; ?>" required><br>

            <?php if ($update): ?>
                <button type="submit" name="update_schedule">Update Schedule</button>
            <?php else: ?>
                <button type="submit" name="add_schedule">Add Schedule</button>
            <?php endif; ?>
        </form>
    </div>
</div>

</body>
</html>
