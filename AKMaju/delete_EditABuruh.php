<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$fid = $_GET['id'];
$sqls = "SELECT * FROM tb_user WHERE U_id='$fid'";
$result3 = mysqli_query($con, $sqls);
$rows = mysqli_fetch_array($result3);

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6 = mysqli_fetch_array($result6);

$akname = $_POST['AK_name'];
$akregion = $_POST['AK_region'];
$akctgy = $_POST['AK_ctgy'];
$coid = $_POST['CO_id'];

// Perform deletion in the database using prepared statements
$sqlDelete = "DELETE FROM tb_order_rate WHERE AK_name = ? AND O_id = ? AND AK_region = ? AND AK_ctgy = ?";
$stmtDelete = $con->prepare($sqlDelete);
$stmtDelete->bind_param("ssss", $akname, $coid, $akregion, $akctgy);
$stmtDelete->execute();

// ... Close other statements
$stmtDelete->close();
$con->close();

// Redirect to a specific URL
$redirectURL = 'EditKABuruh.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>

