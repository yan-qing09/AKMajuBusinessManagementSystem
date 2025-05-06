<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$ao_id = $_GET['ao_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
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

// Print out the captured data
echo "Cname: $Cname<br>";
echo "Ctype: $Ctype<br>";
echo "Cemail: $Cemail<br>";
echo "Cphone: $Cphone<br>";
echo "Cstreet: $Cstreet<br>";
echo "Ccity: $Ccity<br>";
echo "Cpostcode: $Cpostcode<br>";
echo "Cstate: $Cstate<br>";
echo "Aname: $Aname<br>";
echo "Aphone: $Aphone<br>";

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

if ($Ctype == 2) {
    // Check if the record exists in tb_government
$queryCheckGovernment = "SELECT C_id FROM tb_agency_government WHERE C_id = ?";
$stmtCheckGovernment = $con->prepare($queryCheckGovernment);
$stmtCheckGovernment->bind_param("s", $Cid);
$stmtCheckGovernment->execute();
$resultCheckGovernment = $stmtCheckGovernment->get_result();

if ($resultCheckGovernment->num_rows > 0) {
    // Record exists, update the existing record
    $sqlGovernment = "UPDATE tb_agency_government 
                      SET AG_name = ?
                      WHERE C_id = ?";
    echo "SQL: $sqlGovernment<br>"; // Echo SQL statement
    echo "governmentName: $governmentName<br>";
    echo "customerId: $Cid<br>";
    $stmtGovernment = $con->prepare($sqlGovernment);
    $stmtGovernment->bind_param("ss", $governmentName, $Cid);

    if (!$stmtGovernment->execute()) {
        echo "Error updating tb_government: " . $stmtGovernment->error;
        $con->rollback();
        exit;
    }
} else {
    // Record doesn't exist, insert a new record
    $sqlInsertGovernment = "INSERT INTO tb_agency_government (C_id, AG_name) VALUES (?, ?)";
    echo "SQL: $sqlInsertGovernment<br>"; // Echo SQL statement
    echo "governmentName: $governmentName<br>";
    echo "customerId: $Cid<br>";
    $stmtInsertGovernment = $con->prepare($sqlInsertGovernment);
    $stmtInsertGovernment->bind_param("ss", $Cid, $governmentName);

    if (!$stmtInsertGovernment->execute()) {
        echo "Error inserting into tb_government: " . $stmtInsertGovernment->error;
        $con->rollback();
        exit;
    }
}

/// Check if the record exists in tb_government_phone
$queryCheckGovernmentPhone = "SELECT C_id FROM tb_ag_phone WHERE C_id = ?";
$stmtCheckGovernmentPhone = $con->prepare($queryCheckGovernmentPhone);
$stmtCheckGovernmentPhone->bind_param("s", $Cid);
$stmtCheckGovernmentPhone->execute();
$resultCheckGovernmentPhone = $stmtCheckGovernmentPhone->get_result();

if ($resultCheckGovernmentPhone->num_rows > 0) {
    // Record exists, update the existing record
    $sqlGovernmentPhone = "UPDATE tb_ag_phone 
                           SET AG_phone = ?
                           WHERE C_id = ?";
    echo "SQL: $sqlGovernmentPhone<br>"; // Echo SQL statement
    echo "governmentPhone: $governmentPhone<br>";
    echo "customerId: $Cid<br>";
    $stmtGovernmentPhone = $con->prepare($sqlGovernmentPhone);
    $stmtGovernmentPhone->bind_param("ss", $governmentPhone, $Cid);

    if (!$stmtGovernmentPhone->execute()) {
        echo "Error updating tb_government_phone: " . $stmtGovernmentPhone->error;
        $con->rollback();
        exit;
    }
} else {
    // Record doesn't exist, insert a new record
    $sqlInsertGovernmentPhone = "INSERT INTO tb_ag_phone (C_id, AG_phone) VALUES (?, ?)";
    echo "SQL: $sqlInsertGovernmentPhone<br>"; // Echo SQL statement
    echo "governmentPhone: $governmentPhone<br>";
    echo "customerId: $Cid<br>";
    $stmtInsertGovernmentPhone = $con->prepare($sqlInsertGovernmentPhone);
    $stmtInsertGovernmentPhone->bind_param("ss", $Cid, $governmentPhone);

    if (!$stmtInsertGovernmentPhone->execute()) {
        echo "Error inserting into tb_government_phone: " . $stmtInsertGovernmentPhone->error;
        $con->rollback();
        exit;
    }
}

} elseif ($Ctype == 3) {
    // Check if the record exists in tb_agency
$queryCheckAgency = "SELECT C_id FROM tb_agency_government WHERE C_id = ?";
$stmtCheckAgency = $con->prepare($queryCheckAgency);
$stmtCheckAgency->bind_param("s", $Cid);
$stmtCheckAgency->execute();
$resultCheckAgency = $stmtCheckAgency->get_result();

if ($resultCheckAgency->num_rows > 0) {
    // Record exists, update the existing record
    $sqlAgency = "UPDATE tb_agency_government
                  SET AG_name = ?
                  WHERE C_id = ?";
    echo "SQL: $sqlAgency<br>"; // Echo SQL statement
    echo "agencyName: $Aname<br>";
    echo "customerId: $Cid<br>";
    $stmtAgency = $con->prepare($sqlAgency);
    $stmtAgency->bind_param("ss", $Aname, $Cid);

    if (!$stmtAgency->execute()) {
        echo "Error updating tb_agency: " . $stmtAgency->error;
        $con->rollback();
        exit;
    }
} else {
    // Record doesn't exist, insert a new record
    $sqlInsertAgency = "INSERT INTO tb_agency_government (C_id, AG_name) VALUES (?, ?)";
    echo "SQL: $sqlInsertAgency<br>"; // Echo SQL statement
    echo "agencyName: $Aname<br>";
    echo "customerId: $Cid<br>";
    $stmtInsertAgency = $con->prepare($sqlInsertAgency);
    $stmtInsertAgency->bind_param("ss", $Cid, $Aname);

    if (!$stmtInsertAgency->execute()) {
        echo "Error inserting into tb_agency: " . $stmtInsertAgency->error;
        $con->rollback();
        exit;
    }
}

// Check if the record exists in tb_agency_phone
$queryCheckAgencyPhone = "SELECT C_id FROM tb_ag_phone WHERE C_id = ?";
$stmtCheckAgencyPhone = $con->prepare($queryCheckAgencyPhone);
$stmtCheckAgencyPhone->bind_param("s", $Cid);
$stmtCheckAgencyPhone->execute();
$resultCheckAgencyPhone = $stmtCheckAgencyPhone->get_result();

if ($resultCheckAgencyPhone->num_rows > 0) {
    // Record exists, update the existing record
    $sqlAgencyPhone = "UPDATE tb_ag_phone 
                       SET AG_phone = ?
                       WHERE C_id = ?";
    echo "SQL: $sqlAgencyPhone<br>"; // Echo SQL statement
    echo "agencyPhone: $Aphone<br>";
    echo "customerId: $Cid<br>";
    $stmtAgencyPhone = $con->prepare($sqlAgencyPhone);
    $stmtAgencyPhone->bind_param("ss", $Aphone, $Cid);

    if (!$stmtAgencyPhone->execute()) {
        echo "Error updating tb_agency_phone: " . $stmtAgencyPhone->error;
        $con->rollback();
        exit;
    }
} else {
    // Record doesn't exist, insert a new record
    $sqlInsertAgencyPhone = "INSERT INTO tb_ag_phone (C_id, AG_phone) VALUES (?, ?)";
    echo "SQL: $sqlInsertAgencyPhone<br>"; // Echo SQL statement
    echo "agencyPhone: $Aphone<br>";
    echo "customerId: $Cid<br>";
    $stmtInsertAgencyPhone = $con->prepare($sqlInsertAgencyPhone);
    $stmtInsertAgencyPhone->bind_param("ss", $Cid, $Aphone);

    if (!$stmtInsertAgencyPhone->execute()) {
        echo "Error inserting into tb_agency_phone: " . $stmtInsertAgencyPhone->error;
        $con->rollback();
        exit;
    }
}
}

$con->commit();

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

// ... Close other statements
$con->close();
$redirectURL = 'EditAOrder.php?id=' . $rows['U_id'] . '&o_id=' . $row6['O_id'];
header('Location: ' . $redirectURL);
exit();
?>