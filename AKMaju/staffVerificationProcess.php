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
    $formId = $_POST['form_id'];
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];

        if ($action === 'check') {

            $sqlMainTable = "INSERT INTO tb_invoice_generation (I_id, U_id, D_progress)
                             VALUES ('$formId', '$fid', '2')";

            $sqlAdditionalTable = "UPDATE tb_invoice
                                   SET I_status = '11'
                                   WHERE I_id = '$formId'";

        }

$mainTableResult = mysqli_query($con, $sqlMainTable);
$additionalTableResult = mysqli_query($con, $sqlAdditionalTable);


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
}

mysqli_close($con);
//Redirect
header("Location: staffVerification.php?id=$fid");
exit();
?>