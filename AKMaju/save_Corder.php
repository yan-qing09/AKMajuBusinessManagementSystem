<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

// Retrieve form data
$Cid = isset($_POST['Cid']) ? $_POST['Cid'] : '';

// Output the value
echo "Customer Id: " . $Cid;
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
$COdate = $_POST['COdate'];
$COremark = $_POST['COremark'];

// Start a transaction to ensure data consistency across tables
$con->autocommit(false);

if (isset($newCustomerId) && $newCustomerId !== '') {

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

// Prepare a query to fetch CO_TOP based on TOP_name
$queryFetchCOTOP = "SELECT TOP_id FROM tb_terms_of_payment WHERE TOP_name = ?";
$stmtFetchCOTOP = $con->prepare($queryFetchCOTOP);
$stmtFetchCOTOP->bind_param("s", $TOP_name);
$stmtFetchCOTOP->execute();
$resultFetchCOTOP = $stmtFetchCOTOP->get_result();

if ($resultFetchCOTOP && $resultFetchCOTOP->num_rows > 0) {
    // Fetch the CO_TOP value
    $row = $resultFetchCOTOP->fetch_assoc();
    $CO_TOP = $row['TOP_id'];

} else {
    // Handle the case where TOP_name doesn't exist or error in fetching
    echo "Error fetching CO_TOP based on TOP_name.";
}


// Fetch the latest order ID from the database
$queryLatestOrderId = "SELECT MAX(CAST(SUBSTRING(O_id, 3) AS UNSIGNED)) AS max_coid FROM tb_construction_order";
$resultLatestOrderId = $con->query($queryLatestOrderId);

if ($resultLatestOrderId && $resultLatestOrderId->num_rows > 0) {
    $rowOrderId = $resultLatestOrderId->fetch_assoc();
    $maxNumericPart = $rowOrderId['max_coid'];

    // Increment the numeric part and format it back into the desired format (e.g., AO002)
    $newNumericPartOrderId = $maxNumericPart + 1;
    $newOrderId = 'C' . sprintf('%04d', $newNumericPartOrderId);

} else {
    // If no previous order ID exists, start from CO001
    $newOrderId = 'C0001';
}

$customerId = $newCustomerId;

if (empty($newOrderId)) {
    // If newOrderId is empty, handle the error or set a default value
    echo "Error: New Order ID is empty or not generated.";
} else {
    echo "Customer ID: " . $newCustomerId . "<br>";
echo "New Order ID: " . $newOrderId . "<br>";
echo "Order Date: " . $COdate . "<br>";
echo "Order Remark: " . $COremark . "<br>";
echo "Order TOP: " . $CO_TOP . "<br>";
    // Insert into tb_construction_order without CO_discAmt (discount amount)
    $sqlOrder = "INSERT INTO tb_construction_order (C_id, O_id, O_date, O_remark, O_TOP,  O_status, EK_addon, AK_addon, COE_totalCost, COA_totalCost, O_totalCost, CO_markup, O_totalPrice, O_quotationStatus)
                 VALUES (?, ?, ?, ?, ?, 2, 0, 0, 0, 0, 0, 0, 0, 0)";
    $stmtOrder = $con->prepare($sqlOrder);

    // Assuming variables have been retrieved or set earlier in your code
    $stmtOrder->bind_param("ssssi", $customerId, $newOrderId, $COdate, $COremark, $CO_TOP);
}

if ($stmtOrder->execute()) {
    
} else {
    // Handle the case where the execution failed
    echo "Error inserting order.";
    $con->rollback(); // Rollback if insertion failed
}

$EKnegeri = $_POST['EKnegeri'];
$EKdaerah = $_POST['EKdaerah'];
$EKkawasan = $_POST['EKkawasan'];
$EKtambahan = $_POST['EKtambahan'];

$sqlEKawasan = "INSERT INTO tb_order_zone (O_id, Z_state, Z_region, Z_distance, CM_ctgy)
               VALUES (?, ?, ?, ?, 1)
               ON DUPLICATE KEY UPDATE
               Z_state = VALUES(Z_state), Z_region = VALUES(Z_region), Z_distance = VALUES(Z_distance)";
$stmtEKawasan = $con->prepare($sqlEKawasan);
$stmtEKawasan->bind_param("ssss", $newOrderId, $EKnegeri, $EKdaerah, $EKkawasan);
$stmtEKawasan->execute();

if ($stmtEKawasan->error) {
    echo "Error inserting or updating tb_order_zone (CM_ctgy=1): " . $stmtEKawasan->error;
    $con->rollback();
}

$sqlEtambahan = "UPDATE tb_construction_order SET EK_addon = ? WHERE O_id = ?";
$stmtEtambahan = $con->prepare($sqlEtambahan);
$stmtEtambahan->bind_param("ss", $EKtambahan, $newOrderId);

$stmtEtambahan->execute();

if ($stmtEtambahan->error) {
    echo "Error inserting into tb_co_material: " . $stmtEtambahan->error;
    $con->rollback();
} 

$AKnegeri = $_POST['AKnegeri'];
$AKdaerah = $_POST['AKdaerah'];
$AKkawasan = $_POST['AKkawasan'];
$AKtambahan = $_POST['AKtambahan'];

$sqlAkawasan = "INSERT INTO tb_order_zone (O_id, Z_state, Z_region, Z_distance, CM_ctgy)
               VALUES (?, ?, ?, ?, 2)
               ON DUPLICATE KEY UPDATE
               Z_state = VALUES(Z_state), Z_region = VALUES(Z_region), Z_distance = VALUES(Z_distance)";
$stmtAkawasan = $con->prepare($sqlAkawasan);
$stmtAkawasan->bind_param("ssss", $newOrderId, $AKnegeri, $AKdaerah, $AKkawasan);
$stmtAkawasan->execute();

if ($stmtAkawasan->error) {
    echo "Error inserting or updating tb_order_zone (CM_ctgy=2): " . $stmtAkawasan->error;
    $con->rollback();
}

$sqlAtambahan = "UPDATE tb_construction_order SET AK_addon = ? WHERE O_id = ?";
$stmtAtambahan = $con->prepare($sqlAtambahan);
$stmtAtambahan->bind_param("ss", $AKtambahan, $newOrderId);

$stmtAtambahan->execute();

if ($stmtAtambahan->error) {
    echo "Error inserting into tb_co_material: " . $stmtAtambahan->error;
    $con->rollback();
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

$redirectURL = 'AddCEOrdermaterial.php?id=' . $rows['U_id'] . '&co_id=' . $newOrderId;
header('Location: ' . $redirectURL);
exit();
?>