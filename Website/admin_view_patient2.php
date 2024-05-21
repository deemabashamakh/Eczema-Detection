<!-- <!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <?php
    // session_start();
    // include("db_connection.php");
    // if (!isset($_SESSION["loggedin"])||(isset($_SESSION['role'])&&$_SESSION['role']!='admin')) {
    //     header("Location: Loginpage.php");
    // }
    // $adminFirstName = $_SESSION['admin_first_name'];
     ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="adminhomepage.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="admin_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Patients</div>
            <div class="header-user">
                <span class="user-greeting">Hello, // echo htmlspecialchars($adminFirstName); </span>
            </div>
        </div>
        <div class="admin-homepage-lower-part">
        <table class="table">
    <tr>
        <th>Patient ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date of Birth</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Password</th>
    </tr>
    <?php
    // $sql = "SELECT * FROM patient";
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     // Output data of each row
    //     while($row = $result->fetch_assoc()) {
    //         echo "<tr>
    //                 <td>" . htmlspecialchars($row["patientID"]) . "</td>
    //                 <td>" . htmlspecialchars($row["patientFirstName"]) . "</td>
    //                 <td>" . htmlspecialchars($row["patientLastName"]) . "</td>
    //                 <td>" . htmlspecialchars($row["patientDOB"]) . "</td>
    //                 <td>" . htmlspecialchars($row["patientEmail"]) . "</td>
    //                 <td>" . htmlspecialchars($row["patientGender"]) . "</td>
    //                 <td>" . htmlspecialchars($row["patientPassword"]) . "</td>
    //               </tr>";
    //     }
    // } else {
    //     echo "<tr><td colspan='7'>No results found</td></tr>";
    // }
    // $conn->close();
    ?>
</table>
        </div>
    </div>
    
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <?php
    session_start();
    include("db_connection.php");
    if (!isset($_SESSION["loggedin"]) || (isset($_SESSION['role']) && $_SESSION['role'] != 'admin')) {
        header("Location: Loginpage.php");
    }
    $adminFirstName = $_SESSION['admin_first_name'];
    ?>
    <div class="admin-homepage-sidebar">
        <h2 class="sidebar-title">Eczema Detector</h2>
        <nav class="sidebar-nav">
            <a href="adminhomepage.php"><i class="fas fa-home"></i> Homepage</a>
            <a href="admin_profile_page.php"><i class="fas fa-user"></i> My Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </div>
    <div class="right-panel-admin-homepage">
        <div class="right-panel-admin-homepage-header">
            <div class="header-title">Patients</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($adminFirstName); ?></span>
            </div>
        </div>
        <div class="admin-view-lower-part">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM patient";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["patientID"]) . "</td>
                                <td>" . htmlspecialchars($row["patientFirstName"]) . "</td>
                                <td>" . htmlspecialchars($row["patientLastName"]) . "</td>
                                <td>" . htmlspecialchars($row["patientDOB"]) . "</td>
                                <td>" . htmlspecialchars($row["patientEmail"]) . "</td>
                                <td>" . htmlspecialchars($row["patientGender"]) . "</td>
                                <td>" . htmlspecialchars($row["patientPassword"]) . "</td>
                                <td>
                                    <a href='admin_edit_patient.php?id=" . $row["patientID"] . "' class='edit-btn'>Edit</a>
                                    <a href='delete_patient.php?id=" . $row["patientID"] . "' class='delete-btn'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No results found</td></tr>";
                }
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
