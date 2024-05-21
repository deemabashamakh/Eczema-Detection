<?php
session_start(); // Always start the session at the beginning of the script

// Check if an error message exists in the session
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    // Unset the error message after using it, so it doesn't persist unnecessarily
    unset($_SESSION['error_message']);
} else {
    $error_message = "";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="loginjs.js"></script>
</head>
<body class="container">
    <div class="left-panel">
        <div class="dot-div" style="margin-top: -10em;"></div>
        <span class="dot" style="margin-right: 2em; margin-left:-6.5em"></span>
        <span class="dot" style="margin-left: 2em;"></span>
    </div>
    <div class="right-panel">
        <h1 style="text-align: center;" class="gray-text">Login</h1>
        <div class="login-container">
                <div id="tab-container" class="tab-container">
                    <button type="button" class="tab tab-left" onclick="openTab(event, 'admin')" id="defaultOpen">Admin</button>
                    <button type="button" class="tab" onclick="openTab(event, 'patient')">Patient</button>
                    <button type="button" class="tab tab-right" onclick="openTab(event, 'doctor')">Doctor</button>
                </div>
                <div class="hidden-div" id="admindiv">
                    <form class="login-form" action="processlogin.php" method="POST">
                        <div class="input-group">
                            <div class="left-align-div">
                                <p> Enter your email</p>
                                <input type="email" id="email" name="admin_email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="left-align-div">
                                <p> Enter your password</p>
                                <input type="password" id="password" name="password" placeholder="Password" required>
                            </div>
                            <?php if (!empty($error_message)): ?>
                                <span class="error"><?php echo $error_message; ?></span>
                                <?php endif; ?>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                        <a href="resetpassword.php" class="forgot-password">Forgot your password?</a>
                    </form>
                </div>
                <div class="hidden-div" id="doctordiv">
                    <form class="login-form" action="processlogin.php" method="POST">
                        <div class="input-group">
                            <div class="left-align-div">
                                <p> Enter your email</p>
                                <input type="email" id="email" name="doctor_email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="left-align-div">
                                <p> Enter your password</p>
                                <input type="password" id="password" name="password" placeholder="Password" required>
                            </div>
                            <?php if (!empty($error_message)): ?>
                                <span class="error"><?php echo $error_message; ?></span>
                                <?php endif; ?>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                        <a href="resetpassword.php" class="forgot-password">Forgot your password?</a>
                    </form>
                </div>
                <div class="hidden-div" id="patientdiv">
                    <form class="login-form" action="processlogin.php" method="POST">
                        <div class="input-group">
                            <div class="left-align-div">
                                <p> Enter your email</p>
                                <input type="email" id="email" name="patient_email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="left-align-div">
                                <p> Enter your password</p>
                                <input type="password" id="password" name="password" placeholder="Password" required>
                            </div>
                            <?php if (!empty($error_message)): ?>
                                <span class="error"><?php echo $error_message; ?></span>
                                <?php endif; ?>
                                <span class="forgot-password"><a href="patient_sign_up.php">Don't have an account? Sign up here!</a></span>
                        </div>
                        <button type="submit" class="btn-login">Login</button>
                        <a href="resetpassword.php" class="forgot-password">Forgot your password?</a>
                    </form>
                </div>
            </div> 
    </div>
        </body>
</html>
