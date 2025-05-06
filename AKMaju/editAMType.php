<?php
include('mysession.php');
if (!session_id()) {
    session_start();
}

include('dbconnect.php');

$fid = $_GET['id'];
$editAmTypes = $_POST['editamtype'];
$editAmTDescs = $_POST['editamtdesc'];

// Loop through the submitted data
foreach ($editAmTypes as $index => $editAmType) {
    // Sanitize and prepare data (you should do proper validation and sanitization)
    $editAmType = mysqli_real_escape_string($con, $editAmType);
    $editAmTDesc = mysqli_real_escape_string($con, $editAmTDescs[$index]);

    // Update the tb_am_type table based on T_desc and AM_type
    $sqlUpdateAmType = "UPDATE tb_am_type
                        SET T_Desc = '$editAmTDesc'
                        WHERE AM_type = '$editAmType'";

    $resultUpdateAmType = mysqli_query($con, $sqlUpdateAmType);

    // Check for errors if needed
    if (!$resultUpdateAmType) {
        echo "<script>
    alert(' Error updating record');
    window.location.href = 'admaterial.php?id=$fid';
</script>";
    }
}

// Close the database connection
mysqli_close($con);

// Redirect or handle the situation when the form is not submitted via POST
header("Location: admaterial.php?id=$fid");
?>
