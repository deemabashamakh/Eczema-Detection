<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: Loginpage.php");
}
require_once ("db_connection.php"); // A file where your database connection is set up.
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $doctorFirstName = mysqli_real_escape_string($conn,$_POST['doctorfirstname']);
    $doctorLastName = mysqli_real_escape_string($conn, $_POST['doctorlastname']);
    $doctorEmail = mysqli_real_escape_string($conn, $_POST['doctoremail']);
    $doctorPassword = mysqli_real_escape_string($conn, $_POST['doctorpassword']);
    $doctorDOB= mysqli_real_escape_string($conn, $_POST['doctorDOB']);
    $input_date=$doctorDOB;
    $date=date("Y-m-d",strtotime($input_date));

    // Check if the email is unique
    $doctor_query = "SELECT doctorID FROM doctor WHERE doctorEmail = '$doctorEmail'";
    $patient_query = "SELECT patientID FROM patient WHERE patientEmail = '$doctorEmail'";
    $admin_query = "SELECT adminID FROM admin WHERE adminEmail = '$doctorEmail'";
    $doctor_result = mysqli_query($conn, $doctor_query);
    $patient_result=mysqli_query($conn, $patient_query);
    $admin_result=mysqli_query($conn, $admin_query);
    $total=mysqli_num_rows($doctor_result)+mysqli_num_rows($patient_result)+mysqli_num_rows($admin_result);

    if ($total == 0 || ($total == 1 && $doctorEmail == $_SESSION['doctor_email'])) {
        // Email is unique or unchanged, proceed with the update
        $updateQuery = "UPDATE doctor SET doctorFirstName = '$doctorFirstName', doctorLastName = '$doctorLastName', doctorEmail = '$doctorEmail', doctorPassword = '$doctorPassword', doctorDOB='$date' WHERE doctorID = {$_SESSION['doctor_id']}";
        if (mysqli_query($conn, $updateQuery)) {
            // Update session variables
            $_SESSION['doctor_first_name'] = $doctorFirstName;
            $_SESSION['doctor_email'] = $doctorEmail;
            echo '<script type="text/javascript">';
            echo 'alert("Information updated successfully!");';
            echo 'window.location.href="doctorhomepage.php";'; 
            echo '</script>';
            exit(); 

        } else {
            // Handle error
            header("Location: dr_profile_page.php?update=error");
        }
    } else {
        $_SESSION['email_error_message']="Email already exists. Please choose another one.";
        header("Location: dr_profile_page.php?error=emailtaken");
    }
    mysqli_close($conn);
} else {
    // Redirect to the homepage if the script is accessed without posting form data
    header("Location: doctorhomepage.php");
}
?>
