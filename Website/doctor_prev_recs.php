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
    ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="doctorhomepage.php" ><i class="fas fa-home"></i> Homepage</a>
            <a href="dr_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="Uploading Image.php"><i class="fas fa-sign-out-alt"></i> Upload Image</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Previous Results</div>
            <div class="header-user">
                <span class="user-greeting">Hello, Dr. <?php echo htmlspecialchars($doctorFirstName); ?></span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
        <div class="prev-results-wrapper">
            <?php 
                $sql = "SELECT * FROM imageUploadedByDoctor join doctor on doctorID=uploaderID ORDER BY imgID DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="prev-results-card">
                            <img src="my_flask_app/'.htmlspecialchars($row["imageLoc"]).'" alt="'.htmlspecialchars($row["imageLoc"]).'">
                            <div class="prev-results-container">
                                <h4><b> Patient: </b>'.htmlspecialchars($row["patientFirstName"]).' '.htmlspecialchars($row["patientLastName"]).'</h4>
                                <p> Uploaded on: '.htmlspecialchars($row["dateUploaded"]).'</p>
                                <p> Result: '.(htmlspecialchars($row["dateUploaded"])==1?"Eczema":"No eczema").'</p>
                                <p> Comment: '.(htmlspecialchars($row["doctorComment"])).'</p>
                            </div>
                        </div>'; 
                    } }
            ?>
            </div>
        </div>
    </div>
    
</body>
</html>
