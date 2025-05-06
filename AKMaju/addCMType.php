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

$fcmtype=$_POST['fcmtypeid'];
$fcmtctgy=$_POST['fcmtctgy'];
$fcmtdesc=$_POST['fcmtdesc'];


$sql="INSERT INTO tb_cm_type(CM_type,CM_ctgy,T_desc)
        VALUES('$fcmtype','$fcmtctgy','$fcmtdesc')";
mysqli_query($con, $sql);
mysqli_close($con);

header("Location: cmaterial.php?id=$fid");
?>
