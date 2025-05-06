<?php
include('dbconnect.php'); 
include('mysession.php'); 

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the edited material details from the POST request
    $materialID = $_POST['materialID'];
    $Munit = $_POST['Munit'];
    $Mprice = $_POST['Mprice'];
    $Mcost = $_POST['Mcost'];
    $Mquantity = $_POST['Mquantity'];
    $MdiscountPerc = $_POST['MdiscountPerc'];
    $MdiscountAmt = $_POST['MdiscountAmt'];
    $taxcode = $_POST['taxcode'];
    $taxamount = $_POST['taxamount'];
    $ao_id = $_POST['o_id'];

    $AOM_price = $Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount;

    // Prepare the SQL statement with placeholders
    $sql = "UPDATE tb_ao_material SET
            AOM_unit = ?,
            AOM_adjustprice = ?,
            AOM_origincost = ?,
            AOM_totalprice = ?,
            AOM_qty = ?,
            AOM_discPct = ?,
            AOM_discAmt = ?,
            AOM_taxcode = ?,
            AOM_taxAmt = ?
            WHERE AM_id = ? AND O_id = ?";

    // Prepare the query
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters with the statement
    mysqli_stmt_bind_param($stmt, "ddddiddsdss", $Munit, $Mprice, $Mcost, $AOM_price, $Mquantity, $MdiscountPerc, $MdiscountAmt, $taxcode, $taxamount, $materialID, $ao_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo "Material details updated successfully";
    } else {
        echo "Error updating material details: " . mysqli_error($con);
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
    $sqlUpdateOrder = "UPDATE tb_advertisement_order SET O_totalCost = ?, O_totalPrice = ? WHERE O_id = ?";
    $stmtUpdateOrder = $con->prepare($sqlUpdateOrder);
    $stmtUpdateOrder->bind_param("dds", $totalCost, $totalPrice, $ao_id);
    $stmtUpdateOrder->execute();

    if ($stmtUpdateOrder->error) {
        echo "Error updating tb_advertisement_order: " . $stmtUpdateOrder->error;
        $con->rollback();
    } 
} else {
    echo "Error calculating totalCost and totalPrice.";
    $con->rollback();
}

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>