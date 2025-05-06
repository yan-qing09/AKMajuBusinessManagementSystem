<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['searchTerm'];

    // Query for Material Variation
    $queryVariation = "SELECT DISTINCT AM_variation FROM tb_advertisement_material WHERE AM_name LIKE '%" . $searchTerm . "%' AND is_archived = 0";
    $resultVariation = mysqli_query($con, $queryVariation);

    // Query for Material Dimension
    $queryDimension = "SELECT DISTINCT AM_dimension FROM tb_advertisement_material WHERE AM_name LIKE '%" . $searchTerm . "%' AND is_archived = 0";
    $resultDimension = mysqli_query($con, $queryDimension);

    // Query for Material Unit
    $queryUnit = "SELECT DISTINCT AM_unit FROM tb_advertisement_material WHERE AM_name LIKE '%" . $searchTerm . "%' AND is_archived = 0";
    $resultUnit = mysqli_query($con, $queryUnit);

    // Check if queries executed successfully
    if ($resultVariation && $resultDimension && $resultUnit) {
        // Collect the suggestions into arrays for each category
        $suggestions = [
            'variation' => [],
            'dimension' => [],
            'unit' => []
        ];

        // Fetch data for Material Variation
        while ($row = mysqli_fetch_assoc($resultVariation)) {
            $suggestions['variation'][] = $row['AM_variation'];
        }

        // Fetch data for Material Dimension
        while ($row = mysqli_fetch_assoc($resultDimension)) {
            $suggestions['dimension'][] = $row['AM_dimension'];
        }

        // Fetch data for Material Unit
        while ($row = mysqli_fetch_assoc($resultUnit)) {
            $suggestions['unit'][] = $row['AM_unit'];
        }

        // Return the fetched data as JSON
        header('Content-Type: application/json');
        echo json_encode($suggestions);
    } else {
        // Handle query error, if any
        echo json_encode(['variation' => [], 'dimension' => [], 'unit' => []]);
    }
} else {
    // If it's not a POST request, return an empty array or an error message
    echo json_encode(['variation' => [], 'dimension' => [], 'unit' => []]);
}
?>