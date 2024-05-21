<?php
include('db_connection.php');
session_start();

$doctorFirstName = $doctorLastName = $doctorEmail = $doctorPassword = $doctorDOB = "";
$email_error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $doctorFirstName = htmlspecialchars($_POST['doctorFirstName']);
    $doctorLastName = htmlspecialchars($_POST['doctorLastName']);
    $doctorEmail = htmlspecialchars($_POST['doctorEmail']);
    $doctorPassword = htmlspecialchars($_POST['doctorPassword']);
    $doctorDOB = htmlspecialchars($_POST['doctorDOB']);
    $date = date("Y-m-d", strtotime($doctorDOB));

    // Check if the email is unique
    $doctor_query = "SELECT doctorID FROM doctor WHERE doctorEmail = '$doctorEmail'";
    $patient_query = "SELECT patientID FROM patient WHERE patientEmail = '$doctorEmail'";
    $admin_query = "SELECT adminID FROM admin WHERE adminEmail = '$doctorEmail'";
    $doctor_result = mysqli_query($conn, $doctor_query);
    $patient_result = mysqli_query($conn, $patient_query);
    $admin_result = mysqli_query($conn, $admin_query);
    $total = mysqli_num_rows($doctor_result) + mysqli_num_rows($patient_result) + mysqli_num_rows($admin_result);

    if ($total == 0) {
        // Email is unique, proceed with the insert
        $insertQuery = "INSERT INTO doctor (doctorFirstName, doctorLastName, doctorEmail, doctorPassword, doctorDOB) VALUES ('$doctorFirstName', '$doctorLastName', '$doctorEmail', '$doctorPassword', '$date')";
        if (mysqli_query($conn, $insertQuery)) {
            echo '<script type="text/javascript">';
            echo 'alert("User added successfully!");';
            echo 'window.location.href="adminhomepage.php";'; 
            echo '</script>';
            exit(); 
        } else {
            $email_error_message = "Error adding doctor.";
        }
    } else {
        $email_error_message = "The email you entered is taken. Please try another one.";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function validateForm() {
        var isValid = true;
        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        var letterRegex = /^[A-Za-z]+$/;

        document.getElementById('firstnameError').innerText = "";
        document.getElementById('lastnameError').innerText = "";
        document.getElementById('emailError').innerText = "";
        document.getElementById('passwordError').innerText = "";

        if (firstname === "") {
            document.getElementById('firstnameError').innerText = 'First name is required.';
            isValid = false;
        } else if (!letterRegex.test(firstname)) {
            document.getElementById('firstnameError').innerText = 'First name must contain only letters.';
            isValid = false;
        }

        if (lastname === "") {
            document.getElementById('lastnameError').innerText = 'Last name is required.';
            isValid = false;
        } else if (!letterRegex.test(lastname)) {
            document.getElementById('lastnameError').innerText = 'Last name must contain only letters.';
            isValid = false;
        }

        if (email === "") {
            document.getElementById('emailError').innerText = 'Email is required.';
            isValid = false;
        }

        if (password === "") {
            document.getElementById('passwordError').innerText = 'Password is required.';
            isValid = false;
        }
        if (password.indexOf(' ') >= 0) {
            document.getElementById('passwordError').innerText = 'Password cannot contain whitespaces.';
            isValid = false;
        }

        return isValid;
    }

    function togglePassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        var today = new Date().toISOString().split('T')[0];
        var elements = document.getElementsByName("doctorDOB");
        if (elements.length > 0) {
            elements[0].setAttribute('max', today);
        }
    });
    </script>
</head>
<body class="container">
<div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="adminhomepage.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="admin_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Add Doctor</div>
        </div>
        <div class="admin-homepage-lower-part">
            <form class="wide-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return validateForm()">
                <div class="center-align-div-admin-pfpage">
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">First Name</p>
                        <input type="text" id="firstname" name="doctorFirstName" placeholder="First name" value="<?php echo $doctorFirstName; ?>" required>
                        <span id="firstnameError" class="error"></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Last Name</p>
                        <input type="text" id="lastname" name="doctorLastName" placeholder="Last name" value="<?php echo $doctorLastName; ?>" required>
                        <span id="lastnameError" class="error"></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Date of Birth</p>
                        <input type="date" id="dob" name="doctorDOB" value="<?php echo $doctorDOB; ?>" required>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Email</p>
                        <input type="email" id="email" name="doctorEmail" placeholder="Email" value="<?php echo $doctorEmail; ?>" required>
                        <span id="emailError" class="error"><?php echo $email_error_message; ?></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Password</p>
                        <input type="password" id="password" name="doctorPassword" placeholder="Password" value="<?php echo $doctorPassword; ?>" required>
                        <span id="passwordError" class="error"></span>
                        <div style="width:75%" class="left-align-div">
                            <label style="width:20em">
                                <input style="width:20%" type="checkbox" onclick="togglePassword()">View Password
                            </label>
                        </div>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <button type="submit" class="btn-save-changes">Add Doctor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
