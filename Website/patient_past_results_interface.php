<!-- <!DOCTYPE html>
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
            <a href="patienthomepage.php" class="active"><i class="fas fa-home"></i> Homepage</a>
            <a href="#" class='active'><i class="fas fa-user"></i> Previous Results</a>
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
</html> -->
<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['userID']) || $_SESSION['userRole'] != 'patient') {
    header('Location: login.php');
    exit();
}

$uploaderID = $_SESSION['userID'];
$dateFilter = isset($_GET['date']) ? $_GET['date'] : null;

// Validate the date format or sanitize the input here
if ($dateFilter && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFilter)) {
    echo "Invalid date format.";
    exit;
}

$query = "SELECT imgID, dateUploaded, result FROM imageUploadedByPatient WHERE uploaderID = ? ORDER BY imgID DESC";
if ($dateFilter) {
    $query .= " AND dateUploaded = ?";
}

if ($stmt = $conn->prepare($query)) {
    if ($dateFilter) {
        $stmt->bind_param("is", $uploaderID, $dateFilter);
    } else {
        $stmt->bind_param("i", $uploaderID);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $images = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    echo "Failed to prepare the statement.";
    exit;
}

if (empty($images)) {
    echo "No results found.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eczema Detector</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="sidebar">
    <h2>Eczema Detector</h2>
    <a href="patienthomepage.php" ><i class="fas fa-home"></i> Homepage</a>
    <a href="#" class="active"><i class="fas fa-user"></i> All Results</a>
            <a href="patient_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Patient Info Homepage</h1>
        <div class="user-info">
            <img src="profile-icon.png" alt="User" width="40" height="40">
            <span>Hello, <?php echo $_SESSION['username']; ?></span>
        </div>
    </div>

    <?php foreach ($images as $image): ?>
    <div class="card">
        <div class="date">
            <button onclick="window.location.href='Patient_results.php?date=<?php echo htmlspecialchars($image['dateUploaded']); ?>'">
                <img src="date-icon.png" alt="Date">
                <span><?php echo htmlspecialchars(date('m/d/Y', strtotime($image['dateUploaded']))); ?></span>
            </button>
        </div>
        <div class="results">
            <img src="uploads/<?php echo htmlspecialchars($image['imgID']); ?>.jpg" alt="Uploaded Image">
            <h3><?php echo htmlspecialchars($image['result']); ?>!</h3>
            <p>The photo uploaded on <?php echo htmlspecialchars(date('m/d/Y', strtotime($image['dateUploaded']))); ?> was determined to be <?php echo htmlspecialchars($image['result']); ?> by our system. Please consult a doctor for further evaluation.</p>
        </div>
    </div>
    <?php endforeach; ?>

</div>

</body>
</html>

