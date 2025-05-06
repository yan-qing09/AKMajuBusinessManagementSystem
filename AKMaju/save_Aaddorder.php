<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$fid = $_POST['id']; // Capture the orderid from the URL
$ao_id = $_POST['o_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$Mtype = $_POST['Mtype'];
$Mname = $_POST['Mname'];
$Mvariation = $_POST['Mvariation'];
$Mdimension = $_POST['Mdimension'];
$Mcost = $_POST['Mcost'];
$Mprice = $_POST['Mprice'];
$Munit = $_POST['Munit'];
$Mquantity = $_POST['Mquantity'];
$taxcode = $_POST['taxcode'];
$taxamount = $_POST['taxamount'];

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

// Insert this material data into the database using prepared statements
// Fetch the AM_id from tb_advertisement_material based on material details
$sqlFetchAMId = "SELECT am.AM_id 
         FROM tb_advertisement_material am
         INNER JOIN tb_am_type at ON am.AM_type = at.AM_type 
         WHERE at.T_Desc = ? 
         AND am.AM_dimension = ? 
         AND am.AM_variation = ? 
         AND am.AM_name = ?";
$stmtFetchAMId = $con->prepare($sqlFetchAMId);
$stmtFetchAMId->bind_param("ssss", $Mtype, $Mdimension, $Mvariation, $Mname);
$stmtFetchAMId->execute();
$resultAMId = $stmtFetchAMId->get_result();

if ($resultAMId && $resultAMId->num_rows > 0) {
    // Get the AM_id from the fetched row
    $row = $resultAMId->fetch_assoc();
    $AM_id = $row['AM_id'];

    // Calculate total cost and price for the material
    $AOM_cost = $Munit * $Mquantity * $Mcost;
    $AOM_price = $Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount;

    // Update the database with calculated costs and prices
    $sqlAOmaterial = "INSERT INTO tb_ao_material (AM_id, AOM_qty, AOM_unit, AOM_origincost, AOM_adjustprice, AOM_discPct, AOM_discAmt, AOM_taxcode, AOM_taxAmt, O_id, AOM_totalcost, AOM_totalprice)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtAOmaterial = $con->prepare($sqlAOmaterial);
    $stmtAOmaterial->bind_param("sisddddsdsdd", $AM_id, $Mquantity, $Munit, $Mcost, $Mprice, $MdiscountPerc, $MdiscountAmt, $taxcode, $taxamount, $ao_id, $AOM_cost, $AOM_price);
    $stmtAOmaterial->execute();

    if ($stmtAOmaterial->error) {
        echo "Error inserting into tb_ao_material: " . $stmtAOmaterial->error;
        $con->rollback();
    } 
} else {
    // Notify the user about the missing material details or handle the error accordingly
    echo "The selected material details are not available. Please choose a different material.";

    // Troubleshooting: Print any error messages related to the query
        echo "Error message: " . $con->error;
        echo "SQL query: " . $sqlFetchAMId; // This will print the actual query being executed

    // Rollback the transaction or handle the error as per your application's requirement
    $con->rollback();
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

$con->commit();

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'save_AOM2.php?id=' . $fid . '&o_id=' . $ao_id;
header('Location: ' . $redirectURL);
exit();
?>

