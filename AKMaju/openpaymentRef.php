<?php
include('dbconnect.php');

// Assuming $userid holds the user ID for whom you want to retrieve the latest file
$userid = $_GET['id'];
$aoid = $_GET['aoid'];
$pid = $_GET['pid'];

// Query to fetch the latest uploaded file for the given user
$sql = "SELECT * FROM tb_payment_ref WHERE U_id = '$userid' AND O_id = '$aoid' AND P_id = '$pid' ORDER BY P_uploadDate DESC LIMIT 1";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // The latest file details
    $latestFilePath = $row['P_path'];

    // Redirect to the latest file
    header("Location: $latestFilePath");
    exit();
} else {
    echo "No files found for the user.";
}

mysqli_close($con);
?>
