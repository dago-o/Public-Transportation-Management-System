<?php
session_start();

// Check if the user is logged in and has passenger privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'passenger') {
    header("Location: login.php"); // Redirect to login if not logged in or not a passenger
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Passenger Page</title>
  <link rel="stylesheet" href="boardes.css">
</head>
<body>

  <nav>
    <!-- Profile image -->
    <div>
      <a href="profile.php"><img src="imagess.jpg" alt="passenger profile"></a>
    </div>
    
    <!-- Navigation Links -->
    <div class="navigation">
      <ul>
        <li><a href="check_schedule.php">Schedule</a></li>
        <li><a href="cancel_ticket.php">Cancel</a></li>
        <li><a href="view_booking_history.php">History</a></li>
        <li><a href="contact_support.php">Contact</a></li>
        <li><a href="view_notifications.php">Notification</a></li>
        <li><a href="view_announcements.php">Announcement</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <fieldset>
      <legend>Passenger Functions</legend>
      <p>
        As a valued passenger in our Transport Management System, you have access to a wide range of convenient features to enhance your journey. You can manage your profile, allowing you to update your personal information and preferences at any time. Booking a ticket for your preferred routes is just a few clicks away, and you can easily check the schedule for available journeys. Should your plans change, you also have the flexibility to cancel your ticket hassle-free. Additionally, you can view your booking history to keep track of past trips and payments.
      </p>

      <p>
        We keep you informed with real-time announcements and notifications about important updates, such as route changes, delays, or new services. If you ever need assistance, our support center is always available for contact, ensuring you receive help whenever you need it. You can also check special promotions and discounts available exclusively for registered passengers. For passengers planning regular trips, our system allows for easy scheduling of recurring bookings.
      </p>

      <p>
        Furthermore, we aim to make your travel experience smoother by offering options to provide feedback after each journey, enabling you to rate your trip and service experience. You can also participate in surveys to help us improve our service. Should you need to take a break or switch to a different account, you can log out securely at any time.
      </p>
    </fieldset>
  </div>

  <div class="imgpas">
    <!-- You can place images here if needed -->
  </div>

  <footer>
    <ul>
        <li><a href="company.php">Company</a></li>
        <li><a href="gallery.php">Gallery</a></li>
    </ul>
    <p>Transport Management System &copy; 2024</p>
  </footer>

</body>
</html>
