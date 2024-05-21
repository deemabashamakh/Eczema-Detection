<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eczema Detector - Patient Info</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="style.css">
<script>
function showEditForm() {
  document.getElementById('display-info').style.display = 'none';
  document.getElementById('edit-info').style.display = 'block';
}

function hideEditForm() {
  document.getElementById('edit-info').style.display = 'none';
  document.getElementById('display-info').style.display = 'block';
}
</script>
</head>
<body>

<div class="container">
  <header>
    <h1>Eczema Detector</h1>
  </header>

  <aside class="sidebar">
    <nav>
      <ul>
        <li><a href="adminhomepage.php">Homepage</a></li>
        <li><a href="admin_profile_page.php">My Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </aside>

  <main>
    <?php
    //db configuration
    $servername = "localhost";
    $username = "root";
    $password = "root"; 
    $dbname = "eczema_detection";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $patient_id = intval($_POST['patientID']);
        $name = $_POST['patientFirstName'] ?? null;
        $dob = $_POST['patientDOB'] ?? null;
        $email = $_POST['patientEmail'] ?? null;
        $username = $_POST['patientUsername'] ?? null;
        $phone = $_POST['patientPhoneNum'] ?? null;

        $stmt = $conn->prepare("UPDATE patient SET patientFirstName=?, patientDOB=?, patientEmail=?, patientUsername=?, patientPhoneNum=? WHERE patientID=?");
        $stmt->bind_param("sssssi", $name, $dob, $email, $username, $phone, $patient_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Patient information updated successfully.');</script>";
        } else {
            echo "<script>alert('No changes were made to the patient information.');</script>";
        }
        $stmt->close();
    }

    ?>
    <div class="patients-list">
      <h2>Patient Information</h2>
      <a href="admin_add_patient.php">
        <button type="button">Add Patient</button>
      </a>
      <ul>
        <?php
        $sql = "SELECT patientID, patientFirstName FROM patient";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li><a href='?patientID=" . $row["patientID"] . "'>" . htmlspecialchars($row["patientFirstName"]) . "</a></li>";
            }
        } else {
            echo "<li>No patients found</li>";
        }
        ?>
      </ul>
    </div>

    <div class="patient-info">
      <?php
      if(isset($_GET['patientID'])) {
        $patient_id = intval($_GET['patientID']);
        $stmt = $conn->prepare("SELECT * FROM patient WHERE patientID = ?");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $patient = $result->fetch_assoc();
            ?>
            <div id="display-info">
              <h3>Name: <?php echo htmlspecialchars($patient["patientFirstName"]); ?></h3>
              <p>Date of Birth: <?php echo htmlspecialchars($patient["patientDOB"]); ?></p>
              <p>Email: <a href='mailto:<?php echo htmlspecialchars($patient["patientEmail"]); ?>'><?php echo htmlspecialchars($patient["patientEmail"]); ?></a></p>
              <p>Username: <?php echo htmlspecialchars($patient["patientUsername"]); ?></p>
              <p>Phone Number: <?php echo htmlspecialchars($patient["patientPhoneNum"]); ?></p>
              <button onclick="showEditForm()">Edit Info</button>
            </div>
            <div id="edit-info" style="display:none;">
              <form method="post">
                <input type="hidden" name="patientID" value="<?php echo $patient_id; ?>">
                Name: <input type="text" name="patientFirstName" value="<?php echo htmlspecialchars($patient["patientFirstName"]); ?>"><br>
                Date of Birth: <input type="date" name="patientDOB" value="<?php echo htmlspecialchars($patient["patientDOB"]); ?>"><br>
                Email: <input type="email" name="patientEmail" value="<?php echo htmlspecialchars($patient["patientEmail"]); ?>"><br>
                Username: <input type="text" name="patientUsername" value="<?php echo htmlspecialchars($patient["patientUsername"]); ?>"><br>
                Phone Number: <input type="text" name="patientPhoneNum" value="<?php echo htmlspecialchars($patient["patientPhoneNum"]); ?>"><br>
                <button type="submit" name="update">Update</button>
                <button type="button" onclick="hideEditForm()">Cancel</button>
              </form>
            </div>
            <?php
            $stmt->close();
        } else {
            echo "<p>Patient not found.</p>";
        }
      } else {
        echo "<p>Please select a patient from the list.</p>";
      }
      $conn->close();
      ?>
    </div>
  </main>
</div>

</body>
</html>
