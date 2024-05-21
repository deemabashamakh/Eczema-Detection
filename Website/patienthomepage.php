<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <?php
    session_start();
    if (!isset($_SESSION["loggedin"])||$_SESSION['role']!='patient') {
        header("Location: Loginpage.php");
    }
    $patientFirstName = $_SESSION['patient_first_name'];
     ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="#" class="active"><i class="fas fa-home"></i> Homepage</a>
            <a href="patient_view_prev_results.php"><i class="fas fa-user"></i> Previous Results</a>
            <a href="patient_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Homepage</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($patientFirstName); ?></span>
            </div>
        </div>
    </div>
    
</body>
</html>
