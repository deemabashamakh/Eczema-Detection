<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $doctorID = $_GET['id'];
    $sql = "DELETE FROM doctor WHERE doctorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctorID);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_view_doctor2.php");
    exit();
}
?>
