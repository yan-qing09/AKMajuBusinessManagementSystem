<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$EKnegeri = $_POST['EKnegeri'];
$EKdaerah = $_POST['EKdaerah'];
$EKkawasan = $_POST['EKkawasan'];
$EKtambahan = $_POST['EKtambahan'];

$sqlEKawasan = "UPDATE tb_order_zone SET Z_state = ?, Z_region = ?, Z_distance = ? WHERE O_id = ? AND CM_ctgy = 1";
$stmtEKawasan = $con->prepare($sqlEKawasan);
$stmtEKawasan->bind_param("ssss", $EKnegeri, $EKdaerah, $EKkawasan, $co_id);

$stmtEKawasan->execute();

if ($stmtEKawasan->error) {
    echo "Error inserting into tb_co_material: " . $stmtEKawasan->error;
    $con->rollback();
} 

$sqlEtambahan = "UPDATE tb_construction_order SET EK_addon = ? WHERE O_id = ?";
$stmtEtambahan = $con->prepare($sqlEtambahan);
$stmtEtambahan->bind_param("ss", $EKtambahan, $co_id);

$stmtEtambahan->execute();

if ($stmtEtambahan->error) {
    echo "Error inserting into tb_co_material: " . $stmtEtambahan->error;
    $con->rollback();
} 

$con->commit();

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'EditCOrder.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>