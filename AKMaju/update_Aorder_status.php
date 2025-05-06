<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$ao_id = $_GET['ao_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$Qstatus = $_POST['Qstatus'];
$Istatus = $_POST['Istatus'];
$Pstatus = $_POST['Pstatus'];
$Dstatus = $_POST['Dstatus'];

// Prepare and execute UPDATE queries for each status
$updateQueries = [
    "UPDATE tb_advertisement_order SET O_quotationStatus = ? WHERE O_id = ?",
    "UPDATE tb_advertisement_order SET AO_invoiceStatus = ? WHERE O_id = ?",
    "UPDATE tb_advertisement_order SET AO_paymentStatus = ? WHERE O_id = ?",
    "UPDATE tb_advertisement_order SET AO_deliveryStatus = ? WHERE O_id = ?"
];

$statusValues = [$Qstatus, $Istatus, $Pstatus, $Dstatus];
$statusColumns = ['AO_quotationStatus', 'AO_invoiceStatus', 'AO_paymentStatus', 'AO_deliveryStatus'];

for ($i = 0; $i < count($updateQueries); $i++) {
    $stmt = $con->prepare($updateQueries[$i]);
    if ($stmt) {
        $stmt->bind_param("is", $statusValues[$i], $ao_id); // Assuming $ao_id is available
        $stmt->execute();
    } else {
        echo "Error preparing statement: " . $con->error;
        // Handle the error accordingly, such as rolling back transactions, logging, etc.
    }
}

if ($Dstatus == 10) {
    $sqlcomplete = "UPDATE tb_advertisement_order SET O_status = ? WHERE O_id = ?";
    $stmtcomplete = $con->prepare($sqlcomplete);

    // Assuming $ao_id is available as a variable
    $ao_status_value = 1; // Assuming 1 is the value you want to set
    $stmtcomplete->bind_param("is", $ao_status_value, $ao_id);
    $stmtcomplete->execute();
    $stmtcomplete->close(); // Close the statement to free up resources

    $sqlgetaom = "SELECT AM_id, AOM_qty, AOM_unit FROM tb_ao_material WHERE O_id = '$ao_id'";
    $resultgetaom = mysqli_query($con, $sqlgetaom);

    while($rowgetaom = mysqli_fetch_array($resultgetaom)) {
    $sqlcurrentm = "SELECT AM_sellingQty, AM_soldQty, AM_unsoldQty
                    FROM tb_advertisement_material 
                    WHERE AM_id = '$rowgetaom[AM_id]'";
    $resultcurrentm = mysqli_query($con, $sqlcurrentm);
    $rowcurrentm = mysqli_fetch_array($resultcurrentm);

    $AM_selling = $rowcurrentm['AM_sellingQty'] - ($rowgetaom['AOM_qty']*$rowgetaom['AOM_unit']);
    $AM_sold = $rowcurrentm['AM_soldQty'] + ($rowgetaom['AOM_qty']*$rowgetaom['AOM_unit']);
    $AM_totalQty = $rowcurrentm['AM_unsoldQty'] + $AM_selling;

    $sqlnewm = "UPDATE tb_advertisement_material SET AM_sellingQty = '$AM_selling', AM_soldQty = '$AM_sold', AM_totalQty = '$AM_totalQty' WHERE AM_id = '$rowgetaom[AM_id]'";
    $resultnewm = mysqli_query($con, $sqlnewm);

    $sqladjust1 = "INSERT INTO tb_advertisement_adjustment (U_id, AM_id, AMH_date, AMH_soldQty, AMH_sellingQty, AMH_unsoldQty)
               VALUES ('$fid', '{$rowgetaom['AM_id']}', NOW(), '$AM_sold', '$AM_selling', '{$rowcurrentm['AM_unsoldQty']}')";
    $resultadjust1 = mysqli_query($con, $sqladjust1);
    }

}

$existingQstatus = $row6['O_quotationStatus']; // Assuming this column exists in your table

if ($Qstatus == 4 && $Qstatus != $existingQstatus) {
    $sqlgetaom2 = "SELECT AM_id, AOM_qty, AOM_unit FROM tb_ao_material WHERE O_id = '$ao_id'";
    $resultgetaom2 = mysqli_query($con, $sqlgetaom2);

    while($rowgetaom2 = mysqli_fetch_array($resultgetaom2)) {
        $sqlcurrentm2 = "SELECT AM_sellingQty, AM_unsoldQty, AM_soldQty, LS_qty, LS_status
                        FROM tb_advertisement_material 
                        WHERE AM_id = '$rowgetaom2[AM_id]'";
        $resultcurrentm2 = mysqli_query($con, $sqlcurrentm2);
        $rowcurrentm2 = mysqli_fetch_array($resultcurrentm2);

        $AM_selling = $rowcurrentm2['AM_sellingQty'] + ($rowgetaom2['AOM_qty']*$rowgetaom2['AOM_unit']);
        $AM_unsold = $rowcurrentm2['AM_unsoldQty'] - ($rowgetaom2['AOM_qty']*$rowgetaom2['AOM_unit']);
        $AM_totalQty = $AM_unsold + $AM_selling;

        // Check if unsold is lower than LS_qty
        if ($AM_unsold < $rowcurrentm2['LS_qty']) {
            $LS_status = "LOW";
        } else {
            $LS_status = $rowcurrentm2['LS_status']; // Keep the existing status if unsold is not lower than LS_qty
        }

        $sqlnewm2 = "UPDATE tb_advertisement_material 
                     SET AM_sellingQty = '$AM_selling', AM_unsoldQty = '$AM_unsold', AM_totalQty = '$AM_totalQty', LS_status = '$LS_status'
                     WHERE AM_id = '$rowgetaom2[AM_id]'";
        $resultnewm2 = mysqli_query($con, $sqlnewm2);

        $sqladjust2 = "INSERT INTO tb_advertisement_adjustment (U_id, AM_id, AMH_date, AMH_soldQty, AMH_sellingQty, AMH_unsoldQty)
               VALUES ('$fid', '{$rowgetaom2['AM_id']}', NOW(), '{$rowcurrentm2['AM_soldQty']}', '$AM_selling', '$AM_unsold')";
        $resultadjust2 = mysqli_query($con, $sqladjust2);
    }
}

$con->commit();

// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'EditAOrder.php?id=' . $rows['U_id'] . '&o_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>