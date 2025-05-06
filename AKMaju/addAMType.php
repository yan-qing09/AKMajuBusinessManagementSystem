<?php
include('dbconnect.php'); // Include your database connection script
include ('mysession.php');
    $newTypeID=$_POST['fcmtypeid'];
    $newType = $_POST['fcmtdesc'];
    $fid = $_GET['id'];
    // Check if the type already exists
    $checkQuery = "SELECT * FROM tb_am_type WHERE AM_Type = '$newTypeID'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // If the type doesn't exist, insert it into the table
        $insertQuery = "INSERT INTO tb_am_type (AM_Type,T_Desc) VALUES ('$newTypeID','$newType')";
        $insertResult = mysqli_query($con, $insertQuery);}

 else {
    echo "<script>
var newID = '$newTypeID';
console.log('Alert triggered for ' + newID);
alert(newID + ' already exists');
window.location.href = 'admaterial.php?id=$fid';
</script>";
    }

mysqli_close($con);
header("Location: admaterial.php?id=$fid");
?>
