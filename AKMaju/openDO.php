<?php
include('dbconnect.php');

// Assuming $userid holds the user ID for whom you want to retrieve the latest file
$userid = $_GET['id'];
$doid = $_GET['doid'];

// Query to fetch the latest uploaded file for the given user
$sql = "SELECT * FROM tb_delivery_order WHERE DO_id = '$doid'";

$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // The latest file details
    $latestFilePath = $row['DO_path'];

    // Redirect to the latest file
    header("Location: $latestFilePath");
    exit();
} else {
    echo "No files found for the user.";
}

mysqli_close($con);
?>
