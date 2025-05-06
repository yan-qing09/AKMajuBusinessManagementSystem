<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$ao_id = $_GET['o_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

// Start a transaction to ensure data consistency across tables
$con->autocommit(false);

// Retrieve the values from the POST array
$deposit = $_POST['deposit'] ?? ''; // Deposit amount
$pmethod = $_POST['pmethod'] ?? ''; // Payment method
$pdate = $_POST['pdate'] ?? ''; // Payment date

// Now you can use these values in your PHP code, for example, to update a database

// For example, assuming you have a database connection established ($con), you might execute an SQL query to update a table:
$sql = "UPDATE tb_advertisement_order SET AO_deposit = ?, AO_payMethod = ?, AO_payDate = ? WHERE O_id = ?"; // Modify this query according to your database schema


$stmt = $con->prepare($sql);
if ($stmt) {

    $stmt->bind_param("diss", $deposit, $pmethod, $pdate, $ao_id);
    $stmt->execute();

    $stmt->close();
} else {
    echo "Error preparing statement: " . $con->error;
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
$redirectURL = 'EditAOrder.php?id=' . $rows['U_id'] . '&o_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>