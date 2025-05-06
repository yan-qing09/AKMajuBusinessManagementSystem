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

$Tukang = $_GET['Tukang'];
$BUnit = $_GET['BUnit'];
$BKawasan = $_GET['BKawasan'];

// Update the database with calculated costs and prices
$sqlBuruh = "INSERT INTO tb_order_rate (AK_name, AKR_unit, AK_region, AK_ctgy, O_id)
                  VALUES (?, ?, ?, 'T', ?)";
$stmtBuruh = $con->prepare($sqlBuruh);
$stmtBuruh->bind_param("siss", $Tukang, $BUnit, $BKawasan, $co_id);
$stmtBuruh->execute();

if ($stmtBuruh->error) {
    echo "Error inserting into tb_ak_order: " . $stmtBuruh->error;
    $con->rollback();
} else {
    $con->commit();
}

// Close the statements
$stmtBuruh->close();
// Close the connection
$con->close();

// Redirect to a specific URL
$redirectURL = 'AddKABuruh.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();