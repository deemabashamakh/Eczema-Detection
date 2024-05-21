<?php
include("db_connection.php");
$query = "SELECT * FROM patient WHERE patientEmail = '$_SESSION[patient_email]'";
$result = mysqli_query($conn, $query);
$patient_result = $result->fetch_assoc();
$patientID= $patient_result["patientID"];
$patientFirstName=$patient_result['patientFirstName'];
$patientLastName=$patient_result['patientLastName'];
$patientEmail=$patient_result['patientEmail'];
$patientDOB=$patient_result['patientDOB'];
$patientPassword=$patient_result['patientPassword'];
$patientGender=$patient_result['patientGender'];