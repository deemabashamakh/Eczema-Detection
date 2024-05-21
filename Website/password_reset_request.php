<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include("db_connection.php"); // Database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $query_admin = "SELECT * FROM admin WHERE adminEmail = '$email'";
    $result_admin = mysqli_query($conn, $query_admin);
    $query_doctor = "SELECT * FROM doctor WHERE doctorEmail = '$email'";
    $result_doctor = mysqli_query($conn, $query_doctor);
    $query_patient = "SELECT * FROM patient WHERE patientEmail = '$email'";
    $result_patient = mysqli_query($conn, $query_patient);
    $count=mysqli_num_rows($result_doctor)+mysqli_num_rows($result_patient)+mysqli_num_rows($result_admin);

    if ($count > 0) {
        
        $reset_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $_SESSION['reset_code']= $reset_code;
        $_SESSION['email_to_reset'] = $email;

        //start
        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function
        //Load Composer's autoloader
        require 'vendor/autoload.php';
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'eatsafeapplication@gmail.com';                     //SMTP username
            $mail->Password   = 'nwbc uxxv ucfi ekxt';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('eatsafeapplication@gmail.com', 'Eczema Detector');
            $mail->addAddress('dbashamakh@gmail.com');     //Add a recipient
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reset Password Code';
            $mail->Body    = 'Here is your code to reset your password: '.$reset_code;
            $mail->AltBody = $reset_code;

            $mail->send();
            header("Location: resetpassword.php?email_status=sent");
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        //end

        // Redirect to verification page
        exit();
    } else {
        // Email doesn't exist
        $_SESSION["reset_password_email_doesnt_exist"]="No account found with this email address.";
        header("Location: resetpassword.php");
    }
} else {
    // Redirect them back to the password reset request form
    header("Location: password_reset_form.html");
    exit();
}
?>
