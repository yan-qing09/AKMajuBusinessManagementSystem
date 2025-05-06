<?php
include('dbconnect.php');

// Assuming $userid holds the user ID for whom you want to retrieve the latest file
$userid = $_GET['id'];
$qid = $_GET['aqid'];

// Query to fetch the latest uploaded file for the given user
$sql = "SELECT * FROM tb_advertisement_quotation WHERE AQ_id = '$qid'";

$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // The latest file details
    $latestFilePath = $row['AQ_path'];

    // Redirect to the latest file
    header("Location: $latestFilePath");
    exit();
} else {
    echo "No files found for the user.";
}

mysqli_close($con);
?>
