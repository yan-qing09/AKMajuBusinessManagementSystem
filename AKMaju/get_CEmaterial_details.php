<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$materialID = $_POST['material_id'];
$materialType = $_POST['material_type'];
$materialVariation = $_POST['material_variation'];
$co_id = $_POST['co_id'];

$sql = "SELECT co.*, cd.*, cmt.* FROM tb_co_material AS co
         INNER JOIN tb_construction_material AS cd ON co.CM_variation = cd.CM_variation AND co.CM_id = cd.CM_id AND co.CM_type = cd.CM_type
         INNER JOIN tb_cm_type AS cmt ON co.CM_type = cmt.CM_type
         WHERE co.CM_id = ? AND co.CM_type = ? AND co.CM_variation = ? AND co.O_id = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("ssss", $materialID, $materialType, $materialVariation, $co_id);
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


?>

