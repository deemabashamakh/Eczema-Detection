<?php
session_start();
require_once "db_connection.php"; // Database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    $user_reset_code = $_POST['code'];

    // Check if the reset code matches
    if ($user_reset_code == $_SESSION['reset_code']) {
        // Reset code is correct, redirect to password update form
        header("Location: resetpassword.php?code=1");
        exit();
    } else {
        $_SESSION['code_incorrect']='Code entered is incorrect. Please try again.';
        if (isset($_GET["code"]))
        unset( $_GET["code"]);
        
        header("Location: resetpassword.php?email_status=sent");
    }
} else {
    // Redirect them back to the reset code form
    if (isset($_GET["code"]))
        unset( $_GET["code"]);
    header("Location: resetpassword.php?email_status=sent");
    exit();
}
?>
