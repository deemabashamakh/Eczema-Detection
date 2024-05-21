<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $patientID = $_GET['id'];
    $sql = "DELETE FROM patient WHERE patientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patientID);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_view_patient2.php");
    exit();
}
?>
