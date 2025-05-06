<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}
include ('dbconnect.php');

$fid=$_POST['fuid'];
$feditname=$_POST['feditname'];
$feditposition=$_POST['feditposition'];
$feditemail=$_POST['feditemail'];


$sql = "UPDATE tb_user
        SET U_email='$feditemail', U_position='$feditposition', U_name='$feditname'
        WHERE U_id='$fid'";

mysqli_query($con, $sql);
mysqli_close($con);

include 'manageuser.php';
?>