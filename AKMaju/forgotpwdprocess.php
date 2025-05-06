<?php
// connect to the database (include dbconnect.php)
include('dbconnect.php');
$text=" ";
if(isset($_POST['femail']) && (!empty($_POST['femail']))){
$femail = $_POST['femail'];
$femail = filter_var($femail, FILTER_SANITIZE_EMAIL);
$femail = filter_var($femail, FILTER_VALIDATE_EMAIL);
 if (!$femail) {
        $text="Invalid email address";
        echo "<script type='text/javascript'>alert('{$text}');</script>";
    } else {
        $sel_query = "SELECT * FROM tb_user WHERE U_email='".$femail."'";
        $results = mysqli_query($con, $sel_query);
        $row = mysqli_num_rows($results);
        
        if ($row == 0) {
           $text="Email address is not registered";
           echo "<script type='text/javascript'>alert('{$text}');</script>";
        }
        else{
            $text="Password reset link is sent!";
           echo "<script type='text/javascript'>alert('{$text}');</script>";
        }
    }
}
// Close database connection
mysqli_close($con);
?>