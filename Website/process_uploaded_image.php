<?php
include('db_connection.php');
session_start();
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
//     header("Location: Loginpage.php");
//     exit;
// }
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // $json = file_get_contents('php://input');
    // $data = json_decode($json, true);
    if (isset($_GET['doctorID']) && isset($_GET['result'])&& isset($_GET['date'])&& isset($_GET['patientFirstName'])&& isset($_GET['patientLastName'])) {
        $uploaderID=$_GET['doctorID'];
        $result=$_GET['result'];
        if ($result== "['eczema']") 
            $result= "1";
        else
        $result= "0";
        $date=$_GET['date'];
        $patientFirstName=$_GET['patientFirstName'];
        $patientLastName=$_GET['patientLastName'];
        $doctorComment=$_GET['doctorComment'];
        $imageLoc=$_GET['imageLoc'];
        $doctorComment=$_GET['doctorComment'];
        $stmt = $conn->prepare("INSERT INTO imageUploadedByDoctor (uploaderID, result, dateUploaded, patientFirstName, patientLastName, doctorComment,imageLoc) VALUES (?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param('issssss', $uploaderID, $result, $date, $patientFirstName, $patientLastName, $doctorComment,$imageLoc);
        }
        else {
            $uploaderID=$_GET['patientID'];
            $date=$_GET['date'];
            $imageLoc=$_GET['imageLoc'];
            $result=$_GET['result'];
        if ($result== "['eczema']") 
            $result= "1";
        else
            $result= "0";
        $date=$_GET['date'];
        $stmt = $conn->prepare("INSERT INTO imageUploadedByPatient (uploaderID, result, dateUploaded,imageLoc) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $uploaderID, $result, $date,$imageLoc);
        }
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        if ($stmt->execute()) {
            header('Location: Uploading Image.php?status=success');
} else {
    header('Location: Uploading Image.php?status=failed');
}
$stmt->close();
$conn->close();

    }
    else {
        header('Location: Uploading Image.php?status=failed');
    }