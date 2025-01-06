
<?php
include 'connection.php';

$bookings=$conn->query("select *FROM Bookings
    JOIN Users ON Bookings.user_id = Users.user_id
    JOIN Schedule ON Bookings.schedule_id = Schedule.schedule_id
    JOIN Routes ON Schedule.route_id = Routes.route_id");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            border-collapse: collapse;
        }

        td,th{
            border: 2px solid green;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>Booking id</th>
        <th>User</th>
        <th>Route</th>
        <th>bus number</th>
        <th>value cost</th>
    </tr>

    <?php while($row=$bookings->fetch_assoc()){?>
        <tr>
            <td><?php echo $row['booking_id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['origin'].'-'.$row['destination']; ?></td>
            <td><?php echo $row['bus_number']; ?></td>
            <td><?php echo $row['route_fare']; ?></td>
        </tr>


    <?php }?>
</table>
    
</body>
</html>

