<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}
if(isset($_GET['id'])) {
    $fid = $_GET["id"];
}
include ('dbconnect.php');

//retrieve data from form and session
$fcmtype=$_POST['fcmtype'];
$fcmname=$_POST['fcmname'];
$fcmvariation=$_POST['fcmvariation'];
$fcmid=$_POST['fcmid'];
$fcmprice=$_POST['fcmprice'];
$fcmunit=$_POST['fcmunit'];
$fcmsub=$_POST['fcmsub'];

$sql="INSERT INTO tb_construction_material(CM_id,CM_name,CM_variation,CM_unit,CM_price,CM_type,CM_subtype,CM_lastMod)
        VALUES('$fcmid','$fcmname','$fcmvariation','$fcmunit','$fcmprice','$fcmtype','$fcmsub',NOW())";

mysqli_query($con, $sql);
mysqli_close($con);

header("Location: cmaterial.php?id=$fid");
?>
