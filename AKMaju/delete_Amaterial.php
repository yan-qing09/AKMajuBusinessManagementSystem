<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$ao_id = $_GET['o_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$materialID = $_POST['material_id'];

// Perform deletion in the database using prepared // Perform deletion in the database using prepared statements
$sqlDelete = "DELETE FROM tb_ao_material WHERE AM_id = ?";
$stmtDelete = $con->prepare($sqlDelete);
$stmtDelete->bind_param("s", $materialID);
$stmtDelete->execute();

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'save_AOM2.php?id=' . $rows['U_id'] . '&o_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>

