<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$mt = $_GET['mt'];
$mn = $_GET['mn'];

$query = "SELECT DISTINCT CM_variation, CM_unit FROM tb_construction_material WHERE CM_id = '$mn' AND CM_type = (SELECT CM_type FROM tb_cm_type WHERE T_desc = '$mt') AND is_archived = 0";

$result = mysqli_query($con, $query);

// Check if queries executed successfully
if ($result) {
    // Collect the suggestions into arrays for each category
    $suggestions = [
        'variation' => [],
        'unit' => []
    ];

    // Fetch data for Material Variation and Unit within a single loop
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions['variation'][] = $row['CM_variation'];
        $suggestions['unit'][] = $row['CM_unit'];
    }

    // Return the fetched data as JSON
    header('Content-Type: application/json');
    echo json_encode($suggestions);
}
?>