<?php
include ('dbconnect.php');
include ('mysession.php');

// Get the search term and material type description from the AJAX request
$searchTerm = mysqli_real_escape_string($con, $_POST['term']);
$materialTypeDesc = isset($_POST['materialType']) ? mysqli_real_escape_string($con, $_POST['materialType']) : '';

// Fetch the corresponding AM_type (integer) from tb_am_type using the provided T_Desc
$getTypeQuery = "SELECT AM_type FROM tb_am_type WHERE T_Desc = '$materialTypeDesc'";
$typeResult = mysqli_query($con, $getTypeQuery);

if ($typeResult) {
    $typeRow = mysqli_fetch_assoc($typeResult);

    if ($typeRow) {
        $materialType = $typeRow['AM_type'];

        // Perform a query to fetch suggestions
        $query = "SELECT DISTINCT AM_name 
                  FROM tb_advertisement_material 
                  WHERE AM_name LIKE '%" . $searchTerm . "%'
                  AND AM_type = '" . $materialType . "' AND is_archived = 0";

        $result = mysqli_query($con, $query);

        if ($result) {
            // Collect the suggestions into an array
            $suggestions = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $suggestions[] = $row['AM_name'];
            }

            // Return the suggestions as JSON
            echo json_encode($suggestions);
        } else {
            // Handle query execution error
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // Handle if no corresponding AM_type found for the provided T_Desc
        echo "Error: Material type not found";
    }
} else {
    // Handle SQL query error
    echo "Error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>