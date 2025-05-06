<?php
include('dbconnect.php');
include('mysession.php');
use setasign\Fpdi;
use setasign\tcpdf;
require_once 'vendor/autoload.php';
include_once('tcpdf_6_2_13/tcpdf.php');


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
        if ($action === 'approve') {
            $sqlMainTable = "INSERT INTO tb_aq_generation (AQ_id, U_id, D_progress)
                             VALUES ('$formId', '$fid', '3')";

            $sqlAdditionalTable = "UPDATE tb_advertisement_quotation
                                   SET AQ_status = '9'
                                   WHERE AQ_id = '$formId'";

        }
        break;

    case 'I':
        if ($action === 'approve') {
            $sqlMainTable = "INSERT INTO tb_invoice_generation (I_id, U_id, D_progress)
                             VALUES ('$formId', '$fid', '3')";

            $sqlAdditionalTable = "UPDATE tb_invoice
                                   SET I_status = '13'
                                   WHERE I_id = '$formId'";


        } elseif ($action === 'check') {

            $sqlMainTable = "INSERT INTO tb_invoice_generation (I_id, U_id, D_progress)
                             VALUES ('$formId', '$fid', '2')";

            $sqlAdditionalTable = "UPDATE tb_invoice
                                   SET I_status = '11'
                                   WHERE I_id = '$formId'";

        }
        break;

    case 'CQ':
        if ($action === 'approve') {
            $sqlMainTable = "INSERT INTO tb_cq_generation (CQ_id, U_id, D_progress)
                             VALUES ('$formId', '$fid', '3')";

            $sqlAdditionalTable = "UPDATE tb_construction_quotation
                                   SET CQ_status = '9'
                                   WHERE CQ_id = '$formId'";

        }
        break;

    case 'DO':
        if ($action === 'approve') {
            $sqlMainTable = "INSERT INTO tb_do_generation (DO_id, U_id, D_progress)
                             VALUES ('$formId', '$fid', '3')";

            $sqlAdditionalTable = "UPDATE tb_delivery_order
                                   SET DO_status = '9'
                                   WHERE DO_id = '$formId'";
        }
        break;
}

$mainTableResult = mysqli_query($con, $sqlMainTable);
$additionalTableResult = mysqli_query($con, $sqlAdditionalTable);


switch ($formType) {
     case 'AQ':
        if ($action === 'approve') {
        $query = "SELECT tb_advertisement_quotation.AQ_id, AQ_path, U_id
                  FROM tb_advertisement_quotation
                  LEFT JOIN tb_aq_generation ON tb_advertisement_quotation.AQ_id = tb_aq_generation.AQ_id 
                  WHERE tb_advertisement_quotation.AQ_id = '$formId' AND tb_aq_generation.D_progress = '3'";

        $result = mysqli_query($con, $query);
        $document = mysqli_fetch_assoc($result);

        $pdfPath = $document['AQ_path'];

        $absoluteFilePath = '/home11/akmajuco/public_html/AKMaju/';

        $pdfpath = $absoluteFilePath . $pdfPath;

        $U_AApproveid = $document['U_id'];

        $query2 = "SELECT S_path 
                   FROM tb_signature 
                   WHERE U_id = $U_AApproveid AND S_status = '1'";

        $result2 = mysqli_query($con, $query2);
        $document2 = mysqli_fetch_assoc($result2);

        $signaturePath = $document2['S_path'];

        $sigpath = $absoluteFilePath . $signaturePath;

        $pdf = new Fpdi\TcpdfFpdi();

        if (file_exists($pdfpath)) {
            $pagecount = $pdf->setSourceFile($pdfpath);
        } else {
            die('Source PDF not found!');
        }

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);


        $signatureWidth = 40; // Adjust this value based on your requirements
        $signatureHeight = 15; // Adjust this value based on your requirements

        // Add watermark image to the last page of the existing PDF
        for ($i = 1; $i <= $pagecount; $i++) {
            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);

            $pdf->AddPage(); // Always add a new page

            if ($i === $pagecount) {
                // Only on the last iteration, set the current page and add the image
                $pdf->setPage($i);
                $xxx_final = ($size['width'] - 50);
                $yyy_final = ($size['height'] - 40);
                $pdf->Image($sigpath, $xxx_final, $yyy_final, $signatureWidth, $signatureHeight, 'png');
            }

            $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], false);
        }

        ob_end_clean();
        // Output PDF with watermark
        $pdf->Output($pdfpath, 'F');

        break;
    }

    case 'CQ':
        if ($action === 'approve') {
        $query = "SELECT tb_construction_quotation.CQ_id, CQ_path, U_id
                  FROM tb_construction_quotation
                  LEFT JOIN tb_cq_generation ON tb_construction_quotation.CQ_id = tb_cq_generation.CQ_id 
                  WHERE tb_construction_quotation.CQ_id = '$formId' AND tb_cq_generation.D_progress = '3'";

        $result = mysqli_query($con, $query);
        $document = mysqli_fetch_assoc($result);

        $pdfPath = $document['CQ_path'];

        $absoluteFilePath = '/home11/akmajuco/public_html/AKMaju/';

        $pdfpath = $absoluteFilePath . $pdfPath;

        $U_CApproveid = $document['U_id'];

        $query2 = "SELECT S_path 
                   FROM tb_signature 
                   WHERE U_id = $U_CApproveid AND S_status = '1'";

        $result2 = mysqli_query($con, $query2);
        $document2 = mysqli_fetch_assoc($result2);

        $sigPath = $document2['S_path'];

        $pdf = new Fpdi\TcpdfFpdi();

        if (file_exists($pdfpath)) {
            $pagecount = $pdf->setSourceFile($pdfpath);
        } else {
            die('Source PDF not found!');
        }

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $signatureWidth = 40; // Adjust this value based on your requirements
        $signatureHeight = 15; // Adjust this value based on your requirements

        // Add watermark image to the last page of the existing PDF
        for ($i = 1; $i <= $pagecount; $i++) {
            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);

            $pdf->AddPage(); // Always add a new page

            if ($i === $pagecount) {
                // Only on the last iteration, set the current page and add the image
                $pdf->setPage($i);
                $xxx_final = ($size['width'] - 50);
                $yyy_final = ($size['height'] - 40);
                $pdf->Image($sigPath, $xxx_final, $yyy_final, $signatureWidth, $signatureHeight, 'png');
            }

            $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], false);
        }

        ob_end_clean();
        // Output PDF with watermark
        $pdf->Output($pdfpath, 'F');

        break;
    }

    case 'I':
        if ($action === 'check') {
       $query = "SELECT tb_invoice.I_id, I_path, U_id
                  FROM tb_invoice
                  LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id 
                  WHERE tb_invoice.I_id = '$formId' AND tb_invoice_generation.D_progress = '2'";

        $result = mysqli_query($con, $query);
        $document = mysqli_fetch_assoc($result);

        $pdfPath = $document['I_path'];

        $absoluteFilePath = '/home11/akmajuco/public_html/AKMaju/';

        $pdfpath = $absoluteFilePath . $pdfPath;

        $U_ICheckid = $document['U_id'];

        $query2 = "SELECT S_path 
                   FROM tb_signature 
                   WHERE U_id = $U_ICheckid AND S_status = '1'";

        $result2 = mysqli_query($con, $query2);
        $document2 = mysqli_fetch_assoc($result2);

        $signaturePath = $document2['S_path'];

        $sigPath = $absoluteFilePath . $signaturePath;

        $pdf = new Fpdi\TcpdfFpdi();

        if (file_exists($pdfpath)) {
            $pagecount = $pdf->setSourceFile($pdfpath);
        } else {
            die('Source PDF not found!');
        }

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $signatureWidth = 33; // Adjust this value based on your requirements
        $signatureHeight = 18; // Adjust this value based on your requirements

        // Add watermark image to the last page of the existing PDF
        for ($i = 1; $i <= $pagecount; $i++) {
            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);

            $pdf->AddPage(); // Always add a new page

            if ($i === $pagecount) {
                // Only on the last iteration, set the current page and add the image
                $pdf->setPage($i);
                $xxx_final = ($size['width'] - 145);
                $yyy_final = ($size['height'] - 45);
                $pdf->Image($sigPath, $xxx_final, $yyy_final, $signatureWidth, $signatureHeight, 'png');
            }

            $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], false);
        }

        ob_end_clean();
        // Output PDF with watermark
        $pdf->Output($pdfpath, 'F');
    }

    else if ($action === 'approve') {
        $query = "SELECT tb_invoice.I_id, I_path, U_id
                  FROM tb_invoice
                  LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id 
                  WHERE tb_invoice.I_id = '$formId' AND tb_invoice_generation.D_progress = '3'";

        $result = mysqli_query($con, $query);
        $document = mysqli_fetch_assoc($result);

        $pdfPath = $document['I_path'];

        $absoluteFilePath = '/home11/akmajuco/public_html/AKMaju/';

        $pdfpath = $absoluteFilePath . $pdfPath;

        $U_IApproveid = $document['U_id'];

        $query2 = "SELECT S_path 
                   FROM tb_signature 
                   WHERE U_id = $U_IApproveid AND S_status = '1'";

        $result2 = mysqli_query($con, $query2);
        $document2 = mysqli_fetch_assoc($result2);

        $sigPath = $document2['S_path'];

        $pdf = new Fpdi\TcpdfFpdi();

        if (file_exists($pdfpath)) {
            $pagecount = $pdf->setSourceFile($pdfpath);
        } else {
            die('Source PDF not found!');
        }

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $signatureWidth = 33; // Adjust this value based on your requirements
        $signatureHeight = 18; // Adjust this value based on your requirements

        // Add watermark image to the last page of the existing PDF
        for ($i = 1; $i <= $pagecount; $i++) {
            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);

            $pdf->AddPage(); // Always add a new page

            if ($i === $pagecount) {
                // Only on the last iteration, set the current page and add the image
                $pdf->setPage($i);
                $xxx_final = ($size['width'] - 97);
                $yyy_final = ($size['height'] - 45);
                $pdf->Image($sigPath, $xxx_final, $yyy_final, $signatureWidth, $signatureHeight, 'png');
            }

            $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], false);
        }

        ob_end_clean();
        // Output PDF with watermark
        $pdf->Output($pdfpath, 'F');

        break;
    }

    case 'DO':
        if ($action === 'approve') {
        $query = "SELECT tb_delivery_order.DO_id, DO_path, U_id
                  FROM tb_delivery_order
                  LEFT JOIN tb_do_generation ON tb_delivery_order.DO_id = tb_do_generation.DO_id 
                  WHERE tb_delivery_order.DO_id = '$formId' AND tb_do_generation.D_progress = '3'";

        $result = mysqli_query($con, $query);
        $document = mysqli_fetch_assoc($result);

        $pdfPath = $document['DO_path'];

        $absoluteFilePath = '/home11/akmajuco/public_html/AKMaju/';

        $pdfpath = $absoluteFilePath . $pdfPath;

        $U_DOApproveid = $document['U_id'];

        $query2 = "SELECT S_path 
                   FROM tb_signature 
                   WHERE U_id = $U_DOApproveid AND S_status = '1'";

        $result2 = mysqli_query($con, $query2);
        $document2 = mysqli_fetch_assoc($result2);

        $sigPath = $document2['S_path'];

        $pdf = new Fpdi\TcpdfFpdi();

        if (file_exists($pdfpath)) {
            $pagecount = $pdf->setSourceFile($pdfpath);
        } else {
            die('Source PDF not found!');
        }

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $signatureWidth = 40; // Adjust this value based on your requirements
        $signatureHeight = 15; // Adjust this value based on your requirements

        // Add watermark image to the last page of the existing PDF
        for ($i = 1; $i <= $pagecount; $i++) {
            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);

            $pdf->AddPage(); // Always add a new page

            if ($i === $pagecount) {
                // Only on the last iteration, set the current page and add the image
                $pdf->setPage($i);
                $xxx_final = ($size['width'] - 50);
                $yyy_final = ($size['height'] - 40);
                $pdf->Image($sigPath, $xxx_final, $yyy_final, $signatureWidth, $signatureHeight, 'png');
            }

            $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], false);
        }

        ob_end_clean();
        // Output PDF with watermark
        $pdf->Output($pdfpath, 'F');

        break;

    }
}
}

mysqli_close($con);
//Redirect
header("Location: adminVerification.php?id=$fid");
?>