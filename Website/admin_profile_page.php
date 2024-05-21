<?php
session_start(); // Always start the session at the beginning of the script

if (isset($_GET['update']) && $_GET['update'] == 'success') {
    ;
} elseif (isset($_GET['update']) && $_GET['update'] == 'error') {
    ;  
} elseif (isset($_GET['error']) && $_GET['error'] == 'emailtaken') {
    $email_error_message = $_GET['error'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
  }
}
        function validateForm() {
    var firstname = document.getElementById('firstname').value;
    var lastname = document.getElementById('lastname').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var letterRegex = /^[A-Za-z]+$/;

    var isValid = true;

    if (firstname === "" || lastname === "" || email === "" || password === "") {
        document.getElementById('firstname-error').textContent = firstname === "" ? "First name is required." : "";
        document.getElementById('lastname-error').textContent = lastname === "" ? "Last name is required." : "";
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

</script>
</head>
<body class="container">
    <?php
    if (!isset($_SESSION["loggedin"])||(isset($_SESSION['role'])&&$_SESSION['role']!='admin')) {
        header("Location: Loginpage.php");
    }
    $adminFirstName = $_SESSION['admin_first_name'];
    include('get_admin_info.php');
     ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="adminhomepage.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="#" class="active"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">My Profile</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($adminFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
                                <form class="wide-form" action="update_admin_info.php" method="POST" onsubmit="return validateForm()">
                                <div class="center-align-div-admin-pfpage">
                                <div class="input-group-admin-profilepage">
                                    <p class="edit-info-p">First Name</p>
                                    <input type="text" id="firstname" name="adminfirstname" placeholder="First name" value="<?php echo $adminFirstName ?>" required>
                                    <span class="error-message error" id="firstname-error"></span>
                                </div>
                                <div class="input-group-admin-profilepage">
                                    <p class="edit-info-p">Last Name</p>
                                    <input type="text" id="lastname" name="adminlastname" placeholder="Last name" value="<?php echo $adminLastName ?>" required>
                                    <span class="error-message error" id="lastname-error"></span>
                                </div>
                                <div class="input-group-admin-profilepage">
                                    <p class="edit-info-p">Email</p>
                                    <input type="email" id="email" name="adminemail" placeholder="Email" value="<?php echo $adminEmail ?>" required>
                                    <span class="error-message error" id="email-error"><?php if (isset($email_error_message))
                                    echo "The email address you entered is taken.";
                                else
                                echo '';?></span>
                                </div>
                                <div class="input-group-admin-profilepage">
                                    <p class="edit-info-p">Password</p>
                                    <input type="password" id="password" name="adminpassword" placeholder="Password" value="<?php echo $adminPassword ?>" required>
                                    <span class="error-message error" id="password-error"></span>
                                    <div style="width:75%"class="left-align-div"><label style="width:20em"> <input style="width:20%"type="checkbox" onclick="togglePassword()">View Password</label></div>
                                    <button type="submit" class="btn-save-changes">Save Changes</button>
                                </div>
                                
                                </div>
                                
                                </form>
                        </div>
        </div>
    </div>
    
</body>
</html>
