<?php
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in or not an admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link rel="stylesheet" href="boardes.css">
</head>
<body>

  <nav>
    <!-- Profile image -->
    <div>
      <a href="profile.php"><img src="imagess.jpg" alt="admin profile"></a>
    </div>
    
    <!-- Navigation Links -->
    <div class="navigation">
      <ul>
        <select style="padding: 5px; color:green; border:2px solid yellow; border-radius:5px; font-weight:bold" name="management" id="management" onchange="navigateToPage()">
            <option value="Manage" selected>Manage</option>
            <option value="manageroutes.php">Routes</option>
            <option value="manageschedules.php">Schedules</option>
            <option value="managedrivers.php">Drivers</option>
            <option value="manage_passengers.php">Passenger</option>
        </select>
        <li><a href="viewbookings.php">Bookings</a></li>
        <li><a href="viewcancellations.php">Cancellations</a></li>
        <li><a href="announcement.php">Announcements</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="get_feedback.php">Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <fieldset>
      <legend>Admin Functions</legend>
      <!-- Add content related to admin functionality -->
      <p>
    As an administrator of the Public Transportation Management System, you have a comprehensive set of tools and functionalities to ensure efficient operations. You can manage your profile, enabling updates to your personal details and system preferences at any time. One of your key responsibilities includes managing routes, where you can add new routes, update existing ones, and deactivate routes as needed to optimize service. You can also view all bookings made by passengers, giving you full visibility over the system's usage.
</p>
<p>
    Managing drivers is a crucial task that includes adding new drivers, updating driver information, assigning them to routes, and monitoring their activity. In addition, you have access to view cancellations, allowing you to track when and why passengers cancel their bookings, helping you to assess system performance and identify potential issues. You are also responsible for creating announcements and notifications, ensuring passengers are kept informed about service changes, delays, and other important updates.
</p>
<p>
    You can generate detailed reports on bookings and cancellations, providing valuable insights into the overall system performance, passenger behavior, and route popularity. Admins also have the ability to manage passengers, including viewing their profiles, addressing any issues, and providing support. Additionally, you can receive feedback from passengers and respond directly to their concerns or suggestions, ensuring a high level of customer satisfaction. At any time, you have the option to log out securely after completing your tasks.
</p>
<p>
    Beyond these key functions, you also have the ability to oversee system security by managing user roles and permissions, ensuring only authorized personnel have access to critical system features. Furthermore, you can update system settings, monitor system performance, and collaborate with other admins or staff to improve operational efficiency. You can also schedule maintenance or upgrades to ensure the system is always functioning at its best.
</p>
    </fieldset>
  </div>

  <footer>
    <ul>
        <li><a href="company.php">Company</a></li>
        <li><a href="gallery.php">Gallery</a></li>
    </ul>
    <p>Transport Management System &copy; 2024</p>
  </footer>

  <script>
    function navigateToPage() {
        const select = document.getElementById('management');
        const selectedValue = select.value;
        if (selectedValue) {
            window.location.href = selectedValue; 
        }
    }
  </script>

</body>
</html>
