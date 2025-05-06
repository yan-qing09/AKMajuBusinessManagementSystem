<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}
if(isset($_GET['id'])) {
    $fid = $_GET["id"];
}
if(isset($_GET['mid'])) {
    $fcmid = $_GET["mid"];
}
if(isset($_GET['mtype'])) {
    $fcmtype = $_GET["mtype"];
}
if(isset($_GET['mvariation'])) {
    $fcmvariation = $_GET["mvariation"];
}
include ('dbconnect.php');
$fcmeditname=$_POST['fcmeditname'];
$fcmeditvariation=$_POST['fcmeditvariation'];
$fcmeditsub=$_POST['fcmeditsub'];
$fcmeditprice=$_POST['fcmeditprice'];
$fcmeditunit=$_POST['fcmeditunit'];

$sql="UPDATE tb_construction_material
      SET CM_name='$fcmeditname',
      CM_variation='$fcmeditvariation',
      CM_subtype='$fcmeditsub',
      CM_price='$fcmeditprice',
      CM_unit='$fcmeditunit',
      CM_lastMod=NOW()
      WHERE CM_id='$fcmid'
      AND CM_type='$fcmtype'
      AND CM_variation='$fcmvariation'";


mysqli_query($con, $sql);
mysqli_close($con);

header("Location: cmaterial.php?id=$fid");
?>
