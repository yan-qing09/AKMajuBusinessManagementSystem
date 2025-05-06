<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}
include ('dbconnect.php');

//retrieve data from form and session
$fcmtype=$_POST['fcmtype'];
$fcmname=$_POST['fcmname'];
$fcmvariation=$_POST['fcmvariation'];
$fcmdimension=$_POST['fcmdimension'];
$fcmprice=$_POST['fcmprice'];
$fcmcost=$_POST['fcmcost'];
$fcmarkup=($fmcprice/$fcmcost-1)*100%;

$sqlCount = "SELECT COUNT(*) AS total 
                FROM tb_construction_material";
$resultCount = mysqli_query($con, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$count = $rowCount['total'];
$count++;
$fcmid = 'C' . str_pad($count, 3, '0', STR_PAD_LEFT);

$sql="INSERT INTO tb_construction_material(CM_id,CM_name,CM_variation,CM_dimension,CM_price,CM_cost,CM_markUp,CM_lastMod,CM_type)
        VALUES('$fcmid','$fcmname','$fcmvariation','$fcmdimension','$fcmprice','$fcmcost','$fcmarkup', NOW(),'$fcmtype')";

mysqli_query($con, $sql);
mysqli_close($con);

header("Location: admaterial.php?id=$fid");
?>
