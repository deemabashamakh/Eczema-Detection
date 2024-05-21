<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <div class="left-panel">
        <div class="dot-div" style="margin-top: -10em;"></div>
        <span class="dot" style="margin-right: 2em; margin-left:-6.5em"></span>
        <span class="dot" style="margin-left: 2em;"></span>
    </div>
    <div class="right-panel">
        <div class="center-align-div">
        <h1 style="text-align: center;" class="gray-text">Forgot Password</h1>
            <?php
            if (isset($_GET["code"])) {
                if ($_GET["code"]== 1) {
                    echo '<form class="login-form" action="update_password.php" method="POST">';
                        echo '<div class="input-group">';
                        echo '<div class="left-align-div">';
                            echo'<p> Enter your new password: </p>';
                            echo '<input type="text" id="new_pass" name="new_password" placeholder="New password" required>';
                            echo '<p class="error">'; 
                           echo ' </p> </div> </div>';
                        echo '<button type="submit" class="btn-send">Update Password</button>';
                        echo '</form>';
                        unset($_GET["code"]); }}
            else if (isset($_GET["email_status"])) {
                if ($_GET["email_status"]== 'sent') {
                    echo '<form class="login-form" action="verify_reset_code.php" method="POST">';
                        echo '<div class="input-group">';
                        echo '<div class="left-align-div">';
                            echo'<p> Enter the code you received: </p>';
                            echo '<input type="text" id="code_received" name="code" placeholder="Code" required>';
                            echo '<p class="error">';  ?> <?php if (isset($_SESSION['code_incorrect'])) {
                                echo($_SESSION['code_incorrect']);
                                unset($_SESSION['code_incorrect']);
                            }
                            else {
                                echo '';
                                }
                           echo ' </p> </div> </div>';
                        echo '<button type="submit" class="btn-send">Submit code</button>';
                        echo '</form>';
                        unset($_GET["email_status"]); }}
                           else {
                            echo '<form class="login-form" action="password_reset_request.php" method="POST">';
                            echo '<div class="input-group">';
                            echo '<div class="left-align-div">';
                               echo  '<p> Enter your email</p>';
                                echo '<input type="email" id="email" name="email" placeholder="Email" required>';
                                echo '<p class="error">';  ?> <?php if (isset($_SESSION['reset_password_email_doesnt_exist'])) {
                                    echo($_SESSION['reset_password_email_doesnt_exist']);
                                    unset($_SESSION['reset_password_email_doesnt_exist']);
                                }
                                else {
                                    echo '';
                                    } 
                                echo ' </p> </div> </div>';
                        
                        echo '<button type="submit" class="btn-send">Send email</button>';
                    echo '</form>';} ?>
        </div>
    </div>
    
</body>
</html>