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
    if (!isset($_SESSION["loggedin"])||(isset($_SESSION['role'])&&$_SESSION['role']!='admin')) {
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
            <div class="header-title">Doctors</div>
            <div class="header-user">
                <span class="user-greeting">Hello, <?php echo htmlspecialchars($adminFirstName); ?></span>
            </div>
        </div>
        <div class="admin-view-lower-part">
        <table class="table">
    <tr>
        <th>Doctor ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date of Birth</th>
        <th>Email</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>
    <?php
    $sql = "SELECT * FROM doctor";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["doctorID"]) . "</td>
                    <td>" . htmlspecialchars($row["doctorFirstName"]) . "</td>
                    <td>" . htmlspecialchars($row["doctorLastName"]) . "</td>
                    <td>" . htmlspecialchars($row["doctorDOB"]) . "</td>
                    <td>" . htmlspecialchars($row["doctorEmail"]) . "</td>
                    <td>" . htmlspecialchars($row["doctorPassword"]) . "</td>
                    <td>
                                    <a href='admin_edit_doctor.php?id=" . $row["doctorID"] . "' class='edit-btn'>Edit</a>
                                    <a href='delete_doctor.php?id=" . $row["doctorID"] . "' class='delete-btn'>Delete</a>
                                </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No results found</td></tr>";
    }
    $conn->close();
    ?>
</table>
<a style="margin-top:1em" href='admin_add_doctor.php' class='edit-btn'>Add Doctor</a>
        </div>
    </div>
    
</body>
</html>
