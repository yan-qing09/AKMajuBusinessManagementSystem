<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$ao_id = $_GET['ao_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_advertisement_order WHERE AO_id = '$ao_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

// Retrieve form data
$Cname = $_POST['Cname'];
$Ctype = $_POST['Ctype'];
$Cemail = $_POST['Cemail'];
$Cphone = $_POST['Cphone'];
$Cstreet = $_POST['Cstreet'];
$Ccity = $_POST['Ccity'];
$Cpostcode = $_POST['Cpostcode'];
$Cstate = $_POST['Cstate'];
$governmentName = $_POST['governmentName'];
$governmentPhone = $_POST['governmentPhone'];
$Aname = $_POST['Aname'];
$Aphone = $_POST['Aphone'];
$AOdate = $_POST['AOdate'];
$AOremark = $_POST['AOremark'];

// Start a transaction to ensure data consistency across tables
$con->autocommit(false);

$Cid = $row6['C_id'];

// Insert into tb_customer table with the new ID
$sqlCustomer = "UPDATE tb_customer 
                SET C_name = ?, 
                    C_type = ?, 
                    C_street = ?, 
                    C_city = ?, 
                    C_postcode = ?, 
                    C_state = ?, 
                    C_email = ?
                WHERE C_id = ?";
$stmtCustomer = $con->prepare($sqlCustomer);
if (!$stmtCustomer) {
    echo "Error preparing statement: " . $con->error;
    $con->rollback();
    exit;
}

// Assuming C_type is an integer
$stmtCustomer->bind_param("ssssisss", $Cname, $Ctype, $Cstreet, $Ccity, $Cpostcode, $Cstate, $Cemail, $Cid);
$resultCustomer = $stmtCustomer->execute();
if (!$resultCustomer) {
    echo "Error executing statement: " . $stmtCustomer->error;
    $con->rollback();
    exit;
}

// Instead of using $stmtCustomer->insert_id, use the manually generated ID
$customerId = $Cid;

$queryCheckCustomer = "SELECT C_id FROM tb_customer WHERE C_id = ?";
$stmtCheckCustomer = $con->prepare($queryCheckCustomer);
$stmtCheckCustomer->bind_param("s", $customerId);
$stmtCheckCustomer->execute();
$resultCheckCustomer = $stmtCheckCustomer->get_result();

if ($resultCheckCustomer->num_rows === 0) {
    echo "Error: Customer ID not found in tb_customer table.";
    $con->rollback();
    exit;
}

if ($customerId) {
    // Insert into tb_customer_phone table only if $customerId is not null
    $sqlCustomerPhone = "UPDATE tb_customer_phone 
                        SET C_phone = ?
                        WHERE C_id = ?";
    $stmtCustomerPhone = $con->prepare($sqlCustomerPhone);

    // Ensure $customerPhone is set and not null
    $customerPhone = isset($_POST['Cphone']) ? $_POST['Cphone'] : ''; // Change 'Cphone' to the appropriate form field name

    $stmtCustomerPhone->bind_param("ss", $customerPhone, $Cid); // Updated parameter order
    $stmtCustomerPhone->execute();
} else {
    // Handle the case where $customerId is null
    echo "Failed to retrieve customer ID.";
    $con->rollback();
    exit;
}

// Insert into tb_government or tb_agency based on customer type
if ($Ctype == 2) {
    // Update tb_government table
    $sqlGovernment = "UPDATE tb_government 
                      SET G_name = ?
                      WHERE G_id = ?";
    $stmtGovernment = $con->prepare($sqlGovernment);
    $stmtGovernment->bind_param("ss", $governmentName, $Cid); // Assuming $Cid is the ID for tb_government
    $stmtGovernment->execute();

    // Insert into tb_government_phone table
$sqlGovernmentPhone = "UPDATE tb_government_phone 
                       SET G_phone = ?
                       WHERE G_id = ?";
$stmtGovernmentPhone = $con->prepare($sqlGovernmentPhone);

// Ensure $governmentPhone is set and not null
$governmentPhone = isset($_POST['governmentPhone']) ? $_POST['governmentPhone'] : ''; // Change 'governmentPhone' to the appropriate form field name

$stmtGovernmentPhone->bind_param("ss", $governmentPhone, $Cid); // Use newCustomerId here
$stmtGovernmentPhone->execute();


} elseif ($Ctype == 3) {
    // Insert into tb_government table
    $sqlAgency = "UPDATE tb_agency
                  SET A_name = ?
                  WHERE A_id = ?";
    $stmtAgency = $con->prepare($sqlAgency);
    $stmtAgency->bind_param("ss", $Aname, $Cid); // Assuming $customerId is the same as $A_id
    $stmtAgency->execute();

    // Insert into tb_government_phone table
    $sqlAgencyPhone = "UPDATE tb_agency_phone 
                       SET A_phone = ?
                       WHERE A_id = ?";
    $stmtAgencyPhone = $con->prepare($sqlAgencyPhone);
    $stmtAgencyPhone->bind_param("ss", $Aphone, $Cid); // Assuming $customerId is the same as $A_id and $Aphone is retrieved from the form
    $stmtAgencyPhone->execute();

}

$TOP_name = $_POST['TOP']; // Assuming 'TOP' is the key for TOP_name in your form

// Prepare a query to fetch AO_TOP based on TOP_name
$queryFetchAOTOP = "SELECT TOP_id FROM tb_terms_of_payment WHERE TOP_name = ?";
$stmtFetchAOTOP = $con->prepare($queryFetchAOTOP);
$stmtFetchAOTOP->bind_param("s", $TOP_name);
$stmtFetchAOTOP->execute();
$resultFetchAOTOP = $stmtFetchAOTOP->get_result();

if ($resultFetchAOTOP && $resultFetchAOTOP->num_rows > 0) {
    // Fetch the AO_TOP value
    $row = $resultFetchAOTOP->fetch_assoc();
    $AO_TOP = $row['TOP_id'];

} else {
    // Handle the case where TOP_name doesn't exist or error in fetching
    echo "Error fetching AO_TOP based on TOP_name.";
}

// Update tb_advertisement_order without AO_discAmt (discount amount)
$sqlOrder = "UPDATE tb_advertisement_order 
             SET C_id = ?, 
                 AO_date = ?, 
                 AO_remark = ?, 
                 AO_TOP = ?, 
                 AO_status = 2 
             WHERE AO_id = ?";
$stmtOrder = $con->prepare($sqlOrder);

// Assuming variables have been retrieved or set earlier in your code
$stmtOrder->bind_param("sssis", $customerId, $AOdate, $AOremark, $AO_TOP, $ao_id);

if ($stmtOrder->execute()) {
    // Handle success after executing the update query
    // e.g., Redirect to a success page, display a success message, etc.
} else {
    // Handle the case where the execution failed
    echo "Error updating order.";
    $con->rollback(); // Rollback if the update failed
}

$Qstatus = $_POST['Qstatus'];
$Istatus = $_POST['Istatus'];
$Pstatus = $_POST['Pstatus'];
$Dstatus = $_POST['Dstatus'];

// Prepare and execute UPDATE queries for each status
$updateQueries = [
    "UPDATE tb_advertisement_order SET AO_quotationStatus = ? WHERE AO_id = ?",
    "UPDATE tb_advertisement_order SET AO_invoiceStatus = ? WHERE AO_id = ?",
    "UPDATE tb_advertisement_order SET AO_paymentStatus = ? WHERE AO_id = ?",
    "UPDATE tb_advertisement_order SET AO_deliveryStatus = ? WHERE AO_id = ?"
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
    $sqlcomplete = "UPDATE tb_advertisement_order SET AO_status = ? WHERE AO_id = ?";
    $stmtcomplete = $con->prepare($sqlcomplete);

    // Assuming $ao_id is available as a variable
    $ao_status_value = 1; // Assuming 1 is the value you want to set
    $stmtcomplete->bind_param("is", $ao_status_value, $ao_id);
    $stmtcomplete->execute();
    $stmtcomplete->close(); // Close the statement to free up resources
}

// Retrieve the values from the POST array
$deposit = $_POST['deposit'] ?? ''; // Deposit amount
$pmethod = $_POST['pmethod'] ?? ''; // Payment method
$pdate = $_POST['pdate'] ?? ''; // Payment date
$preference = $_POST['preference'] ?? ''; // Payment reference

// Now you can use these values in your PHP code, for example, to update a database

// For example, assuming you have a database connection established ($con), you might execute an SQL query to update a table:
$sql = "UPDATE tb_advertisement_order SET AO_deposit = ?, AO_payMethod = ?, AO_payDate = ?, AO_payRef = ? WHERE AO_id = ?"; // Modify this query according to your database schema


$stmt = $con->prepare($sql);
if ($stmt) {

    $stmt->bind_param("disss", $deposit, $pmethod, $pdate, $preference, $ao_id);
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

// Close prepared statements and connection
$stmtOrder->close();
// ... Close other statements
$con->close();

// Redirect to a specific URL
$redirectURL = 'EditAOrdermaterial.php?id=' . $rows['U_id'] . '&ao_id=' . $row6['AO_id'];
header('Location: ' . $redirectURL);
exit();
?>