<?php
include('dbconnect.php');

if(isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];

    // Fetch types based on the selected category
    $sql = "SELECT CM_type, T_desc FROM tb_cm_type WHERE CM_ctgy = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();

    $result = $stmt->get_result();
    $types = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($types);
}
?>
