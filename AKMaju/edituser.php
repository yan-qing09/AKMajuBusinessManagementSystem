<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}
include ('dbconnect.php');
$fid=$_GET['id'];
$feditid=$_GET['user'];
$feditname=$_POST['feditname'];
$feditposition=$_POST['feditposition'];
$feditemail=$_POST['feditemail'];
$feditsv=$_POST['feditsupervisor'];

$sql = "UPDATE tb_user
        SET  U_email='$feditemail', U_position='$feditposition', U_name='$feditname'
        WHERE U_id='$feditid'";

mysqli_query($con, $sql);
$sql_supervision = "UPDATE tb_supervision 
                        SET Admin_id='$feditsv'
                        WHERE U_id='$feditid'";
mysqli_query($con, $sql_supervision);
mysqli_close($con);

header("Location: manageuser.php?id={$fid}");
?>
