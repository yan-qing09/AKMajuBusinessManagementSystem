<?php
include('dbconnect.php');

// Assuming $userid holds the user ID for whom you want to retrieve the latest file
$userid = $_GET['id'];

$sigid = $_GET['sigid'];

// Query to fetch the latest uploaded file for the given user
$sql = "SELECT * 
        FROM tb_signature 
        WHERE U_id = '$userid' AND S_id = '$sigid'";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $filePath = $row['S_path'];

    header("Location: $filePath");
    exit();
} else {
    echo "No files found for the user.";
}

mysqli_close($con);
?>
