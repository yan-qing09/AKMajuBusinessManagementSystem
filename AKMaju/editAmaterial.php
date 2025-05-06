<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}
if(isset($_GET['id'])) {
    $fid = $_GET["id"];
}
if(isset($_GET['material'])) {
    $famid = $_GET["material"];
}
include ('dbconnect.php');
$query = "SELECT *FROM tb_advertisement_material WHERE AM_id='$famid'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$prevCost = $row['AM_cost'];
$prevPrice = $row['AM_price'];
$prevUnsold = $row['AM_unsoldQty'];
$prevSold = $row['AM_soldQty'];
$prevSelling = $row['AM_sellingQty'];
$fameditype=$_POST['fameditype'];
$fameditname=$_POST['fameditname'];
$fameditvariation=$_POST['fameditvariation'];
$fameditdimension=$_POST['fameditdimension'];
$fameditprice=$_POST['fameditprice'];
$fameditcost=$_POST['fameditcost'];
$fameditmarkup=$_POST['fameditmarkup'];
$fameditunit=$_POST['fameditunit'];
$fameditunsold=$_POST['fameditunsold'];
$fameditotal=$_POST['fameditotal'];
$fameditmin=$_POST['fameditmin'];
$fameditstatus=$_POST['fameditstatus'];

if ($fameditprice != $prevPrice || $fameditcost != $prevCost) {
    $sql_insert_history = "INSERT INTO tb_am_history (AM_id, AMH_date, AMH_cost, AMH_price, U_id)
                            VALUES ('$famid', NOW(), '$fameditcost', '$fameditprice', '$fid')";
    $result_insert_history = mysqli_query($con, $sql_insert_history);
}

if ($fameditunsold != $prevUnsold) {
    $sql_insert_adjustment = "INSERT INTO tb_advertisement_adjustment (AM_id, AMH_date, AMH_unsoldQty,U_id,AMH_soldQty,AMH_sellingQty)
                              VALUES ('$famid', NOW(), '$fameditunsold','$fid','$prevSold','$prevSelling ')";
    $result_insert_adjustment = mysqli_query($con, $sql_insert_adjustment);
}


$sql="UPDATE tb_advertisement_material
      SET AM_name='$fameditname',
      AM_variation='$fameditvariation',
      AM_dimension='$fameditdimension',
      AM_unit='$fameditunit',
      AM_price='$fameditprice',
      AM_cost='$fameditcost',
      AM_markUp='$fameditmarkup',
      AM_type='$fameditype',
      AM_lastMod=NOW(),
      AM_totalQty='$fameditotal',
      AM_unsoldQty='$fameditunsold',
      LS_status='$fameditstatus',
      LS_qty='$fameditmin'
      WHERE AM_id='$famid'";


mysqli_query($con, $sql);
mysqli_close($con);
header("Location: admaterial.php?id=$fid");
?>
