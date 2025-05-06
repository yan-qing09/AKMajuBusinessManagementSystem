<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$COdate = $_POST['COdate'];
$COremark = $_POST['COremark'];

// Start a transaction to ensure data consistency across tables
$con->autocommit(false);

$Cid = $row6['C_id'];

// Instead of using $stmtCustomer->insert_id, use the manually generated ID
$customerId = $Cid;

$TOP_name = $_POST['TOP']; // Assuming 'TOP' is the key for TOP_name in your form

// Prepare a query to fetch AO_TOP based on TOP_name
$queryFetchCOTOP = "SELECT TOP_id FROM tb_terms_of_payment WHERE TOP_name = ?";
$stmtFetchCOTOP = $con->prepare($queryFetchCOTOP);
$stmtFetchCOTOP->bind_param("s", $TOP_name);
$stmtFetchCOTOP->execute();
$resultFetchCOTOP = $stmtFetchCOTOP->get_result();

if ($resultFetchCOTOP && $resultFetchCOTOP->num_rows > 0) {
    // Fetch the AO_TOP value
    $row = $resultFetchCOTOP->fetch_assoc();
    $CO_TOP = $row['TOP_id'];

} else {
    // Handle the case where TOP_name doesn't exist or error in fetching
    echo "Error fetching CO_TOP based on TOP_name.";
}

// Update tb_advertisement_order without AO_discAmt (discount amount)
$sqlOrder = "UPDATE tb_construction_order 
             SET C_id = ?, 
                 O_date = ?, 
                 O_remark = ?, 
                 O_TOP = ?, 
                 O_status = 2 
             WHERE O_id = ?";
$stmtOrder = $con->prepare($sqlOrder);

// Assuming variables have been retrieved or set earlier in your code
$stmtOrder->bind_param("sssis", $customerId, $COdate, $COremark, $CO_TOP, $co_id);

if ($stmtOrder->execute()) {
    // Handle success after executing the update query
    // e.g., Redirect to a success page, display a success message, etc.
} else {
    // Handle the case where the execution failed
    echo "Error updating order.";
    $con->rollback(); // Rollback if the update failed
}

$con->commit();

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

// Close prepared statements and connection
$stmtOrder->close();
// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'EditCOrder.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>