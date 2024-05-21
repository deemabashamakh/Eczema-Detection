<!DOCTYPE html>
<html>
<head>
    <title>Previous Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <?php
    session_start();
    include 'db_connection.php'; 
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: Loginpage.php");
        exit;
    }
    //$_SESSION['loggedin'] = true;
    //$_SESSION['role'] = 'patient';
    if (isset($_SESSION["role"]) && $_SESSION["role"]=='patient') {
        $email = $_SESSION['patient_email'];
        // Fetch patient's details using the email
        $stmt = $conn->prepare("SELECT patientID, patientFirstName FROM patient WHERE patientEmail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $patientDetails = $result->fetch_assoc();
        $patientID = $patientDetails['patientID'];
        $patientFirstName = $patientDetails['patientFirstName'];
    ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="Uploading Image.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="#" class="active"><i class="fas fa-user"></i> All Results</a>
            <a href="patient_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Previous Results</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($patientFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
        <div class="prev-results-wrapper">
            <?php 
                $sql = "SELECT * FROM imageUploadedByPatient join patient on patientID=uploaderID ORDER BY imgID DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="prev-results-card">
                            <img src="my_flask_app/'.htmlspecialchars($row["imageLoc"]).'" alt="'.htmlspecialchars($row["imageLoc"]).'">
                            <div class="prev-results-container">
                                <h4><b> Uploaded on: '.htmlspecialchars($row["dateUploaded"]).'</b></h4>
                                <p> Result: '.(htmlspecialchars($row["result"])==1?"Eczema":"No eczema").'</p>
                            </div>
                        </div>'; 
                    } }
            ?>
            </div>
        </div>
    </div>
   <?php
        $stmt->close();
        $conn->close(); }?>
    
</body>
</html>
