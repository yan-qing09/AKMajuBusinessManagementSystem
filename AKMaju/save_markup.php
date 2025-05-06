<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$OMarkup = $_GET['OMarkup'];

$totalPrice = ((100+$OMarkup)/100) * $row6['O_totalCost'];

// Update tb_advertisement_order with totalCost and totalPrice
$sqlUpdateOrder = "UPDATE tb_construction_order SET O_totalPrice = ?, CO_markup = ? WHERE O_id = ?";
$stmtUpdateOrder = $con->prepare($sqlUpdateOrder);
$stmtUpdateOrder->bind_param("dds", $totalPrice, $OMarkup, $co_id);
$stmtUpdateOrder->execute();

$con->commit();

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'save_CAddorder.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>

