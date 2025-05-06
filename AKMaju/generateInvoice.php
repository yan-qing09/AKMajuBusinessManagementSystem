<?php
include('dbconnect.php');
include_once('tcpdf_6_2_13/tcpdf.php');

if (!session_id()) {
    session_start();
}

if (isset($_GET['id'])) {
    $fid = $_GET["id"];
}

function generateFId($con)
{
    $prefix = 'I';
    $uniqueId = bin2hex(random_bytes(3)); // Generates a random unique identifier

    // Combine the prefix and unique identifier
    $fId = $prefix . $uniqueId;

    // Check if the generated ID already exists in the table
    $query = "SELECT I_id FROM tb_invoice WHERE I_id = '$fId'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // If the generated ID already exists, generate a new one
        generateFId($con);
    } else {
        return $fId;
    }
}

define('SST_REGISTRATION_NUMBER', '000');


$inv = isset($_POST["O_id"]) ? $_POST["O_id"] : "";

$generateUser = isset($_POST["U_id"]) ? $_POST["U_id"] : "";
$remark = isset($_POST["remark"]) ? $_POST["remark"] : "";
$issueDate = isset($_POST["issueDate"]) ? $_POST["issueDate"] : "";
$expiryDate = isset($_POST["expiryDate"]) ? $_POST["expiryDate"] : "";

// Generate the new AQ ID
$newIId = generateFId($con);

$sql_search = "SELECT DO_id, DO_issueDate
               FROM tb_delivery_order
               WHERE O_id = '$inv'
               ORDER BY DO_issueDate DESC
               LIMIT 1";

$result_search = mysqli_query($con, $sql_search);

if ($result_search) {
    $rows = mysqli_fetch_assoc($result_search);
    $doid = $rows['DO_id'];


    // Check if $doid is set and not empty
    if (!isset($doid) || empty($doid)) {
        $sql_insert = "INSERT INTO tb_invoice(I_id, I_remark, I_issueDate, I_expiryDate, I_status, O_id, I_path) 
                       VALUES ('$newIId', NULLIF('$remark', ''), '$issueDate', '$expiryDate', '12', '$inv', '')";
    } else {
        $sql_insert = "INSERT INTO tb_invoice(I_id, I_remark, I_issueDate, I_expiryDate, I_status, O_id, DO_id, I_path) 
                   VALUES ('$newIId', NULLIF('$remark', ''), '$issueDate', '$expiryDate', '12', '$inv', '$doid', '')";
    }

    $result_insert = mysqli_query($con, $sql_insert);
}

$sql_insert1 = "INSERT INTO tb_invoice_generation(I_id, U_id, D_progress) 
                       VALUES ('$newIId', '$generateUser', '1')";

$result_insert1 = mysqli_query($con, $sql_insert1);

$sql_update = "UPDATE tb_advertisement_order
                       SET AO_invoiceStatus = '11'
                       WHERE O_id = '$inv'";

$result_update = mysqli_query($con, $sql_update);




$sstNumber = SST_REGISTRATION_NUMBER;

class PDF extends TCPDF
{
    public function Header()
    {
        $companyInfo = '
    <table cellpadding="0" cellspacing="0" style="border:none; width:100%;">
        <tr>
            <td align="left" rowspan="6" width="60%"><img src="assets/img/logo2.png" alt="Logo" style="width: 135px; height: 37px;"></td>
            <td align="left" colspan="2" style="padding-top: 10px">
                <b style="font-size:7.8px;">AK MAJU RESOURCES SDN. BHD.</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.15px;">No. 39 & 41, Jalan Utama 3/2, Pusat Komersial Sri Utama,</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.15px;">Segamat, Johor, Malaysia- 85000</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.15px;">07-9310717, 010-2218224</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.15px;">akmaju.acc@gmail.com</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.15px;">Company No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1088436 K</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
        </tr>
    </table>';

        $this->SetCellPaddings(0, 0, 0, 0);
        $this->SetCellHeightRatio(1.2);
        $this->SetXY(13, 13);
        $this->writeHTML($companyInfo, true, false, false, false, '');
    }

    public function Header1()
    {
        $option1 = '
    <table cellpadding="0" cellspacing="0" style="border:none; width:100%;">
        <tr>
            <td colspan="2" align="center">
                <b style="font-size:12px;">INVOICE</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
        </tr>
    </table>';

        $this->SetCellPaddings(0, 0, 0, 0);
        $this->SetCellHeightRatio(1.0);
        $this->SetXY(10, 45);
        $this->writeHTML($option1, true, false, false, false, '');
    }

    public function setLinePosition($position)
    {
        $this->lineYPosition = $position;
    }

    public function Footer()
    {
        // Set line style
        $lineYPosition = 283; // Adjust this value to set the line higher or lower
        $this->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));
        $this->Line(10, $lineYPosition, 200, $lineYPosition);

        // Set content
        $leftContent = 'SIMPLIFIED BUSINESS SYSTEM';
        $rightContent = 'DATE: ' . date('d-M-Y') . "\t\t\t\tTIME: " . date('h:i:sA');
        $rightContent .= "\t\t\t\t" . $this->getAliasNumPage();

        // Calculate the width of the right content
        $rightContentWidth = $this->GetStringWidth($rightContent);

        // Set up the table
        $this->SetY(-15);
        $this->Cell(0, 10, $leftContent, 0, 0, 'L');
        $this->SetX($this->GetPageWidth() - $rightContentWidth);
        $this->Cell($rightContentWidth, 10, $rightContent, 0, 'R');
    }
}

$sql = "SELECT *
        FROM tb_advertisement_order
        LEFT JOIN tb_invoice ON tb_invoice.O_id = tb_advertisement_order.O_id
        LEFT JOIN tb_customer ON tb_customer.C_id = tb_advertisement_order.C_id
        LEFT JOIN tb_terms_of_payment ON tb_terms_of_payment.TOP_id = tb_advertisement_order.O_TOP
        WHERE tb_advertisement_order.O_id = '$inv'";

$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);

$sql_material = "SELECT *
                 FROM tb_advertisement_order
                 LEFT JOIN tb_ao_material ON tb_ao_material.O_id = tb_advertisement_order.O_id
                 LEFT JOIN tb_advertisement_material ON tb_advertisement_material.AM_id = tb_ao_material.AM_id
                 WHERE tb_advertisement_order.O_id = '$inv'";

$result1 = mysqli_query($con, $sql_material);

$query2 = "SELECT S_path 
           FROM tb_signature 
           WHERE U_id = $generateUser AND S_status = '1'";

$result2 = mysqli_query($con, $query2);
$document2 = mysqli_fetch_assoc($result2);

$sql9 = "SELECT tb_customer.C_id, tb_agency_government.AG_name
         FROM tb_customer
         LEFT JOIN tb_agency_government ON tb_customer.C_id = tb_agency_government.C_id
         WHERE tb_customer.C_id = '" . $row['C_id'] . "'";

$result9 = mysqli_query($con, $sql9);

$row9 = mysqli_fetch_array($result9);


//----- Code for generate pdf
$pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
$pdf->SetHeaderData('', '', 'Invoice', '');
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins('10', '13', '10');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->SetFont('helvetica', '', 7.8);



$pdf->AddPage(); //default A4
//$pdf->AddPage('P','A5'); //when you require custome page size 
$pdf->Header();
$pdf->Header1();

// Reset cell height settings
$pdf->SetCellPaddings(1, 1, 1, 1);
$pdf->SetCellHeightRatio(1.5);

// Create line above the header
$lineYPosition = 51; // Adjust this value to set the line higher or lower
$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));
$pdf->Line(10, $lineYPosition, 200, $lineYPosition);
$pdf->SetXY(10, 53);
// Create table header

$html = '<style type="text/css">
    th {
        font-size: 7.3px;
        font-weight: bold;
        line-height: 15px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
        text-align: center;
    }

    .td {
        font-size: 7.3px;
        line-height: 15px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
    }

    .add {
        font-size: 7.3px;
        line-height: 12px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
    }

    .detail {
        font-size: 7.3px;
        line-height: 18px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
    }

    .top {
        border-top: 1px solid black;
    }

    .left {
        border-left: 1px solid black;
    }

    .right {
        border-right: 1px solid black;
    }

    .bottom {
        border-bottom: 1px solid black;
    }
    .alignright {
        text-align: right;
    }

    .alignleft {
        text-align: left;
    }

    .aligncenter {
        text-align: center;
    }
    .bold {
        font-weight: bold;
    }

</style> 
<table style="width: 100%; padding: 0px;">
    <tr>
        <td style="width: 64%; vertical-align: top;">
            <!-- Left table content here -->
            <table style="width: 100%; border-collapse: collapse; border: none; margin:0px;">
                <!-- Left table rows and cells -->
                <tr>
                    <td align="left" width="64%" class="bold add">TO</td>
                </tr>
                <tr>
                    <td align="left" class="add">' . $row['C_name'] . '</td>
                </tr>';
        if ($row["C_type"] == '2' || $row["C_type"] == '3') {
            $html .= '<tr>
                            <td>' . $row9['AG_name'] . '</td>
                        </tr>';
        }
        $html .= '<tr>
                    <td align="left" class="add">' . $row['C_street'] . '</td>
                </tr>
                <tr>
                    <td align="left" class="add">' . $row['C_postcode'] . '</td>
                </tr>
                <tr>
                    <td align="left" class="add">' . $row['C_city'] . '</td>
                </tr>
                <tr>
                    <td align="left" class="add">' . $row['C_state'] . '</td>
                </tr>
                <tr>
                    <td align="left" class="add">' . $row['C_country'] . '</td>
                </tr>
            </table>
        </td>
        <td style="width: 36%; vertical-align: top;">
            <!-- Right table content here -->
            <table style="width: 100%; border-collapse: collapse; border: none;">
                <!-- Right table rows and cells -->
                <tr>
                    <td class="add"></td>
                    <td class="add"></td>
                </tr>
                <tr> 
                    <td width="65%" class="bold detail alignleft">INVOICE NO</td>
                    <td class="detail alignleft">' . $row['I_id'] . '</td>
                </tr>
                <tr> 
                    <td class="bold detail alignleft">INVOICE DATE</td>
                    <td class="detail alignleft">' . $row['I_issueDate'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">SST REGISTRATION. NO</td>
                    <td class="detail alignleft">' . $sstNumber . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">TERMS OF PAYMENT</td>
                    <td class="detail alignleft">' . $row['TOP_name'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">PO. NO</td>
                    <td class="detail alignleft">' . $row['O_id'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail">DO. NO</td>
                    <td class="detail alignleft">' . $doid . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';




$invoiceIntro = 'Dear Sir/Madam, here with is our Invoice generated for your perusal.';
$item = 'ITEMS DETAILS';

$html .= '<br><br><span style="font-size:10px;">' . $invoiceIntro . '</span><br><br>';
$html .= '<span><b>' . $item . '</b></span><br><br>';

$html .= '<style type="text/css">
    .dataheader {
        font-size: 7.8px;
        font-weight: bold;
        line-height: 10px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
        border: 0.7px solid black;
        padding: 5px;
        background-color: #f2f2f2;
        border-collapse: collapse;
    }

    .data {
        font-size: 7.8px;
        line-height: 15px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
        border: 0.7px solid black;
        border-collapse: collapse;
    }

    .bgcolor {
        background-color: #f2f2f2;
    }
</style>
<table style="width:100%; margin-left:0;">
    <tr>
        <th width="5%" class="alignleft dataheader">S.NO</th>
        <th width="25%" class="alignleft dataheader">DESCRIPTION</th>
        <th width="9%" class="aligncenter dataheader">QUANTITY</th>
        <th width="9%" class="aligncenter dataheader">UNIT PRICE (RM)</th>
        <th width="9%" class="aligncenter dataheader">DISC %</th>
        <th width="9%" class="aligncenter dataheader">DISC AMOUNT (RM)</th>
        <th width="9%" class="aligncenter dataheader">TAX CODE</th>
        <th width="9%" class="aligncenter dataheader">TAX AMOUNT (RM)</th>
        <th width="16%" class="aligncenter dataheader">TOTAL INCL. TAX <br>(RM)</th>
    </tr>';

$counter = 1;
$taxAmount = 0;
$totalPrice = 0;
while ($row1 = mysqli_fetch_array($result1)) {
    $html .= '<tr>
            <td class="data">' . $counter . '</td>
            <td class="data">' . $row1['AM_name'] . ' ' . $row1['AM_variation'] . ' ' . $row1['AM_dimension'] . ' ' . $row1['AOM_unit'] . ' ' . $row1['AM_unit'] . '</td>
            <td class="data aligncenter">' . $row1['AOM_qty'] . '</td>
            <td class="data alignright">' . number_format($row1['AOM_adjustprice'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row1['AOM_discPct'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row1['AOM_discAmt'], 2, '.', '') . '</td>
            <td class="data aligncenter">' . $row1['AOM_taxcode'] . '</td>
            <td class="data alignright">' . number_format($row1['AOM_taxAmt'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row1['AOM_totalprice'], 2, '.', '') . '</td>
        </tr>';
    $counter++;
    $taxAmount += $row1['AOM_taxAmt'];
    $totalPrice += $row1['AOM_totalprice'];
}

$html .= '<tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3" class="data bold alignright" style="background-color: #f2f2f2;">TOTAL AMOUNT</td>
            <td class="data bold alignright">' . number_format($taxAmount, 2, '.', '') . '</td>
            <td class="data bold alignright">' . number_format($totalPrice, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4" class="data bold alignright" style="background-color: #f2f2f2;">AMOUNT PAYABLE</td>
            <td class="data bold alignright">' . number_format($totalPrice, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4" class="data bold alignright" style="background-color: #f2f2f2;">UP FRONT</td>
            <td class="data bold alignright">' . number_format($row['AO_deposit'], 2, '.', '') . '</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4" class="data bold alignright" style="background-color: #f2f2f2;">BALANCE</td>
            <td class="data bold alignright">' . number_format(($totalPrice - $row['AO_deposit']), 2, '.', '') . '</td>
          </tr>
        </table>';

$pdf->SetCellHeightRatio(1.3);
$html .= '<tr>
  <td colspan="8">
    <i>
      <ul>
        <li>E. and O.E. All Cheque Should Be Crossed and made payable to AK MAJU RESOURCES SDN BHD</li>
        <li>Please bank in to our account <strong>MAYBANK A/C: 551052384209</strong></li>
        <li>Full payment is due within 30 days of the invoice date</li>
        <li>Deposit is Not Refundable. All goods sold are not returnable. All prices change without prior notice. Carry in warranty</li>
      </ul>
    </i>
  </td>
  <td></td>
</tr>
        </table>';

$pdf->writeHTML($html, true, false, true, false, '');

$current_page = $pdf->getPage();
$pdf->SetCellHeightRatio(1.5);
// Check if there is another page
if ($pdf->getNumPages() == $current_page) {

    $remainingSpace = $pdf->getPageHeight() - $pdf->GetY();

    // Example adjustment based on remaining space
    $pdf->SetXY(10, $pdf->GetY() + $remainingSpace - 45);

    $sigPath = $document2['S_path'];

    // Create a table for the labels
    $html_labels = '<table border="0" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width:15px;"></td>
        <td style="width:18%; text-align:center;"><img src="' . $sigPath . '" style="max-width:100%; max-height:50px;"></td>
        <td style="width:40px;"></td>
        <td style="width:18%; text-align:center;"></td>
        <td style="width:40px;"></td>
        <td style="width:18%; text-align:center;"></td>
        <td style="width:40px;"></td>
        <td style="width:18%; text-align:center;"></td>
        <td></td>
    </tr>
    <tr>
        <td style="width:15px;"></td>
        <td style="width:18%; text-align:center; border-top:1px solid black"><b>PREPARED BY</b></td>
        <td style="width:40px;"></td>
        <td style="width:18%; text-align:center; border-top:1px solid black"><b>CHECKED BY</b></td>
        <td style="width:40px;"></td>
        <td style="width:18%; text-align:center; border-top:1px solid black"><b>APPROVED BY</b></td>
        <td style="width:40px;"></td>
        <td style="width:18%; text-align:center; border-top:1px solid black"><b>RECEIVED BY</b></td>
        <td></td>
    </tr>
</table>';

    // Add labels to the PDF
    $pdf->writeHTML($html_labels, true, false, false, false, '');
}

$file_location = "Invoice/";

$file_name = $newIId . '_' . $inv . ".pdf";


// Specify the absolute path to save the PDF
$absoluteFilePath = '/C:/xampp/htdocs/AKMaju/AKMaju/' . $file_location . $file_name;

// Output PDF to file and update the database
$pdf->Output($absoluteFilePath, 'F');

$updateQuery = "UPDATE tb_invoice 
                SET I_path = '$file_location$file_name' 
                WHERE I_id = '$newIId'";
$result = mysqli_query($con, $updateQuery);

ob_end_clean();

mysqli_close($con);

echo "<script>
       window.location.href='advertisementgeneration.php?id=$fid';
    </script>";


