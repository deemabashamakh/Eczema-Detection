<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: Loginpage.php");
}
require_once ("db_connection.php"); // A file where your database connection is set up.
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $adminFirstName = mysqli_real_escape_string($conn,$_POST['adminfirstname']);
    $adminLastName = mysqli_real_escape_string($conn, $_POST['adminlastname']);
    $adminEmail = mysqli_real_escape_string($conn, $_POST['adminemail']);
    $adminPassword = mysqli_real_escape_string($conn, $_POST['adminpassword']); // Consider hashing the password

    // Check if the email is unique
    $doctor_query = "SELECT doctorID FROM doctor WHERE doctorEmail = '$adminEmail'";
    $patient_query = "SELECT patientID FROM patient WHERE patientEmail = '$adminEmail'";
    $admin_query = "SELECT adminID FROM admin WHERE adminEmail = '$adminEmail'";
    $doctor_result = mysqli_query($conn, $doctor_query);
    $patient_result=mysqli_query($conn, $patient_query);
    $admin_result=mysqli_query($conn, $admin_query);
    $total=mysqli_num_rows($doctor_result)+mysqli_num_rows($patient_result)+mysqli_num_rows($admin_result);

    if ($total == 0 || $total == 1 && $adminEmail == $_SESSION['admin_email']) {
        // Email is unique or unchanged, proceed with the update
        $updateQuery = "UPDATE admin SET adminFirstName = '$adminFirstName', adminLastName = '$adminLastName', adminEmail = '$adminEmail', adminPassword = '$adminPassword' WHERE adminID = {$_SESSION['admin_id']}";
        if (mysqli_query($conn, $updateQuery)) {
            // Update session variables
            $_SESSION['admin_first_name'] = $adminFirstName;
            $_SESSION['admin_email'] = $adminEmail;
            echo '<script type="text/javascript">';
            echo 'alert("Information updated successfully!");';
            echo 'window.location.href="adminhomepage.php";'; 
            echo '</script>';
            exit(); 

        } else {
            // Handle error
            header("Location: adminprofile.php?update=error");
        }
    } else {
        $_SESSION['email_error_message']="Email already exists. Please choose another one.";
        header("Location: admin_profile_page.php?error=emailtaken");
    }
    mysqli_close($conn);
} else {
    // Redirect to the homepage if the script is accessed without posting form data
    header("Location: adminhomepage.php");
}
?>
