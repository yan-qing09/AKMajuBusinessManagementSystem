<?php
// Include your database connection logic here
include('dbconnect.php');
include ('mysession.php');

if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];

    // Query to retrieve customer details based on the provided CID
    $query = $query = "SELECT c.C_id, c.C_name, c.C_type, c.C_email, cp.C_phone, c.C_street, c.C_city, c.C_postcode, c.C_state, a.AG_name, ag.AG_phone
          FROM tb_customer c
          LEFT JOIN tb_customer_phone cp ON c.C_id = cp.C_id
          LEFT JOIN tb_agency_government a ON c.C_id = a.C_id
          LEFT JOIN tb_ag_phone ag ON c.C_id = ag.C_id
          WHERE c.C_id = '$cid'";

    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $customerDetails = $result->fetch_assoc();

        // Send JSON response
        echo json_encode($customerDetails);
    } else {
        // Send empty JSON response if no data found
        echo json_encode(['error' => 'Query execution error: ' . $con->error]);
    }
} else {
    // Send empty JSON response if CID is not provided
    echo json_encode([]);
}

?>