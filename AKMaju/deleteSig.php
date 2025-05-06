<?php 
include('mysession.php');
include ('dbconnect.php');

if(isset($_GET['id'])) {
  $fid = $_GET["id"];
}
if(isset($_GET['sigid'])) {
  $sigid = $_GET["sigid"];
}


// CRUD: Delete
$sql = "UPDATE tb_signature
    SET S_status=0
    WHERE S_id='$sigid'";
$result = mysqli_query($con, $sql);
mysqli_close($con);
//Redirect
header("Location: signature.php?id=$fid");
?>