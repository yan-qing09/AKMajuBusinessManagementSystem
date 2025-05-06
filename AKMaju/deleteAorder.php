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
		SET O_status=3
		WHERE O_id='$faoid'";
$result = mysqli_query($con, $sql);
mysqli_close($con);
//Redirect
header("Location: AOrder.php?id=$fid");
?>
