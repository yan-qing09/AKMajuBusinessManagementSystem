<?php
include('dbconnect.php');
include('mysession.php');

// Retrieve posted data from AJAX request
$data = json_decode(file_get_contents("php://input"), true);

// Extract values
$materialName = $data['Mname'];
$materialVariation = $data['Mvariation'];
$materialType = $data['Mtype'];

// Query to fetch the material cost and price based on provided data
$query = "SELECT CM_price FROM tb_construction_material WHERE 
            CM_id = '$materialName' AND 
            CM_variation = '$materialVariation' AND 
            CM_type = (SELECT CM_type FROM tb_cm_type WHERE T_desc = '$materialType') LIMIT 1";

$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $materialPrice = $row['CM_price'];

    // Return the material cost and price separated by a comma
    echo $materialPrice;
} else {
    // Handle case where no results were found
    echo "No this material in database";
}
?>