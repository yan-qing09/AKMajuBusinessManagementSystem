<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

// Check if the material_id is received
if (isset($_POST['material_id'])) {
    $materialID = $_POST['material_id'];
    $ao_id = $_POST['ao_id']; // Added a missing semicolon here

    // Prepare and execute a query to fetch material details based on the ID
    $sql = "SELECT * FROM tb_ao_material AS ao
            INNER JOIN tb_advertisement_material AS ad ON ao.AM_id = ad.AM_id
            INNER JOIN tb_am_type AS amt ON ad.AM_type = amt.AM_type
            WHERE ao.AM_id = ? AND ao.O_id = ?";
    
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $materialID, $ao_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $material = $result->fetch_assoc();

        // Return material details as JSON
        echo json_encode($material);
    } else {
        // Return an empty JSON object if no data found
        echo json_encode((object)array());
    }

    // Close the database connection and statements
    $stmt->close();
    $con->close();
} else {
    // Return an empty JSON object if material_id is not set
    echo json_encode((object)array());
}
?>