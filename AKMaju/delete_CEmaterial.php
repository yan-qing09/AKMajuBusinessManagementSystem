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

$materialID = $_POST['material_id'];
$materialType = $_POST['material_type'];
$materialVariation = $_POST['material_variation'];

// Perform deletion in the database using prepared // Perform deletion in the database using prepared statements
$sqlDelete = "DELETE FROM tb_co_material WHERE CM_id = ? AND CM_type = ? AND CM_variation = ?";
$stmtDelete = $con->prepare($sqlDelete);
$stmtDelete->bind_param("sss", $materialID, $materialType, $materialVariation);
$stmtDelete->execute();

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'AddCEOrdermaterial.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>

