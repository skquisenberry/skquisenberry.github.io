<?php
$servername = "webdb.uvm.edu";
$username = "omarshal_admin";
$password = "r2SK86J9SP6t";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>