<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$Qstatus = $_POST['Qstatus'];

// Prepare and execute UPDATE queries for each status
$updateQueries = [
    "UPDATE tb_construction_order SET O_quotationStatus = ? WHERE O_id = ?"
];

$statusValues = [$Qstatus];
$statusColumns = ['O_quotationStatus'];

for ($i = 0; $i < count($updateQueries); $i++) {
    $stmt = $con->prepare($updateQueries[$i]);
    if ($stmt) {
        $stmt->bind_param("is", $statusValues[$i], $co_id); // Assuming $ao_id is available
        $stmt->execute();
    } else {
        echo "Error preparing statement: " . $con->error;
        // Handle the error accordingly, such as rolling back transactions, logging, etc.
    }
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