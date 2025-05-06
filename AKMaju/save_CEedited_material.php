<?php
include('dbconnect.php'); 
include('mysession.php'); 

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the edited material details from the POST request
    $materialID = $_POST['materialID'];
    $materialType = $_POST['materialType'];
    $materialVariation = $_POST['materialVariation'];
    $Munit = $_POST['Munit'];
    $Mprice = $_POST['Mprice'];
    $Mquantity = $_POST['Mquantity'];
    $MdiscountPerc = $_POST['MdiscountPerc'];
    $MdiscountAmt = $_POST['MdiscountAmt'];
    $taxcode = $_POST['taxcode'];
    $taxamount = $_POST['taxamount'];
    $co_id = $_POST['co_id'];

    $COM_price = $Munit * $Mquantity * $Mprice * (1 - $MdiscountPerc / 100) + $taxamount;

    // Prepare the SQL statement with placeholders
    $sql = "UPDATE tb_co_material SET
            COM_unit = ?,
            COM_price = ?,
            COM_qty = ?,
            COM_discPct = ?,
            COM_discAmt = ?,
            COM_taxcode = ?,
            COM_taxAmt = ?
            WHERE CM_id = ? AND CM_variation = ? AND CM_type = ? AND O_id = ?";

    // Prepare the query
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters with the statement
    mysqli_stmt_bind_param($stmt, "ddiddsdssss", $Munit, $COM_price, $Mquantity, $MdiscountPerc, $MdiscountAmt, $taxcode, $taxamount, $materialID, $materialVariation, $materialType, $co_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        echo "Material details updated successfully";
    } else {
        echo "Error updating material details: " . mysqli_error($con);
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>