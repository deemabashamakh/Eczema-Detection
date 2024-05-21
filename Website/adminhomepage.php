<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <?php
    session_start();
    if (!isset($_SESSION["loggedin"])||(isset($_SESSION['role'])&&$_SESSION['role']!='admin')) {
        header("Location: Loginpage.php");
    }
    $adminFirstName = $_SESSION['admin_first_name'];
     ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="#" class="active"><i class="fas fa-home"></i> Homepage</a>
            <a href="admin_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Homepage</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($adminFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
            <div class="admin-homepage-cards">
                <div class="patient-details-card">
                    <h2>Patient Details</h2>
                    <h3><?php echo $_SESSION['num_patients']?> patients </h3> <hr>
                    <h3><a href="admin_view_patient2.php"> View Details </a></h3>
                </div>
                <div class="doctor-details-card">
                <h2>Doctor Details</h2>
                    <h3><?php echo $_SESSION['num_doctors']?> doctors </h3> <hr>
                    <h3><a href="admin_view_doctor2.php"> View Details </a></h3>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
