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
    $formType = $_POST['form_type'];
    $formId = $_POST['form_id'];
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];


    switch ($formType) {
    case 'AQ':
        if ($action === 'rejectAQ') {
            $sqlMainTable = "UPDATE tb_advertisement_quotation
                             SET AQ_status = '5'
                             WHERE AQ_id = '$formId'";
        }
        break;

    case 'I':
        if ($action === 'rejectcheck') {
            $sqlMainTable = "UPDATE tb_invoice
                             SET I_status = '5'
                             WHERE I_id = '$formId'";

        } elseif ($action === 'rejectI') {
            $sqlMainTable = "UPDATE tb_invoice
                             SET I_status = '5'
                             WHERE I_id = '$formId'";

        }
        break;

    case 'CQ':
        if ($action === 'rejectCQ') {
            $sqlMainTable = "UPDATE tb_construction_quotation
                             SET CQ_status = '5'
                             WHERE CQ_id = '$formId'";
        }
        break;

    case 'DO':
        if ($action === 'rejectDO') {
            $sqlMainTable = "UPDATE tb_delivery_order
                             SET DO_status = '5'
                             WHERE DO_id = '$formId'";
        }
        break;
}

$mainTableResult = mysqli_query($con, $sqlMainTable);

}

mysqli_close($con);
//Redirect
header("Location: adminVerification.php?id=$fid");
?>