<?php 
include('mysession.php');
if(!session_id()) {
	session_start();
}

if(isset($_GET['id'])) {
	$fid = $_GET["id"];
}
if(isset($_GET['user'])) {
	$fuid = $_GET["user"];
}
include ('dbconnect.php');
// CRUD: Delete
$sql = "UPDATE tb_user
	    SET is_archived=1
		WHERE U_id='$fuid'";
$result = mysqli_query($con, $sql);
mysqli_close($con);
//Redirect
echo "<script>
    var deletedID = '$fuid';
    alert(deletedID + ' has been deleted');
    window.location.href = 'manageuser.php?id=$fid';
</script>";

?>
