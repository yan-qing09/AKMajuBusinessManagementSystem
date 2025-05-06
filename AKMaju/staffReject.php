<?php
include('dbconnect.php');
include('mysession.php');


if(!session_id()) {
    session_start();
}

if(isset($_GET['id'])) {
    $fid = $_GET["id"];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $formId = $_POST['form_id'];
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];


        if ($action === 'rejectcheck') {
            $sqlMainTable = "UPDATE tb_invoice
                             SET I_status = '5'
                             WHERE I_id = '$formId'";

        } 

$mainTableResult = mysqli_query($con, $sqlMainTable);

}

mysqli_close($con);
//Redirect
header("Location: staffVerification.php?id=$fid");
?>