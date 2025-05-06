<?php
session_start();

//Connect to DB
include('dbconnect.php');

//retrieve data from registration form
$fid=$_POST['fid'];
$fpwd=$_POST['fpwd'];

//CRUD Operations
//RETRIEVE-SQL retrieve statement
$sql="SELECT *FROM tb_user
	  	WHERE U_id='$fid'
	  	AND is_archived=0";

//echo var_dump($sql)
//Execute MySQL
$result=mysqli_query($con,$sql);

//Retrieve row/data
$row=mysqli_fetch_array($result);

//Redirect to corresponding page
$count=mysqli_num_rows($result); //count data
if(password_verify($fpwd, $row['U_pwd']))
{
	$updateQuery = "UPDATE tb_user SET U_lastLogin=NOW() WHERE U_id='$fid'";
mysqli_query($con, $updateQuery);
	$_SESSION['U_id']=session_id();
	$_SESSION['suid']=$fid;
	//User available
	if($row['U_type']=='Admin') //Admin
	{
		header('Location: adminDashboard.php?id='.$row['U_id']);
	}
	else if($row['U_type']=='Staff') //Staff
	{
		header('Location:staffDashboard.php?id='.$row['U_id']);
	}
}
else
{
	//User not available/exist
	//Add script to let user know either username or password wrong
	header('Location:index.php');
}

//close db connection
mysqli_close($con);

?>