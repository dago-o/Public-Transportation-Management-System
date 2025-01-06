<?php
session_start();
include 'connection.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'passenger') {
    echo "<script>alert('You need to log in as a passenger to book a ticket.');
    window.location.href = 'login.php';</script>";
    exit;
}

// Retrieve and validate form data
$route_id = filter_input(INPUT_POST, 'route_id', FILTER_VALIDATE_INT);
$schedule_id = filter_input(INPUT_POST, 'schedule_id', FILTER_VALIDATE_INT);
$seat_number = filter_input(INPUT_POST, 'seat_number', FILTER_VALIDATE_INT);
$user_id = $_SESSION['user_id'];

if (!$route_id || !$schedule_id || !$seat_number) {
    echo "<script>alert('Invalid input. Please fill in all fields correctly.');
    window.location.href = 'book_ticket.php';</script>";
    exit;
}

// Check available seats
$sql_check_seat = "SELECT available_seats FROM Schedule WHERE schedule_id = ?";
$stmt = $conn->prepare($sql_check_seat);
$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $available_seats = $row['available_seats'];

    if ($available_seats > 0) {
        // Check if the seat is already booked
        $sql_check_duplicate = "SELECT * FROM Bookings WHERE schedule_id = ? AND seat_number = ?";
        $stmt_duplicate = $conn->prepare($sql_check_duplicate);
        $stmt_duplicate->bind_param("ii", $schedule_id, $seat_number);
        $stmt_duplicate->execute();
        $result_duplicate = $stmt_duplicate->get_result();

        if ($result_duplicate->num_rows == 0) {
            // Proceed to book the ticket
            $sql_booking = "INSERT INTO Bookings (user_id, schedule_id, booking_date, seat_number) VALUES (?, ?, NOW(), ?)";
            $stmt_booking = $conn->prepare($sql_booking);
            $stmt_booking->bind_param("iii", $user_id, $schedule_id, $seat_number);

            if ($stmt_booking->execute()) {
                // Update available seats
                $new_available_seats = $available_seats - 1;
                $sql_update_seats = "UPDATE Schedule SET available_seats = ? WHERE schedule_id = ?";
                $stmt_update_seats = $conn->prepare($sql_update_seats);
                $stmt_update_seats->bind_param("ii", $new_available_seats, $schedule_id);
                $stmt_update_seats->execute();

                echo "<script>alert('Ticket booked successfully!');
                window.location.href = 'book_ticket.php';</script>";
            } else {
                echo "<script>alert('Error booking ticket. Please try again.');
                window.location.href = 'book_ticket.php';</script>";
            }
        } else {
            echo "<script>alert('The selected seat is already booked. Please choose another seat.');
            window.location.href = 'book_ticket.php';</script>";
        }
    } else {
        echo "<script>alert('Sorry, no available seats for the selected schedule.');
        window.location.href = 'book_ticket.php';</script>";
    }
} else {
    echo "<script>alert('Invalid schedule selected.');
    window.location.href = 'book_ticket.php';</script>";
}

// Close database connections
$stmt->close();
$conn->close();
?>
