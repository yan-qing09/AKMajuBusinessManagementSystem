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
    $taxcode = $_POST['taxcode'];
    $taxamount = $_POST['taxamount'];
    $ao_id = $_POST['ao_id'];

    // Start a transaction to ensure data consistency
    $con->begin_transaction();

if (empty($_POST['MdiscountAmt'])&&empty($_POST['MdiscountPerc'])) {
    // Calculate discount amount if discount percentage is provided
    $MdiscountPerc = 0;
    $MdiscountAmt = 0;
} elseif (empty($_POST['MdiscountAmt'])) {
    // Calculate discount amount if discount percentage is provided
    $MdiscountPerc = $_POST['MdiscountPerc'];
    $MdiscountAmt = ($MdiscountPerc / 100) * ($Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount);
} elseif (empty($_POST['MdiscountPerc'])) {
    // Calculate discount percentage if discount amount is provided
    $MdiscountAmt = $_POST['MdiscountAmt'];
    $MdiscountPerc = (($MdiscountAmt / ($Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount)) * 100);
} else {
    // Both discount percentage and discount amount are provided
    $MdiscountPerc = $_POST['MdiscountPerc'];
    $MdiscountAmt = $_POST['MdiscountAmt'];
}

    // Calculate total cost and price for the material
    $AOM_cost = $Munit * $Mquantity * $Mcost;
    $AOM_price = $Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount;

    // Prepare the SQL statement with placeholders
    $sql = "UPDATE tb_ao_material SET
            AOM_unit = ?,
            AOM_adjustprice = ?,
            AOM_qty = ?,
            AOM_discPct = ?,
            AOM_discAmt = ?,
            AOM_taxcode = ?,
            AOM_taxAmt = ?,
            AOM_totalcost = ?,
            AOM_totalprice = ?
            WHERE AM_id = ? AND O_id = ?";

    // Prepare the query
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters with the statement
    mysqli_stmt_bind_param($stmt, "ddiddsdddss", $Munit, $Mprice, $Mquantity, $MdiscountPerc, $MdiscountAmt, $taxcode, $taxamount, $AOM_cost, $AOM_price, $materialID, $ao_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo "Material details updated successfully";

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
            $sqlUpdateOrder = "UPDATE tb_advertisement_order SET O_totalcost = ?, O_totalprice = ? WHERE O_id = ?";
            $stmtUpdateOrder = $con->prepare($sqlUpdateOrder);
            $stmtUpdateOrder->bind_param("dds", $totalCost, $totalPrice, $ao_id);
            $stmtUpdateOrder->execute();

            if ($stmtUpdateOrder->error) {
                echo "Error updating tb_advertisement_order: " . $stmtUpdateOrder->error;
                $con->rollback();
            } else {
                // Commit the transaction
                $con->commit();
            }
        } else {
            echo "Error calculating totalCost and totalPrice.";
            $con->rollback();
        }
    } else {
        // Send the SQL query and error as part of the response
    $errorInfo = array(
        'error' => "Error updating material details: " . mysqli_error($con),
        'sqlQuery' => $sql
    );

    echo json_encode($errorInfo);
    $con->rollback();
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>