<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eczema Detector - Add Patient</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <header>
    <h1>Eczema Detector</h1>
    <div class="user-info">
      <span>Hello, Admin</span>
    </div>
  </header>
  <aside class="sidebar">
    <nav>
      <ul>
        <li><a href="adminhomepage.php">Homepage</a></li>
        <li><a href="admin_profile_page.php">My Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="#">Settings</a></li>
      </ul>
    </nav>
    <div class="support">
      <a href="#">Help & Support</a>
    </div>
  </aside>
  <main>
    <header>
      <h1>Add Patient</h1>
    </header>
    <div class="form-section">
      <?php
      // Check if the form was submitted
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Database configuration
          $servername = "localhost";
          $username = "root";
          $password = "root";
          $dbname = "eczema_detection";

          // Create a new database connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Get the form data and escape it to prevent SQL Injection
          $firstName = $conn->real_escape_string($_POST['name']);
          $lastName = $conn->real_escape_string($_POST['lastName']);
          $dob = $conn->real_escape_string($_POST['dob']);
          $email = $conn->real_escape_string($_POST['email']);
          $username = $conn->real_escape_string($_POST['username']);
          $phone = $conn->real_escape_string($_POST['phone']);
          $gender = $conn->real_escape_string($_POST['gender']); // Added handling for gender

          // Prepare the SQL statement to insert the new patient
          $stmt = $conn->prepare("INSERT INTO patient (patientFirstName, patientLastName, patientDOB, patientEmail, patientUsername, patientPhoneNum, patientGender) VALUES (?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("sssssss", $firstName, $lastName, $dob, $email, $username, $phone, $gender);

          // Execute the statement and check for errors
          if($stmt->execute()) {
            $_SESSION['num_patients']++;
              echo "<p>New patient added successfully.</p>";
          } else {
              echo "<p>ERROR: " . $stmt->error . "</p>";
          }

          // Close the statement and the connection
          $stmt->close();
          $conn->close();
      }
      ?>
      <form class="add-patient-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
          <label for="name">First Name</label>
          <input type="text" id="name" name="name" required>
          </div>

          <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" required>
          </div>

          <div class="form-group">
          <label for="dob">Date of Birth</label>
          <input type="date" id="dob" name="dob" required>
          </div>

          <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>
          </div>

          <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" required>
          </div>

          <div class="form-group">
          <label for="gender">Gender</label>
          <select id="gender" name="gender" required>
              <option value="M">Male</option>
              <option value="F">Female</option>
              <option value="O">Other</option>
          </select>
          </div>

          <div class="form-group">
          <button type="submit">Add</button>
          </div>
      </form>
    </div>
  </main>
</div>

</body>
</html>
