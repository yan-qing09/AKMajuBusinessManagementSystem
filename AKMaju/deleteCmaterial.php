<?php 
include('mysession.php');
if(!session_id()) {
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
// CRUD: Delete
$sql = "UPDATE tb_construction_material
		SET is_archived=1
		WHERE CM_id='$fcmid'
      	AND CM_type='$fcmtype'
      	AND CM_variation='$fcmvariation'";
$result = mysqli_query($con, $sql);
mysqli_close($con);

echo "<script>
    var deletedID = '$fcmid';
    alert(deletedID + ' has been deleted');
    window.location.href = 'cmaterial.php?id=$fid';
</script>";

?>
