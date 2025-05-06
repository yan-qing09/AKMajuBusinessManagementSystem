<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

// Retrieve form data
$newCustomerId = isset($_POST['Cid']) ? $_POST['Cid'] : '';
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
$Odate = $_POST['AOdate'];
$Oremark = $_POST['AOremark'];

// Start a transaction to ensure data consistency across tables
$con->autocommit(false);

if (isset($newCustomerId) && $newCustomerId !== '') {
    echo"Update Customer";

    // $newCustomerId is set, update the records
    // Update tb_customer table
    $sqlUpdateCustomer = "UPDATE tb_customer 
                         SET C_name = ?, C_type = ?, C_street = ?, C_city = ?, C_postcode = ?, C_state = ?, C_email = ?
                         WHERE C_id = ?";
    $stmtUpdateCustomer = $con->prepare($sqlUpdateCustomer);

    $stmtUpdateCustomer->bind_param("sissssss", $Cname, $Ctype, $Cstreet, $Ccity, $Cpostcode, $Cstate, $Cemail, $newCustomerId);
    $resultUpdateCustomer = $stmtUpdateCustomer->execute();

    if (!$resultUpdateCustomer) {
        echo "Error updating customer details: " . $stmtUpdateCustomer->error;
        $con->rollback();
        exit;
    }

    // Update tb_customer_phone table
    $sqlUpdateCustomerPhone = "UPDATE tb_customer_phone 
                              SET C_phone = ?
                              WHERE C_id = ?";
    $stmtUpdateCustomerPhone = $con->prepare($sqlUpdateCustomerPhone);

    $stmtUpdateCustomerPhone->bind_param("ss", $Cphone, $newCustomerId);
    $resultUpdateCustomerPhone = $stmtUpdateCustomerPhone->execute();

    if (!$resultUpdateCustomerPhone) {
        echo "Error updating customer phone details: " . $stmtUpdateCustomerPhone->error;
        $con->rollback();
        exit;
    }

    // Update tb_agency_government or tb_ag_phone based on customer type
    if ($Ctype == 2) {
        // Update tb_agency_government table
        $sqlUpdateGovernment = "UPDATE tb_agency_government 
                               SET AG_name = ?
                               WHERE C_id = ?";
        $stmtUpdateGovernment = $con->prepare($sqlUpdateGovernment);

        $stmtUpdateGovernment->bind_param("ss", $governmentName, $newCustomerId);
        $resultUpdateGovernment = $stmtUpdateGovernment->execute();

        if (!$resultUpdateGovernment) {
            echo "Error updating government details: " . $stmtUpdateGovernment->error;
            $con->rollback();
            exit;
        }

        // Update tb_ag_phone table
        $sqlUpdateGovernmentPhone = "UPDATE tb_ag_phone 
                                    SET AG_phone = ?
                                    WHERE C_id = ?";
        $stmtUpdateGovernmentPhone = $con->prepare($sqlUpdateGovernmentPhone);

        $stmtUpdateGovernmentPhone->bind_param("ss", $governmentPhone, $newCustomerId);
        $resultUpdateGovernmentPhone = $stmtUpdateGovernmentPhone->execute();

        if (!$resultUpdateGovernmentPhone) {
            echo "Error updating government phone details: " . $stmtUpdateGovernmentPhone->error;
            $con->rollback();
            exit;
        }
    } elseif ($Ctype == 3) {
        // Update tb_agency_government table
        $sqlUpdateAgency = "UPDATE tb_agency_government 
                           SET AG_name = ?
                           WHERE C_id = ?";
        $stmtUpdateAgency = $con->prepare($sqlUpdateAgency);

        $stmtUpdateAgency->bind_param("ss", $Aname, $newCustomerId);
        $resultUpdateAgency = $stmtUpdateAgency->execute();

        if (!$resultUpdateAgency) {
            echo "Error updating agency details: " . $stmtUpdateAgency->error;
            $con->rollback();
            exit;
        }

        // Update tb_ag_phone table
        $sqlUpdateAgencyPhone = "UPDATE tb_ag_phone 
                                SET AG_phone = ?
                                WHERE C_id = ?";
        $stmtUpdateAgencyPhone = $con->prepare($sqlUpdateAgencyPhone);

        $stmtUpdateAgencyPhone->bind_param("ss", $Aphone, $newCustomerId);
        $resultUpdateAgencyPhone = $stmtUpdateAgencyPhone->execute();

        if (!$resultUpdateAgencyPhone) {
            echo "Error updating agency phone details: " . $stmtUpdateAgencyPhone->error;
            $con->rollback();
            exit;
        }
    }
} else {
    echo"Insert Customer";

    // Fetch the latest customer ID from the database
    $queryLatestId = "SELECT MAX(CAST(SUBSTRING(C_id, 2) AS UNSIGNED)) AS max_id FROM tb_customer";
    $resultLatestId = $con->query($queryLatestId);

    $newNumericPart = 1;

    if ($resultLatestId && $resultLatestId->num_rows > 0) {
        $row = $resultLatestId->fetch_assoc();
        $newNumericPart = $row['max_id'] + 1;
    } else {
        echo "Failed to fetch max ID: " . $con->error; // Output the MySQL error
        $con->rollback();
        exit; // Exit the script after rolling back
    }

    $newCustomerId = 'C' . sprintf('%03d', $newNumericPart);

    // Insert into tb_customer table with the new ID
    $sqlCustomer = "INSERT INTO tb_customer (C_id, C_name, C_type, C_street, C_city, C_postcode, C_state, C_email)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtCustomer = $con->prepare($sqlCustomer);
    if (!$stmtCustomer) {
        echo "Error preparing statement: " . $con->error;
        $con->rollback();
        exit;
    }

    // Assuming C_type is an integer
    $stmtCustomer->bind_param("ssisssss", $newCustomerId, $Cname, $Ctype, $Cstreet, $Ccity, $Cpostcode, $Cstate, $Cemail);
    $resultCustomer = $stmtCustomer->execute();
    if (!$resultCustomer) {
        echo "Error executing statement: " . $stmtCustomer->error;
        $con->rollback();
        exit;
    }

    // Instead of using $stmtCustomer->insert_id, use the manually generated ID
    $customerId = $newCustomerId;

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
        $sqlCustomerPhone = "INSERT INTO tb_customer_phone (C_id, C_phone)
                            VALUES (?, ?)";
        $stmtCustomerPhone = $con->prepare($sqlCustomerPhone);

        // Ensure $customerPhone is set and not null
        $customerPhone = isset($_POST['Cphone']) ? $_POST['Cphone'] : ''; // Change 'Cphone' to the appropriate form field name

        $stmtCustomerPhone->bind_param("ss", $newCustomerId, $customerPhone); // Use newCustomerId here
        $stmtCustomerPhone->execute();
    } else {
        // Handle the case where $customerId is null
        echo "Failed to retrieve customer ID.";
        $con->rollback();
        exit;
    }

    // Insert into tb_government or tb_agency based on customer type
    if ($Ctype == 2) {
        // Insert into tb_government table
        $sqlGovernment = "INSERT INTO tb_agency_government (C_id, AG_name)
                          VALUES (?, ?)";
        $stmtGovernment = $con->prepare($sqlGovernment);
        $stmtGovernment->bind_param("ss", $customerId, $governmentName); // Assuming $customerId is the same as $G_id
        $stmtGovernment->execute();

        // Insert into tb_government_phone table
    $sqlGovernmentPhone = "INSERT INTO tb_ag_phone (C_id, AG_phone)
                          VALUES (?, ?)";
    $stmtGovernmentPhone = $con->prepare($sqlGovernmentPhone);

    // Ensure $governmentPhone is set and not null
    $governmentPhone = isset($_POST['governmentPhone']) ? $_POST['governmentPhone'] : ''; // Change 'governmentPhone' to the appropriate form field name

    $stmtGovernmentPhone->bind_param("ss", $newCustomerId, $governmentPhone); // Use newCustomerId here
    $stmtGovernmentPhone->execute();


    } elseif ($Ctype == 3) {
        // Insert into tb_government table
        $sqlAgency = "INSERT INTO tb_agency_government (C_id, AG_name)
                          VALUES (?, ?)";
        $stmtAgency = $con->prepare($sqlAgency);
        $stmtAgency->bind_param("ss", $customerId, $Aname); // Assuming $customerId is the same as $A_id
        $stmtAgency->execute();

        // Insert into tb_government_phone table
        $sqlAgencyPhone = "INSERT INTO tb_ag_phone (C_id, AG_phone)
                              VALUES (?, ?)";
        $stmtAgencyPhone = $con->prepare($sqlAgencyPhone);
        $stmtAgencyPhone->bind_param("ss", $customerId, $Aphone); // Assuming $customerId is the same as $A_id and $Aphone is retrieved from the form
        $stmtAgencyPhone->execute();

    }
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


// Fetch the latest order ID from the database
$queryLatestOrderId = "SELECT MAX(CAST(SUBSTRING(O_id, 3) AS UNSIGNED)) AS max_aoid FROM tb_advertisement_order";
$resultLatestOrderId = $con->query($queryLatestOrderId);

if ($resultLatestOrderId && $resultLatestOrderId->num_rows > 0) {
    $rowOrderId = $resultLatestOrderId->fetch_assoc();
    $maxNumericPart = $rowOrderId['max_aoid'];

    // Increment the numeric part and format it back into the desired format (e.g., AO002)
    $newNumericPartOrderId = $maxNumericPart + 1;
    $newOrderId = 'A' . sprintf('%04d', $newNumericPartOrderId);

} else {
    // If no previous order ID exists, start from AO001
    $newOrderId = 'A0001';
}

if (empty($newOrderId)) {
    // If newOrderId is empty, handle the error or set a default value
    echo "Error: New Order ID is empty or not generated.";
} else {
    echo $newCustomerId; // Ensure $newCustomerId is not null
}
// Insert into tb_advertisement_order without AO_discAmt (discount amount)
$sqlOrder = "INSERT INTO tb_advertisement_order (C_id, O_id, O_date, O_remark, O_TOP, O_status, O_totalCost, O_totalPrice, AO_deliveryStatus, AO_paymentStatus, AO_invoiceStatus, O_quotationStatus, AO_deposit, AO_payMethod)
             VALUES (?, ?, ?, ?, ?, 2, 0, 0, 0, 0, 0, 0, 0, 0)";
$stmtOrder = $con->prepare($sqlOrder);

// Check if the statement is prepared successfully
if (!$stmtOrder) {
    echo "Error preparing order statement: " . $con->error;
    $con->rollback(); // Rollback if preparation failed
    exit; // Terminate script
}

// Assuming variables have been retrieved or set earlier in your code
$stmtOrder->bind_param("ssssi", $newCustomerId, $newOrderId, $Odate, $Oremark, $AO_TOP);

// Check if binding parameters is successful
if (!$stmtOrder->bind_param("ssssi", $newCustomerId, $newOrderId, $Odate, $Oremark, $AO_TOP)) {
    echo "Error binding parameters: " . $stmtOrder->error;
    $stmtOrder->close(); // Close the statement to free up resources
    $con->rollback(); // Rollback if binding failed
    exit; // Terminate script
}

// Execute the statement
if ($stmtOrder->execute()) {
    // Successful execution
    $stmtOrder->close(); // Close the statement to free up resources
} else {
    // Handle the case where the execution failed
    echo "Error executing order statement: " . $stmtOrder->error;
    $stmtOrder->close(); // Close the statement to free up resources
    $con->rollback(); // Rollback if execution failed
    exit; // Terminate script
}

$o_id = $newOrderId;

$con->commit();

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

// ... Close other statements
$con->close();

$redirectURL = 'save_AOM2.php?id=' . $rows['U_id'] . '&o_id=' . $o_id;
header('Location: ' . $redirectURL);
exit();
?>