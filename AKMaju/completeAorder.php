<?php 
include('mysession.php');
if(!session_id()) {
	session_start();
}

if(isset($_GET['id'])) {
	$fid = $_GET["id"];
}
if(isset($_GET['o_id'])) {
	$faoid = $_GET["o_id"];
}
include ('dbconnect.php');
// CRUD: Delete
$sql = "UPDATE tb_advertisement_order
		SET O_status=1
		WHERE O_id='$faoid'";
$result = mysqli_query($con, $sql);

$sqlgetaom = "SELECT AM_id, AOM_qty, AOM_unit FROM tb_ao_material WHERE O_id = '$faoid'";
$resultgetaom = mysqli_query($con, $sqlgetaom);

while($rowgetaom = mysqli_fetch_array($resultgetaom)) {
	$sqlcurrentm = "SELECT AM_sellingQty, AM_soldQty, AM_unsoldQty
					FROM tb_advertisement_material 
					WHERE AM_id = '$rowgetaom[AM_id]'";
	$resultcurrentm = mysqli_query($con, $sqlcurrentm);
	$rowcurrentm = mysqli_fetch_array($resultcurrentm);

	$AM_selling = $rowcurrentm['AM_sellingQty'] - ($rowgetaom['AOM_qty']*$rowgetaom['AOM_unit']);
	$AM_sold = $rowcurrentm['AM_soldQty'] + ($rowgetaom['AOM_qty']*$rowgetaom['AOM_unit']);
	$AM_totalQty = $rowcurrentm['AM_unsoldQty'] + $AM_selling;

	$sqlnewm = "UPDATE tb_advertisement_material SET AM_sellingQty = '$AM_selling', AM_soldQty = '$AM_sold', AM_totalQty = '$AM_totalQty' WHERE AM_id = '$rowgetaom[AM_id]'";
	$resultnewm = mysqli_query($con, $sqlnewm);

	$sqladjust1 = "INSERT INTO tb_advertisement_adjustment (U_id, AM_id, AMH_date, AMH_soldQty, AMH_sellingQty, AMH_unsoldQty)
               VALUES ('$fid', '{$rowgetaom['AM_id']}', NOW(), '$AM_sold', '$AM_selling', '{$rowcurrentm['AM_unsoldQty']}')";
    $resultadjust1 = mysqli_query($con, $sqladjust1);
}


mysqli_close($con);
//Redirect
header("Location: AOrder.php?id=$fid");
?>
