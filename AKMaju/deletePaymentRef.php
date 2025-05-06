<?php 
include('mysession.php');
if (!session_id()) {
	session_start();
}

if (isset($_GET['id'])) {
	$fid = $_GET["id"];
}

if (isset($_GET['pid'])) {
	$pid = $_GET["pid"];
}

$oid = $_GET['oid']; // Corrected variable name

include('dbconnect.php');
// CRUD: Delete
$sql = "UPDATE tb_payment_ref
		SET P_status = 1
		WHERE P_id = '$pid' AND O_id = '$oid'";
$result = mysqli_query($con, $sql);
mysqli_close($con);
// Redirect
header("Location: EditAOrder.php?id=" . $fid . "&o_id=" . $oid);
?>