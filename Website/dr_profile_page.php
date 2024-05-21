<?php
session_start();

if (isset($_GET['update']) && $_GET['update'] == 'success') {
    ;
} elseif (isset($_GET['update']) && $_GET['update'] == 'error') {
    ;  
} elseif (isset($_GET['error']) && $_GET['error'] == 'emailtaken') {
    $email_error_message = 'Email already exists. Please choose another one.';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <script>
function validateForm() {
    var firstname = document.getElementById('firstname').value;
    var lastname = document.getElementById('lastname').value;
    var dob = document.getElementById('dob').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var letterRegex = /^[A-Za-z]+$/;
    var isValid = true;

    if (firstname === "" || lastname === "" || dob === "" || email === "" || password === "") {
        document.getElementById('firstname-error').textContent = firstname === "" ? "First name is required." : "";
        document.getElementById('lastname-error').textContent = lastname === "" ? "Last name is required." : "";
        document.getElementById('dob-error').textContent = dob === "" ? "Date of birth is required." : "";
        document.getElementById('email-error').textContent = email === "" ? "Email is required." : "";
        document.getElementById('password-error').textContent = password === "" ? "Password is required." : "";
        isValid = false;
    }

    if (firstname.indexOf(' ') >= 0 || lastname.indexOf(' ') >= 0 || email.indexOf(' ') >= 0 || password.indexOf(' ') >= 0) {
        document.getElementById('firstname-error').textContent = firstname.indexOf(' ') >= 0 ? "No spaces allowed." : "";
        document.getElementById('lastname-error').textContent = lastname.indexOf(' ') >= 0 ? "No spaces allowed." : "";
        document.getElementById('email-error').textContent = email.indexOf(' ') >= 0 ? "No spaces allowed." : "";
        document.getElementById('password-error').textContent = password.indexOf(' ') >= 0 ? "No spaces allowed." : "";
        isValid = false;
    }

    if (!letterRegex.test(firstname) || !letterRegex.test(lastname)) {
        document.getElementById('firstname-error').textContent = !letterRegex.test(firstname) ? "First name must contain only letters." : "";
        document.getElementById('lastname-error').textContent = !letterRegex.test(lastname) ? "Last name must contain only letters." : "";
        isValid = false;
    }

    return isValid;
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
    <?php
    if (!isset($_SESSION["loggedin"])||(isset($_SESSION['role'])&&$_SESSION['role']!='doctor')) {
        header("Location: Loginpage.php");
    }
    $doctorFirstName = $_SESSION['doctor_first_name'];
    include('get_doctor_info.php');
     ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="doctorhomepage.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="#" class="active"><i class="fas fa-user"></i> My Profile</a>
            <a href="Uploading Image.php"><i class="fas fa-sign-out-alt"></i> Upload Image</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">My Profile</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($doctorFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
            <form class="wide-form" action="update_doctor_info.php" method="POST" onsubmit="return validateForm()">
                <div class="input-group-admin-profilepage">
    <p class="edit-info-p">First Name</p>
    <input type="text" id="firstname" name="doctorfirstname" placeholder="First name" value="<?php echo $doctorFirstName ?>" required>
    <span class="error" id="firstname-error"></span>
</div>
<div class="input-group-admin-profilepage">
    <p class="edit-info-p">Last Name</p>
    <input type="text" id="lastname" name="doctorlastname" placeholder="Last name" value="<?php echo $doctorLastName ?>" required>
    <span class="error" id="lastname-error"></span>
</div>
<div class="input-group-admin-profilepage">
    <p class="edit-info-p">Date of Birth</p>
    <input type="date" id="dob" name="doctorDOB" value="<?php echo date('Y-m-d', strtotime($doctorDOB)) ?>" required>
    <span class="error" id="dob-error"></span>
</div>
<div class="input-group-admin-profilepage">
    <p class="edit-info-p">Email</p>
    <input type="email" id="email" name="doctoremail" placeholder="Email" value="<?php echo $doctorEmail ?>" required>
    <span class="error" id="email-error"><?php if (isset($email_error_message)&&!empty($email_error_message)) echo $email_error_message; ?></span>
</div>
<div class="input-group-admin-profilepage">
    <p class="edit-info-p">Password</p>
    <input type="password" id="password" name="doctorpassword" placeholder="Password" value="<?php echo $doctorPassword ?>" required>
    <span class="error" id="password-error"></span>
    <button type="submit" class="btn-save-changes">Save Changes</button>
</div>

</form>
</div>
</div>
</div>
    
</body>
</html>