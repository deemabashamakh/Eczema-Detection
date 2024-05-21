<?php
session_start();
require_once ("db_connection.php"); // A file where your database connection is set up.
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $patientFirstName = mysqli_real_escape_string($conn,$_POST['patientfirstname']);
    $patientLastName = mysqli_real_escape_string($conn, $_POST['patientlastname']);
    $patientEmail = mysqli_real_escape_string($conn, $_POST['patientemail']);
    $patientPassword = mysqli_real_escape_string($conn, $_POST['patientpassword']);
    $patientDOB= mysqli_real_escape_string($conn, $_POST['patientDOB']);
    $patientGender= mysqli_real_escape_string($conn, $_POST['gender']);
    $input_date=$patientDOB;
    $date=date("Y-m-d",strtotime($input_date));

    // Check if the email is unique
    $doctor_query = "SELECT doctorID FROM doctor WHERE doctorEmail = '$patientEmail'";
    $patient_query = "SELECT patientID FROM patient WHERE patientEmail = '$patientEmail'";
    $admin_query = "SELECT adminID FROM admin WHERE adminEmail = '$patientEmail'";
    $doctor_result = mysqli_query($conn, $doctor_query);
    $patient_result=mysqli_query($conn, $patient_query);
    $admin_result=mysqli_query($conn, $admin_query);
    $total=mysqli_num_rows($doctor_result)+mysqli_num_rows($patient_result)+mysqli_num_rows($admin_result);

    if ($total == 0 ) {
        // Email is unique or unchanged, proceed with the update
        $insertQuery = "INSERT INTO patient (patientFirstName, patientLastName, patientEmail, patientGender, patientPassword, patientDOB) VALUES ('$patientFirstName', '$patientLastName', '$patientEmail', '$patientGender', '$patientPassword', '$date')";
        //$updateQuery = "UPDATE admin SET adminFirstName = '$adminFirstName', adminLastName = '$adminLastName', adminEmail = '$adminEmail', adminPassword = '$adminPassword' WHERE adminID = {$_SESSION['admin_id']}";
        if (mysqli_query($conn, $insertQuery)) {
            // Update session variables
            $_SESSION['patient_first_name'] = $patientFirstName;
            $_SESSION['patient_email'] = $patientEmail;
            echo '<script type="text/javascript">';
            echo 'alert("User added successfully!");';
            echo 'window.location.href="Loginpage.php";'; 
            echo '</script>';
            exit(); 

        } else {
            // Handle error
            header("Location: patient_sign_up.php?update=error");
        }
    } else {
        $_SESSION['email_error_message']="Email already exists. Please choose another one.";
        header("Location: patient_sign_up.php?error=emailtaken");
    }
    mysqli_close($conn);
} else {
    // Redirect to the homepage if the script is accessed without posting form data
    header("Location: Loginpage.php");
}

