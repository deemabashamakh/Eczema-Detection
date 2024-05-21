<?php
session_start();
require_once("db_connection.php"); // A file where your database connection is set up.
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $doctorFirstName = mysqli_real_escape_string($conn, $_POST['doctorFirstName']);
    $doctorLastName = mysqli_real_escape_string($conn, $_POST['doctorLastName']);
    $doctorEmail = mysqli_real_escape_string($conn, $_POST['doctorEmail']);
    $doctorPassword = mysqli_real_escape_string($conn, $_POST['doctorPassword']);
    $doctorDOB = mysqli_real_escape_string($conn, $_POST['doctorDOB']);
    $input_date = $doctorDOB;
    $date = date("Y-m-d", strtotime($input_date));

    // Check if the email is unique
    $doctor_query = "SELECT doctorID FROM doctor WHERE doctorEmail = '$doctorEmail'";
    $patient_query = "SELECT patientID FROM patient WHERE patientEmail = '$doctorEmail'";
    $admin_query = "SELECT adminID FROM admin WHERE adminEmail = '$doctorEmail'";
    $doctor_result = mysqli_query($conn, $doctor_query);
    $patient_result = mysqli_query($conn, $patient_query);
    $admin_result = mysqli_query($conn, $admin_query);
    $total = mysqli_num_rows($doctor_result) + mysqli_num_rows($patient_result) + mysqli_num_rows($admin_result);

    if ($total == 0) {
        // Email is unique or unchanged, proceed with the update
        $insertQuery = "INSERT INTO doctor (doctorFirstName, doctorLastName, doctorEmail, doctorPassword, doctorDOB) VALUES ('$doctorFirstName', '$doctorLastName', '$doctorEmail', '$doctorPassword', '$date')";
        if (mysqli_query($conn, $insertQuery)) {
            // Update session variables
            echo '<script type="text/javascript">';
            echo 'alert("User added successfully!");';
            echo 'window.location.href="Loginpage.php";';
            echo '</script>';
            exit();
        } else {
            // Handle error
            header("Location: adminhomepage.php?update=error");
        }
    } else {
        $_SESSION['email_error_message'] = "Email already exists. Please choose another one.";
        header("Location: admin_add_doctor.php?error=emailtaken");
    }
    mysqli_close($conn);
} else {
    // Redirect to the homepage if the script
}