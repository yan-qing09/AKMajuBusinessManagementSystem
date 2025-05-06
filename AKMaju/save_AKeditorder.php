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

$Mtype = $_GET['Mtype'];
$Mid = $_GET['Mname'];
$Mvariation = $_GET['Mvariation'];
$Munit = $_GET['Munit'];
$Mquantity = $_GET['Mquantity'];
$taxcode = $_GET['taxcode'];
$taxamount = $_GET['taxamount'];

// Query to fetch the material cost and price based on provided data
$queryprice = "SELECT CM_price FROM tb_construction_material WHERE 
            CM_id = '$Mid' AND 
            CM_variation = '$Mvariation' AND 
            CM_type = (SELECT CM_type FROM tb_cm_type WHERE T_desc = '$Mtype') LIMIT 1";

$resultprice = mysqli_query($con, $queryprice);

if ($resultprice && mysqli_num_rows($resultprice) > 0) {
    $rowprice = mysqli_fetch_assoc($resultprice);
    $Mprice = $rowprice['CM_price'];

} else {
    // Handle case where no results were found
    echo "No this material in database";
}

if (empty($_GET['MdiscountAmt'])&&empty($_GET['MdiscountPerc'])) {
    // Calculate discount amount if discount percentage is provided
    $MdiscountPerc = 0;
    $MdiscountAmt = 0;
} elseif (empty($_GET['MdiscountAmt'])) {
    // Calculate discount amount if discount percentage is provided
    $MdiscountPerc = $_GET['MdiscountPerc'];
    $MdiscountAmt = ($MdiscountPerc / 100) * ($Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount);
} elseif (empty($_GET['MdiscountPerc'])) {
    // Calculate discount percentage if discount amount is provided
    $MdiscountAmt = $_GET['MdiscountAmt'];
    $MdiscountPerc = (($MdiscountAmt / ($Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount)) * 100);
} else {
    // Both discount percentage and discount amount are provided
    $MdiscountPerc = $_GET['MdiscountPerc'];
    $MdiscountAmt = $_GET['MdiscountAmt'];
}

$querytype = "SELECT CM_type FROM tb_cm_type WHERE T_desc = '$Mtype'";
$resulttype = mysqli_query($con, $querytype);
if (!$resulttype) {
    die("Error in query: " . mysqli_error($con));
}
$rowtype = mysqli_fetch_assoc($resulttype);
$CM_type = $rowtype['CM_type'];

$COM_price = $Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount;

// Update the database with calculated costs and prices
$sqlCOmaterial = "INSERT INTO tb_co_material (CM_id, CM_variation, CM_type, COM_qty, COM_unit, COM_price, COM_discPct, COM_discAmt, COM_taxcode, COM_taxAmt, O_id)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtCOmaterial = $con->prepare($sqlCOmaterial);
$stmtCOmaterial->bind_param("sssiddddsds", $Mid, $Mvariation, $CM_type, $Mquantity, $Munit,$COM_price, $MdiscountPerc, $MdiscountAmt, $taxcode, $taxamount, $co_id);
$stmtCOmaterial->execute();

if ($stmtCOmaterial->error) {
    echo "Error inserting into tb_co_material: " . $stmtCOmaterial->error;
    $con->rollback();
} 


// Compute the total cost and total price from tb_ao_material
$sqlCalculateTotals = "SELECT SUM(COM_price) AS totalPrice FROM tb_co_material WHERE O_id = ?";
$stmtCalculateTotals = $con->prepare($sqlCalculateTotals);
$stmtCalculateTotals->bind_param("s", $co_id);
$stmtCalculateTotals->execute();
$resultTotals = $stmtCalculateTotals->get_result();

if ($resultTotals && $resultTotals->num_rows > 0) {
    $rowTotals = $resultTotals->fetch_assoc();
    $totalPrice = $rowTotals['totalPrice'];

    // Update tb_advertisement_order with totalCost and totalPrice
    $sqlUpdateOrder = "UPDATE tb_construction_order SET O_totalPrice = ? WHERE O_id = ?";
    $stmtUpdateOrder = $con->prepare($sqlUpdateOrder);
    $stmtUpdateOrder->bind_param("ds", $totalPrice, $co_id);
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
$redirectURL = 'EditKAOrdermaterial.php?id=' . $rows['U_id'] . '&co_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>

