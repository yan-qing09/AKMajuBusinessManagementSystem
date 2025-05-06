<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

if (isset($_GET['mt'])) {
    $selectedMtype = $_GET['mt'];

    // Perform SQL query to fetch Mid and Mname based on the selected Mtype
    // Replace 'your_table' with your actual table name
    $query = "SELECT DISTINCT CM_id, CM_name
              FROM tb_construction_material 
              WHERE CM_type = (SELECT CM_type FROM tb_cm_type WHERE T_desc = '$selectedMtype') AND is_archived = 0";

    $result = $con->query($query);

    $options = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mid = $row['CM_id']; // Correct variable names used here
            $mname = $row['CM_name']; // Correct variable names used here
            $options[] = array("value" => $mid, "text" => "$mid - $mname");
        }
    }
    
    echo json_encode($options);
} else {
    echo json_encode([]);
}
?>