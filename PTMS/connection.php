<?php

$conn = new mysqli('localhost', 'root', '', 'tms');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    // echo 'Connection created!';
}

?>
