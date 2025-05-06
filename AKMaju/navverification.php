<?php
session_start();

//Connect to DB
include('dbconnect.php');

//retrieve data from registration form
$fid=$_GET['id'];

//CRUD Operations
//RETRIEVE-SQL retrieve statement
$sql="SELECT *FROM tb_user
	  	WHERE U_id='$fid'";

//echo var_dump($sql)
//Execute MySQL
$result=mysqli_query($con,$sql);

//Retrieve row/data
$row=mysqli_fetch_array($result);

//Redirect to corresponding page
$count=mysqli_num_rows($result); //count data
if($count==1)
{
	$_SESSION['U_id']=session_id();
	$_SESSION['suid']=$fid;
	//User available
	if($row['U_type']=='Admin') //Admin
	{
		header('Location:adminVerification.php?id='.$row['U_id']);
	}
	else if($row['U_type']=='Staff') //Staff
	{
		header('Location:staffVerification.php?id='.$row['U_id']);
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