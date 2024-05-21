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
    <title>Homepage</title>
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
        if(password.indexOf(' ')>=0) {
            document.getElementById('passwordError').innerText = 'Password cannot contain whitespace.';
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
        var elements = document.getElementsByName("patientDOB");
        if (elements.length > 0) {
            elements[0].setAttribute('max', today);
        }
    });
    </script>
</head>
<body class="container">
    <?php
    if (!isset($_SESSION["loggedin"]) || (isset($_SESSION['role']) && $_SESSION['role'] != 'patient')) {
        header("Location: Loginpage.php");
    }
    include('get_patient_info.php');
    ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="Uploading Image.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="http://localhost:8888/patient_view_prev_results.php"><i class="fas fa-user"></i> All Results</a>
            <a href="#" class="active"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">My Profile</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($patientFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
            <form class="wide-form" action="update_patient_info.php" method="POST" onsubmit="return validateForm()">
                <div class="center-align-div-admin-pfpage">
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">First Name</p>
                        <input type="text" id="firstname" name="patientfirstname" placeholder="First name" value="<?php echo $patientFirstName?>" required>
                        <span id="firstnameError" class="error"></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Last Name</p>
                        <input type="text" id="lastname" name="patientlastname" placeholder="Last name" value="<?php echo $patientLastName?>" required>
                        <span id="lastnameError" class="error"></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Date of Birth</p>
                        <input type="date" id="dob" name="patientDOB" value="<?php echo date('Y-m-d', strtotime($patientDOB))?>" required>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Gender</p>
                        <select name="gender" id="gender">
                            <option value="F" <?php if ($patientGender == 'F') echo "selected"; ?>>F</option>
                            <option value="M" <?php if ($patientGender == 'M') echo "selected"; ?>>M</option>
                        </select>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Email</p>
                        <input type="email" id="email" name="patientemail" placeholder="Email" value="<?php echo $patientEmail?>" required>
                        <span id="emailError" class="error"><?php if (!empty($email_error_message)) echo $email_error_message; ?></span>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <p class="edit-info-p">Password</p>
                        <input type="password" id="password" name="patientpassword" placeholder="Password" value="<?php echo $patientPassword?>" required>
                        <span id="passwordError" class="error"></span>
                        <div style="width:75%" class="left-align-div">
                            <label style="width:20em">
                                <input style="width:20%" type="checkbox" onclick="togglePassword()">View Password
                            </label>
                        </div>
                    </div>
                    <div class="input-group-admin-profilepage">
                        <button type="submit" class="btn-save-changes">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
