<?php 
include('mysession.php');
if(!session_id()) {
	session_start();
}

if(isset($_GET['id'])) {
	$fid = $_GET["id"];
}
if(isset($_GET['material'])) {
	$famid = $_GET["material"];
}
include ('dbconnect.php');
// CRUD: Delete
$sql = "UPDATE tb_advertisement_material
		SET is_archived=1
		WHERE AM_id='$famid'";
$result = mysqli_query($con, $sql);
mysqli_close($con);
//Redirect
echo "<script>
    var deletedID = '$famid';
    alert(deletedID + ' has been deleted');
    window.location.href = 'admaterial.php?id=$fid';
</script>";
?>
