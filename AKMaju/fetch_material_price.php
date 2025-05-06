<?php
include('dbconnect.php');
include('mysession.php');

// Retrieve posted data from AJAX request
$data = json_decode(file_get_contents("php://input"), true);

// Extract values
$materialName = $data['Mname'];
$materialVariation = $data['Mvariation'];
$materialDimension = $data['Mdimension'];

// Query to fetch the material cost and price based on provided data
$query = "SELECT AM_cost, AM_price FROM tb_advertisement_material WHERE 
            AM_name = '$materialName' AND 
            AM_variation = '$materialVariation' AND 
            AM_dimension = '$materialDimension' LIMIT 1";

$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $materialCost = $row['AM_cost'];
    $materialPrice = $row['AM_price'];

    // Return the material cost and price separated by a comma
    echo $materialCost . ',' . $materialPrice;
} else {
    // Handle case where no results were found
    echo "No this material in database";
}
?>