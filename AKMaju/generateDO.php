<?php     
include ('dbconnect.php');  
include_once('tcpdf_6_2_13/tcpdf.php');

if(!session_id()) {
    session_start();
}

if(isset($_GET['id'])) {
    $fid = $_GET["id"];
}

function generateFId($con) {
    $prefix = 'DO';
    $uniqueId = bin2hex(random_bytes(3)); // Generates a random unique identifier

    // Combine the prefix and unique identifier
    $fId = $prefix . $uniqueId;

    // Check if the generated ID already exists in the table
    $query = "SELECT DO_id FROM tb_delivery_order WHERE DO_id = '$fId'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        // If the generated ID already exists, generate a new one
        generateFId($con);
    } else {
        return $fId;
    }
}

define('SST_REGISTRATION_NUMBER', '000');


    $do = isset($_POST["O_id"]) ? $_POST["O_id"] : "";
    
        $generateUser = isset($_POST["U_id"]) ? $_POST["U_id"] : "";
        $remark = isset($_POST["remark"]) ? $_POST["remark"] : "";
        $issueDate = isset($_POST["issueDate"]) ? $_POST["issueDate"] : "";
        $deliveryDate = isset($_POST["deliveryDate"]) ? $_POST["deliveryDate"] : "";

        $newDOId = generateFId($con);

        // Prepare and execute the SQL query (replace with your actual table and column names)
        $sql_insert = "INSERT INTO tb_delivery_order(DO_id, DO_remark, DO_issueDate, DO_deliveryDate, DO_status, O_id, DO_path) 
                       VALUES ('$newDOId', NULLIF('$remark', ''), '$issueDate', '$deliveryDate', '11', '$do', '')";

        $result_insert = mysqli_query($con, $sql_insert); 

        $sql_insert1 = "INSERT INTO tb_do_generation(DO_id, U_id, D_progress) 
                       VALUES ('$newDOId', '$generateUser', '1')";

        $result_insert1 = mysqli_query($con, $sql_insert1);


        $sql_update = "UPDATE tb_advertisement_order
                       SET AO_deliveryStatus = '11'
                       WHERE O_id = '$do'";

        $result_update = mysqli_query($con, $sql_update);


$sstNumber = SST_REGISTRATION_NUMBER;

class PDF extends TCPDF {
    public function Header() {
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
                <span style="font-size:7.5px;">No. 39 & 41, Jalan Utama 3/2, Pusat Komersial Sri Utama,</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.5px;">Segamat, Johor, Malaysia- 85000</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.5px;">07-9310717, 010-2218224</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.5px;">akmaju.acc@gmail.com</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <span style="font-size:7.5px;">Company No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1088436 K</span>
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
    
    public function Header1() {
    $option1 = '
    <table cellpadding="0" cellspacing="0" style="border:none; width:100%;">
        <tr>
            <td colspan="2" align="center">
                <b style="font-size:12px;">DELIVERY ORDER</b>
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

    public function setLinePosition($position) {
        $this->lineYPosition = $position;
    }

    public function Footer() {
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
        LEFT JOIN tb_delivery_order ON tb_delivery_order.O_id = tb_advertisement_order.O_id
        LEFT JOIN tb_customer ON tb_customer.C_id = tb_advertisement_order.C_id
        LEFT JOIN tb_terms_of_payment ON tb_terms_of_payment.TOP_id = tb_advertisement_order.O_TOP
        WHERE tb_advertisement_order.O_id = '$do'";

$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);

$sql_material = "SELECT *
                 FROM tb_advertisement_order
                 LEFT JOIN tb_ao_material ON tb_ao_material.O_id = tb_advertisement_order.O_id
                 LEFT JOIN tb_advertisement_material ON tb_advertisement_material.AM_id = tb_ao_material.AM_id
                 WHERE tb_advertisement_order.O_id = '$do'";

$result1 = mysqli_query($con, $sql_material);

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
$pdf->SetHeaderData('', '', 'Deivery Order', '');  
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
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
                    <td width="64%" class="bold add alignleft">TO</td>
                </tr>
                <tr>
                    <td class="add alignleft">' . $row['C_name'] . '</td>
                </tr>';
        if ($row["C_type"] == '2' || $row["C_type"] == '3') {
            $html .= '<tr>
                            <td>' . $row9['AG_name'] . '</td>
                        </tr>';
        }
        $html .= '<tr>
                    <td class="add alignleft">' . $row['C_street'] . '</td>
                </tr>
                <tr>
                    <td class="add alignleft">' . $row['C_postcode'] . '</td>
                </tr>
                <tr>
                    <td class="add alignleft">' . $row['C_city'] . '</td>
                </tr>
                <tr>
                    <td class="add alignleft">' . $row['C_state'] . '</td>
                </tr>
                <tr>
                    <td class="add alignleft">' . $row['C_country'] . '</td>
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
                    <td width="65%" class="bold detail alignleft">DELIVERY ORDER NO</td>
                    <td class="detail alignleft">' . $row['DO_id'] . '</td>
                </tr>
                <tr> 
                    <td class="bold detail alignleft">DELIVERY DATE</td>
                    <td class="detail alignleft">' . $row['DO_deliveryDate'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">TERMS OF PAYMENT</td>
                    <td class="detail alignleft">' . $row['TOP_name'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">PO. NO</td>
                    <td class="detail alignleft">' . $row['O_id'] . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

$doIntro = 'Dear Sir/Madam, here with is our Delivery Order generated for your perusal.';
$item = 'ITEMS DETAILS';

$html .= '<br><br><br><span style="font-size:10px;">' . $doIntro . '</span><br><br>';
$html .= '<span><b>' . $item . '</b></span><br><br>';

$html .= '<style type="text/css">
    .dataheader {
        font-size: 7.8px;
        font-weight: bold;
        line-height: 15px;
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
        padding: 5px;
        border-collapse: collapse;
    }
</style>
<table style="width:100%; margin-left:0; border-collapse: collapse;">
    <tr>
        <th width="10%" class="aligncenter dataheader">S.NO</th>
        <th width="20%" class="aligncenter dataheader">ITEM CODE</th>
        <th width="55%" class="aligncenter dataheader">DESCRIPTION</th>
        <th width="15%" class="aligncenter dataheader">QUANTITY</th>
    </tr>';

$counter = 1;
$totalqty = 0;

while ($row1 = mysqli_fetch_array($result1)) {
    $html .= '<tr>
            <td class="data">' . $counter . '</td>
            <td class="data aligncenter">' . $row1['AM_id'] . '</td>
            <td class="data">' . $row1['AM_name'] . ' ' . $row1['AM_variation'] . ' ' . $row1['AM_dimension'] . ' ' . $row1['AOM_unit'] . ' ' . $row1['AM_unit'] .'</td>
            <td class="data aligncenter">' . $row1['AOM_qty'] . '</td>
        </tr>';
    $counter++;

    $totalqty += $row1['AOM_qty'];
}

$html .= '<tr>
            <td></td>
            <td></td>
            <td class="data bold alignright" style="background-color: #f2f2f2;">GRAND TOTAL</td>
            <td class="data bold aligncenter">' . $totalqty . '</td>
          </tr>
        </table>';

$pdf->writeHTML($html, true, false, true, false, '');

$current_page = $pdf->getPage();
$bottom_margin = 30; // Adjust this margin as needed
$right_margin = 0;  // Adjust this margin as needed

// Get the remaining height on the current page
$remaining_height = $pdf->getPageHeight() - $pdf->GetY() - $bottom_margin;

// Check if there is enough space for the signature and text
if ($remaining_height > 20) { // Adjust the threshold (20) as needed
    // Move the cursor to the desired position for the dotted line
    $pdf->SetY(-$bottom_margin);
    $pdf->SetX($right_margin + 155); // Adjust this value as needed

    // HTML content for the dotted line
    $html_dotted_line = '<span>____________________________</span>';
    
    $pdf->writeHTML($html_dotted_line, true, false, false, false, '');

    // Move the cursor to the desired position for the word "Authorized Signature"
    $pdf->SetY(-$bottom_margin + 5);
    $pdf->SetX($right_margin + 20); // Adjust this value as needed

    // HTML content for the word "Authorized Signature"
    $html_authorized_signature = '<div style="text-align: right;"><b>Authorized Signature</b></div>';

    $pdf->writeHTML($html_authorized_signature, true, false, false, false, '');
} else {
    // Move to the next page and add signature and text
     $pdf->AddPage();

    // Add signature field or any other content on the new page
    $bottom_margin = 30; // Adjust this margin as needed
    $right_margin = 0;  // Adjust this margin as needed

    // Move the cursor to the desired position for the dotted line
    $pdf->SetY(-$bottom_margin);
    $pdf->SetX($right_margin + 155); // Adjust this value as needed

    // HTML content for the dotted line
    $html_dotted_line = '<span>____________________________</span>';
    
    $pdf->writeHTML($html_dotted_line, true, false, false, false, '');

    // Move the cursor to the desired position for the word "Authorized Signature"
    $pdf->SetY(-$bottom_margin + 5);
    $pdf->SetX($right_margin + 20); // Adjust this value as needed

    // HTML content for the word "Authorized Signature"
    $html_authorized_signature = '<div style="text-align: right;"><b>Authorized Signature</b></div>';

    $pdf->writeHTML($html_authorized_signature, true, false, false, false, '');
}

$file_location = "DeliveryOrder/";

$file_name = $newDOId . '_' . $do . ".pdf";


// Specify the absolute path to save the PDF
$absoluteFilePath = '/C:/xampp/htdocs/AKMaju/AKMaju/' . $file_location . $file_name;


// Output PDF to file and update the database
$pdf->Output($absoluteFilePath, 'F');

$updateQuery = "UPDATE tb_delivery_order 
                SET DO_path = '$file_location$file_name' 
                WHERE DO_id = '$newDOId'";
$result = mysqli_query($con, $updateQuery); 

ob_end_clean();

mysqli_close($con);

echo "<script>
       window.location.href='EditAOrder.php?id=$fid&o_id=$quotation';
   </script>";

?>



