<?php
session_start();

if (isset($_GET['update']) && $_GET['update'] == 'success') {
    // Handle success
} elseif (isset($_GET['update']) && $_GET['update'] == 'error') {
    // Handle error
} elseif (isset($_GET['error']) && $_GET['error'] == 'emailtaken') {
    $email_error_message = $_SESSION['email_error_message'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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

        return isValid;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var today = new Date().toISOString().split('T')[0];
        var elements = document.getElementsByName("patientDOB");
        if (elements.length > 0) {
            elements[0].setAttribute('max', today);
        }
    });

    function togglePassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</head>
<body class="container">
    <div class="right-panel-admin-homepage">
        <div class="admin-homepage-lower-part">
            <h1>Sign Up</h1>
            <form class="wide-form" action="process_patient_signup.php" method="POST" onsubmit="return validateForm()">
                <div class="center-align-div-admin-pfpage">
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">First Name</p>
                        <input type="text" id="firstname" name="patientfirstname" placeholder="First name" required>
                        <span id="firstnameError" class="error"></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Last Name</p>
                        <input type="text" id="lastname" name="patientlastname" placeholder="Last name" required>
                        <span id="lastnameError" class="error"></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Date of Birth</p>
                        <input type="date" id="dob" name="patientDOB" required>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Gender</p>
                        <select name="gender" id="gender">
                            <option value="F">F</option>
                            <option value="M">M</option>
                        </select>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Email</p>
                        <input type="email" id="email" name="patientemail" placeholder="Email" required>
                        <span id="emailError" class="error"><?php if (!empty($email_error_message)) echo $email_error_message; ?></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Password</p>
                        <input type="password" id="password" name="patientpassword" placeholder="Password" required>
                        <span id="passwordError" class="error"></span>
                        <div style="width:75%" class="left-align-div">
                            <label style="width:20em">
                                <input style="width:20%" type="checkbox" onclick="togglePassword()">View Password
                            </label>
                        </div>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <button type="submit" class="btn-save-changes">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
