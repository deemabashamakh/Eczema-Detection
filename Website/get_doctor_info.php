<?php
include("db_connection.php");
$query = "SELECT * FROM doctor WHERE doctorEmail = '$_SESSION[doctor_email]'";
$result = mysqli_query($conn, $query);
$doctor_result = $result->fetch_assoc();
$doctorID= $doctor_result["doctorID"];
$doctorFirstName=$doctor_result['doctorFirstName'];
$doctorLastName=$doctor_result['doctorLastName'];
$doctorEmail=$doctor_result['doctorEmail'];
$doctorDOB=$doctor_result['doctorDOB'];
$doctorPassword=$doctor_result['doctorPassword'];