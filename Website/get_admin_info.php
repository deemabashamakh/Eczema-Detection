<?php
include("db_connection.php");
$query = "SELECT * FROM admin WHERE adminEmail = '$_SESSION[admin_email]'";
$result = mysqli_query($conn, $query);
$admin_result = $result->fetch_assoc();
$adminID= $admin_result["adminID"];
$adminFirstName=$admin_result['adminFirstName'];
$adminLastName=$admin_result['adminLastName'];
$adminEmail=$admin_result['adminEmail'];
$adminPassword=$admin_result['adminPassword'];