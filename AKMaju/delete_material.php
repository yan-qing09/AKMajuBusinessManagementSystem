<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$fid = $_GET['id'];
$sqls = "SELECT * FROM tb_user WHERE U_id='$fid'";
$result3 = mysqli_query($con, $sqls);
$rows = mysqli_fetch_array($result3);

$ao_id = $_POST['ao_id'];

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
$result6 = mysqli_query($con, $sql5);
$row6 = mysqli_fetch_array($result6);

if (isset($_POST['material_id'])) {
    $materialID = $_POST['material_id'];

    // Perform deletion in the database using prepared statements
    $sqlDelete = "DELETE FROM tb_ao_material WHERE AM_id = ?";
    $stmtDelete = $con->prepare($sqlDelete);
    $stmtDelete->bind_param("s", $materialID);
    $stmtDelete->execute();

    if ($stmtDelete->error) {
        // Handle deletion error
        echo "Error deleting material: " . $stmtDelete->error;
    }

    // Compute the total cost and total price from tb_ao_material
    $sqlCalculateTotals = "SELECT SUM(AOM_totalcost) AS totalCost, SUM(AOM_totalprice) AS totalPrice FROM tb_ao_material WHERE O_id = ?";
    $stmtCalculateTotals = $con->prepare($sqlCalculateTotals);
    $stmtCalculateTotals->bind_param("s", $ao_id);
    $stmtCalculateTotals->execute();
    $resultTotals = $stmtCalculateTotals->get_result();

    if ($resultTotals && $resultTotals->num_rows > 0) {
        $rowTotals = $resultTotals->fetch_assoc();
        $totalCost = $rowTotals['totalCost'];
        $totalPrice = $rowTotals['totalPrice'];

        // Update tb_advertisement_order with totalCost and totalPrice
        $sqlUpdateOrder = "UPDATE tb_advertisement_order SET AO_totalCost = ?, AO_totalPrice = ? WHERE O_id = ?";
        $stmtUpdateOrder = $con->prepare($sqlUpdateOrder);
        $stmtUpdateOrder->bind_param("dds", $totalCost, $totalPrice, $ao_id);
        $stmtUpdateOrder->execute();

        if ($stmtUpdateOrder->error) {
            echo "Error updating tb_advertisement_order: " . $stmtUpdateOrder->error;
            // $con->rollback(); // This is not needed unless you started a transaction
        }
        // No commit here, as we are not using transactions
    }
}

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'EditAOrder.php?id=' . $rows['U_id'] . '&o_id=' . $row6['AO_id'];
header('Location: ' . $redirectURL);
exit();
?>