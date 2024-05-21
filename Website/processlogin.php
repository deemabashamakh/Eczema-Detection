<?php 
include("db_connection.php");
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["admin_email"])) {
            // Assign posted values to variables
    $email = $conn->real_escape_string($_POST['admin_email']);
    $password = $conn->real_escape_string($_POST['password']);

    // SQL query to check if the user exists
    $query = "SELECT * FROM admin WHERE adminEmail = '$email' AND adminPassword = '$password'";
    $num_patients_query="select * from patient";
    $num_doctors_query="select * from doctor";
    
    // Execute the query
    $result = $conn->query($query);
    $admin_result = $result->fetch_assoc();
    $num_patients_result=mysqli_num_rows($conn->query($num_patients_query));
    $num_doctors_result=mysqli_num_rows($conn->query($num_doctors_query));

    if ($result->num_rows > 0) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_id']=$admin_result['adminID'];
        $_SESSION['admin_first_name'] = $admin_result['adminFirstName']; // Store the first name in session
        $_SESSION['num_patients'] = $num_patients_result;
        $_SESSION['num_doctors'] = $num_doctors_result;
        header("Location: adminhomepage.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: Loginpage.php");
        exit;
    }
    }
    else if (isset($_POST["patient_email"])) {
        echo'patient here';
    $email = $conn->real_escape_string($_POST['patient_email']);
    $password = $conn->real_escape_string($_POST['password']);
    // SQL query to check if the user exists
    $query = "SELECT * FROM patient WHERE patientEmail = '$email' AND patientPassword = '$password'";
    
    // Execute the query
    $result = $conn->query($query);
    $patient_result = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['role'] = 'patient';
        $_SESSION['patient_email'] = $email;
        $_SESSION['patient_id']=$patient_result['patientID'];
        $_SESSION['patient_first_name'] = $patient_result['patientFirstName']; // Store the first name in session
        header("Location: Uploading Image.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: Loginpage.php");
        exit;
    }
    }
    else if (isset($_POST["doctor_email"])) {
        $email = $conn->real_escape_string($_POST['doctor_email']);
        $password = $conn->real_escape_string($_POST['password']);
        // SQL query to check if the user exists
        $query = "SELECT * FROM doctor WHERE doctorEmail = '$email' AND doctorPassword = '$password'";
        // Execute the query
        $result = $conn->query($query);
        $doctor_result = $result->fetch_assoc();
    
        if ($result->num_rows > 0) {
            // Set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = 'doctor';
            $_SESSION['doctor_email'] = $email;
            $_SESSION['doctor_id']=$doctor_result['doctorID'];
            $_SESSION['doctor_first_name'] = $doctor_result['doctorFirstName']; // Store the first name in session
            header("Location: doctorhomepage.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: Loginpage.php");
            exit;
        }
        }

}

$conn->close();

