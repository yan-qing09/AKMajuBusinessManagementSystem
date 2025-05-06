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

$famtype=$_POST['famtype'];
$famname=$_POST['famname'];
$famvariation=$_POST['famvariation'];
$famdimension=$_POST['famdimension'];
$famprice=$_POST['famprice'];
$famcost=$_POST['famcost'];
$famarkup=$_POST['famarkup'];
$famunit=$_POST['famunit'];
$famunsold=$_POST['famunsold'];
$famin=$_POST['famin'];
$famstatus='';
if($famunsold<$famin){
    $famstatus='Low';
}elseif($famunsold>=$famin){
    $famstatus='In Stock';
}
$sqlCount = "SELECT COUNT(*) AS total 
                FROM tb_advertisement_material";
$resultCount = mysqli_query($con, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$count = $rowCount['total'];
$count++;
$famid = 'AM' . str_pad($count, 4, '0', STR_PAD_LEFT);


$sql="INSERT INTO tb_advertisement_material(AM_id,AM_name,AM_variation,AM_dimension,AM_unit,AM_price,AM_cost,AM_markUp,AM_type,AM_lastMod,AM_totalQty,AM_unsoldQty,AM_soldQty,AM_sellingQty,LS_status,LS_qty,is_archived)
        VALUES('$famid','$famname','$famvariation','$famdimension','$famunit','$famprice','$famcost','$famarkup','$famtype', NOW(),'$famunsold','$famunsold',0,0,'$famstatus','$famin',0)";
$result = mysqli_query($con, $sql);

if (!$result) {
    $error_message = mysqli_error($con);
    echo "<script>alert('Error: $error_message');</script>";
    exit();
}
$sql_insert_history = "INSERT INTO tb_am_history (AM_id, AMH_date, AMH_cost, AMH_price, U_id)
                          VALUES ('$famid', NOW(), '$famcost', '$famprice', '$fid')";
    
$result_insert_history = mysqli_query($con, $sql_insert_history);

$sql_insert_adjustment = "INSERT INTO tb_advertisement_adjustment (AM_id, AMH_date, AMH_unsoldQty,U_id,AMH_soldQty,AMH_sellingQty)
                              VALUES ('$famid', NOW(), '$famunsold','$fid',0,0)";
    $result_insert_adjustment = mysqli_query($con, $sql_insert_adjustment);
    mysqli_close($con);
header("Location: admaterial.php?id=$fid");
?>
