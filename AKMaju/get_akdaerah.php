<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

if (isset($_GET['mt'])) {
    $selectedDaerah = $_GET['mt'];

    // Perform SQL query to fetch Mid and Mname based on the selected Mtype
    // Replace 'your_table' with your actual table name
    $query = "SELECT DISTINCT Z_region
              FROM tb_zone
              WHERE Z_state = '$selectedDaerah' AND CM_ctgy = 2";

    $result = $con->query($query);

    $options = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $daerah = $row['Z_region']; // Correct variable names used here
            $options[] = array("value" => $daerah, "text" => "$daerah");
        }
    }
    
    echo json_encode($options);
} else {
    echo json_encode([]);
}
?>