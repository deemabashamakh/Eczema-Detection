<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <?php
    session_start();
    if (!isset($_SESSION["loggedin"])||(isset($_SESSION['role'])&&$_SESSION['role']!='doctor')) {
        header("Location: Loginpage.php");
    }
    $email = $_SESSION['doctor_email'];

    // Database connection
    include 'db_connection.php'; 


    // Fetch doctor's details using the email
    $stmt = $conn->prepare("SELECT doctorID, doctorFirstName FROM doctor WHERE doctorEmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctorDetails = $result->fetch_assoc();

    $doctorID = $doctorDetails['doctorID'];
    $doctorFirstName = $doctorDetails['doctorFirstName'];

    // Fetch number of unique patients this doctor has seen
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT patientFirstName) AS numPatients FROM imageUploadedByDoctor WHERE uploaderID = ?");
    $stmt->bind_param("i", $doctorID);
    $stmt->execute();
    $result = $stmt->get_result();
    $numPatients = $result->fetch_assoc()['numPatients'];

    // Fetch total number of image uploads by this doctor
    $stmt = $conn->prepare("SELECT COUNT(imgID) AS numUploads FROM imageUploadedByDoctor WHERE uploaderID = ?");
    $stmt->bind_param("i", $doctorID);
    $stmt->execute();
    $result = $stmt->get_result();
    $numUploads = $result->fetch_assoc()['numUploads'];

    $stmt->close();
    $conn->close();
    ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="#" class="active"><i class="fas fa-home"></i> Homepage</a>
            <a href="dr_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="Uploading Image.php"><i class="fas fa-sign-out-alt"></i> Upload Image</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Homepage</div>
            <div class="header-user">
                <span class="user-greeting">Hello, Dr. <?php echo htmlspecialchars($doctorFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
            <div class="admin-homepage-cards">
                <div class="patient-details-card">
                    <h2>Previous Records</h2>
                    <h3><?php echo $numPatients; ?> patients </h3>
                    <hr>
                    <h3><a href="doctor_prev_recs.php">View Details</a></h3>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
