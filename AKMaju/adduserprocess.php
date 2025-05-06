<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}

include ('dbconnect.php');

$fid = $_GET['id'];

//retrieve data from form and session
$fusertype=$_POST['fusertype'];
$fname=$_POST['fname'];
$fsupervisor=$_POST['fsupervisor'];
$fposition=$_POST['fposition'];
$femail=$_POST['femail'];
$sqlCheckEmail = "SELECT COUNT(*) AS email_count FROM tb_user WHERE U_email = '$femail'";
$resultCheckEmail = mysqli_query($con, $sqlCheckEmail);
$rowCheckEmail = mysqli_fetch_assoc($resultCheckEmail);
if ($rowCheckEmail['email_count'] > 0) {
    echo "<script>
    var email = '$femail';
    alert(email + ' has been registered');
    window.location.href = 'manageuser.php?id=$fid';
</script>";
} else {
    $sqlCount = "SELECT COUNT(*) AS total 
                FROM tb_user";
    $resultCount = mysqli_query($con, $sqlCount);
    $rowCount = mysqli_fetch_assoc($resultCount);
    $count = $rowCount['total'];
    $count++;
    $fid2 = 'S' . str_pad($count, 2, '0', STR_PAD_LEFT);

$fpwd=password_hash('abc1234', PASSWORD_DEFAULT);

$sql="INSERT INTO tb_user(U_id,U_type,U_pwd,U_name,U_email,U_lastLogin,U_position,is_archived)
        VALUES('$fid2','$fusertype','$fpwd','$fname','$femail', NULL,'$fposition',0)";
mysqli_query($con, $sql);
if ($fusertype == 'Staff'){
$sql_supervision = "INSERT INTO tb_supervision (U_id, Admin_id)
                          VALUES ('$fid2', '$fsupervisor')";
}elseif($fusertype == 'Admin'){
    $sql_supervision = "INSERT INTO tb_supervision (U_id, Admin_id)
                          VALUES ('$fid2', NULL)";
}
$result_supervision = mysqli_query($con, $sql_supervision);

mysqli_close($con);

header("Location: manageuser.php?id=$fid");
}
?>
