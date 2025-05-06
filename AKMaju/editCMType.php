<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbconnect.php');
$fid = $_GET['id'];
$editCmTypes = $_POST['editcmtype'];
$editCmCtgys = $_POST['editcmctgy'];
$editCmTDescs = $_POST['editcmtdesc'];

// Loop through the submitted data
foreach ($editCmTypes as $index => $editCmType) {
    // Sanitize and prepare data (you should do proper validation and sanitization)
    $editCmType = mysqli_real_escape_string($con, $editCmType);
    $editCmCtgy = mysqli_real_escape_string($con, $editCmCtgys[$index]);
    $editCmTDesc = mysqli_real_escape_string($con, $editCmTDescs[$index]);

    // Update the tb_cm_type table based on T_desc
    $sqlUpdateCmType = "UPDATE tb_cm_type
                        SET T_desc = '$editCmTDesc'
                        WHERE CM_type = '$editCmType'
                        AND CM_ctgy='$editCmCtgy'";

    $resultUpdateCmType = mysqli_query($con, $sqlUpdateCmType);

    // Check for errors if needed
    if (!$resultUpdateCmType) {
        echo "Error updating record: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);

// Redirect or handle the situation when the form is not submitted via POST
header("Location: cmaterial.php?id=$fid");
?>
