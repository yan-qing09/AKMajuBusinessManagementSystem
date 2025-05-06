<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$AKnegeri = $_POST['AKnegeri'];
$AKdaerah = $_POST['AKdaerah'];
$AKkawasan = $_POST['AKkawasan'];
$AKtambahan = $_POST['AKtambahan'];

$sqlAkawasan = "UPDATE tb_order_zone SET Z_state = ?, Z_region = ?, Z_distance = ? WHERE O_id = ? AND CM_ctgy = 2";
$stmtAkawasan = $con->prepare($sqlAkawasan);
$stmtAkawasan->bind_param("ssss", $AKnegeri, $AKdaerah, $AKkawasan, $co_id);
$stmtAkawasan->execute();

if ($stmtAkawasan->error) {
    echo "Error updating tb_construction_order: " . $stmtAkawasan->error;
    $con->rollback();
} 

$sqlEtambahan = "UPDATE tb_construction_order SET AK_addon = ? WHERE O_id = ?";
$stmtEtambahan = $con->prepare($sqlEtambahan);
$stmtEtambahan->bind_param("ss", $AKtambahan, $co_id);

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