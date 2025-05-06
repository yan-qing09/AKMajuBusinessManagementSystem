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
    $prefix = 'CQ';
    $uniqueId = bin2hex(random_bytes(3)); // Generates a random unique identifier

    // Combine the prefix and unique identifier
    $fId = $prefix . $uniqueId;

    // Check if the generated ID already exists in the table
    $query = "SELECT CQ_id FROM tb_construction_quotation WHERE CQ_id = '$fId'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        // If the generated ID already exists, generate a new one
        generateFId($con);
    } else {
        return $fId;
    }
}

define('SST_REGISTRATION_NUMBER', '000');

    $quotation = isset($_POST["CO_id"]) ? $_POST["CO_id"] : "";

        $generateUser = isset($_POST["U_id"]) ? $_POST["U_id"] : "";
        $remark = isset($_POST["remark"]) ? $_POST["remark"] : "";
        $issueDate = isset($_POST["issueDate"]) ? $_POST["issueDate"] : "";
        $dueDate = isset($_POST["dueDate"]) ? $_POST["dueDate"] : "";

        // Generate the new CQ ID
        $newCQId = generateFId($con);

        // Prepare and execute the SQL query (replace with your actual table and column names)
        $sql_insert = "INSERT INTO tb_construction_quotation(CQ_id, CQ_remark, CQ_issueDate, CQ_dueDate, CQ_status, O_id, CQ_path) 
                       VALUES ('$newCQId', NULLIF('$remark', ''), '$issueDate', '$dueDate', '11', '$quotation', '')";

        $result_insert = mysqli_query($con, $sql_insert); 

        $sql_insert1 = "INSERT INTO tb_cq_generation(CQ_id, U_id, D_progress) 
                       VALUES ('$newCQId', '$generateUser', '1')";

        $result_insert1 = mysqli_query($con, $sql_insert1);

        $sql_update = "UPDATE tb_construction_order
                       SET O_quotationStatus = '11'
                       WHERE O_id = '$quotation'";

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
                <b style="font-size:12px;">QUOTATION</b>
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
        FROM tb_construction_order
        LEFT JOIN tb_construction_quotation ON tb_construction_quotation.O_id = tb_construction_order.O_id
        LEFT JOIN tb_customer ON tb_customer.C_id = tb_construction_order.C_id
        LEFT JOIN tb_terms_of_payment ON tb_terms_of_payment.TOP_id = tb_construction_order.O_TOP
        WHERE tb_construction_order.O_id = '$quotation'";

$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);

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
$pdf->SetHeaderData('', '', 'Quotation', '');  
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
                    <td width="65%" class="bold detail alignleft">QUOTATION NO</td>
                    <td class="detail alignleft">' . $row['CQ_id'] . '</td>
                </tr>
                <tr> 
                    <td class="bold detail alignleft">QUOTATION DATE</td>
                    <td class="detail alignleft">' . $row['CQ_issueDate'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">TERMS OF PAYMENT</td>
                    <td class="detail alignleft">' . $row['TOP_name'] . '</td>
                </tr>
                <tr>
                    <td class="bold detail alignleft">SST REGISTRATION. NO</td>
                    <td class="detail alignleft">' . $sstNumber . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

$quotationIntro = 'Dear Sir/Madam, here with is our Quotation generated for your perusal.';
$item = 'ITEMS DETAILS';

$html .= '<br><br><br><span style="font-size:10px;">' . $quotationIntro . '</span><br><br>';
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

    .typeheader {
        font-size: 8.5px;
        font-weight: bold;
        line-height: 12px;
        font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color: #000;
        border: 0.7px solid black;
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
</style>';

$html .= '<table style="width:100%; margin-left:0; border-collapse: collapse;">
    <tr>
        <th colspan="9" class="alignleft typeheader">ELEKTRIK</th>
    </tr>
    <tr>
        <th width="5%" class="alignleft dataheader">S.NO</th>
        <th width="25%" class="alignleft dataheader">ITEM DESCRIPTION</th>
        <th width="9%" class="aligncenter dataheader">QUANTITY</th>
        <th width="9%" class="aligncenter dataheader">UNIT PRICE (RM)</th>
        <th width="9%" class="aligncenter dataheader">DISC %</th>
        <th width="9%" class="aligncenter dataheader">DISC AMOUNT (RM)</th>
        <th width="9%" class="aligncenter dataheader">TAX CODE</th>
        <th width="9%" class="aligncenter dataheader">TAX AMOUNT (RM)</th>
        <th width="16%" class="aligncenter dataheader">TOTAL INCL. TAX <br>(RM)</th>
    </tr>';

$sqlEmaterial = "SELECT * 
                 FROM tb_co_material
                 LEFT JOIN tb_cm_type ON tb_co_material.CM_type = tb_cm_type.CM_type
                 LEFT JOIN tb_construction_material ON tb_construction_material.CM_id = tb_co_material.CM_id 
                           AND tb_construction_material.CM_variation = tb_co_material.CM_variation
                           AND tb_construction_material.CM_type = tb_co_material.CM_type
                 LEFT JOIN tb_construction_order ON tb_co_material.O_id = tb_construction_order.O_id
                 WHERE tb_co_material.O_id = '$quotation' AND tb_cm_type.CM_ctgy = '1'";

$result1 = mysqli_query($con, $sqlEmaterial);

$counterE = 1;
$taxAmountE = 0;
$totalEPrice = 0;

while ($row2 = mysqli_fetch_array($result1)) {
        $html .= '<tr>
            <td class="data">' . $counterE . '</td>
            <td class="data">' . $row2['CM_name'] . ' ' . $row2['CM_variation'] . ' ' . $row2['COM_unit'] . ' ' . $row2['CM_unit'] .'</td>
            <td class="data aligncenter">' . $row2['COM_qty'] . '</td>
            <td class="data alignright">' . number_format($row2['CM_price'] + $row2['CM_price'] * $row2['CO_markup'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row2['COM_discPct'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row2['COM_discAmt'], 2, '.', '') . '</td>
            <td class="data aligncenter">' . $row2['COM_taxCode'] . '</td>
            <td class="data alignright">' . number_format($row2['COM_taxAmt'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row2['COM_price'] + $row2['COM_price'] * $row2['CO_markup'], 2, '.', '') . '</td>
        </tr>';

        $counterE++;
        $taxAmountE += $row2['COM_taxAmt'];
        $totalEPrice += $row2['COM_price'];
}


$sqlEKawasan = "SELECT Z_perc
                FROM tb_zone
                JOIN tb_order_zone ON tb_zone.Z_state = tb_order_zone.Z_state
                                 AND tb_zone.Z_region = tb_order_zone.Z_region AND tb_zone.CM_ctgy = tb_order_zone.CM_ctgy
                WHERE tb_order_zone.CM_ctgy = 1
                  AND tb_order_zone.O_id = '$quotation'";

$resultEKawasan = mysqli_query($con, $sqlEKawasan);
$rowEKawasan = mysqli_fetch_array($resultEKawasan);

$EK_addon = $row['EK_addon'];

if ($EK_addon == '1') {
    $EK_Tperc = 0;
} else if ($EK_addon == '2') {
    $EK_Tperc = 2;
} else if ($EK_addon == '3') {
    $EK_Tperc = 5;
}

// Ensure $EK_Tperc is a numeric value
$EK_Tperc = floatval($EK_Tperc);

$totalEKawasan = ($rowEKawasan['Z_perc'] / 100) * $totalEPrice;
$totalETransport = ($EK_Tperc / 100) * $totalEPrice;
$totalEPrice += $totalEKawasan + $totalETransport;

$html .= '<tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">TAMBAHAN PERATUSAN KAWASAN ' . ($rowEKawasan['Z_perc'] ?? 0) . '%</td>
            <td class="data bold alignright">' . number_format($totalEKawasan, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">TAMBAHAN PERATUSAN KESUKARAN LOGISTIK ' . $EK_Tperc . '%</td>
            <td class="data bold alignright">' . number_format($totalETransport, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">TOTAL</td>
            <td class="data bold alignright">' . number_format($totalEPrice, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td colspan="9" style="border:none;"></td>
          </tr>
          </table>';

$html .= '<table style="width:100%; margin-left:0; border-collapse: collapse;">
    <tr>
        <th colspan="9" class="alignleft typeheader">KEJURUTERAAN AWAM</th>
    </tr>
    <tr>
        <th width="5%" class="alignleft dataheader">S.NO</th>
        <th width="25%" class="alignleft dataheader">ITEM DESCRIPTION</th>
        <th width="9%" class="aligncenter dataheader">QUANTITY</th>
        <th width="9%" class="aligncenter dataheader">UNIT PRICE (RM)</th>
        <th width="9%" class="aligncenter dataheader">DISC %</th>
        <th width="9%" class="aligncenter dataheader">DISC AMOUNT (RM)</th>
        <th width="9%" class="aligncenter dataheader">TAX CODE</th>
        <th width="9%" class="aligncenter dataheader">TAX AMOUNT (RM)</th>
        <th width="16%" class="aligncenter dataheader">TOTAL INCL. TAX <br>(RM)</th>
    </tr>';

$counterK = 1;
$taxAmountK = 0;
$totalKPrice = 0;

$sqlKmaterial = "SELECT * 
                 FROM tb_co_material
                 LEFT JOIN tb_cm_type ON tb_co_material.CM_type = tb_cm_type.CM_type
                 LEFT JOIN tb_construction_material ON tb_construction_material.CM_id = tb_co_material.CM_id
                           AND tb_construction_material.CM_variation = tb_co_material.CM_variation
                           AND tb_construction_material.CM_type = tb_co_material.CM_type
                 LEFT JOIN tb_construction_order ON tb_co_material.O_id = tb_construction_order.O_id
                 WHERE tb_co_material.O_id = '$quotation' AND tb_cm_type.CM_ctgy = '2'";

$result2 = mysqli_query($con, $sqlKmaterial);



while ($row3 = mysqli_fetch_array($result2)) {
        $html .= '
        <tr>
            <td class="data">' . $counterK . '</td>
            <td class="data">' . $row3['CM_name'] . ' ' . $row3['CM_variation'] . ' ' . $row3['COM_unit'] . ' ' . $row3['CM_unit'] .'</td>
            <td class="data aligncenter">' . $row3['COM_qty'] . '</td>
            <td class="data alignright">' . number_format($row3['CM_price'] + $row3['CM_price'] * $row3['CO_markup'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row3['COM_discPct'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row3['COM_discAmt'], 2, '.', '') . '</td>
            <td class="data aligncenter">' . $row3['COM_taxCode'] . '</td>
            <td class="data alignright">' . number_format($row3['COM_taxAmt'], 2, '.', '') . '</td>
            <td class="data alignright">' . number_format($row3['COM_price'] + $row3['COM_price'] * $row3['CO_markup'], 2, '.', '') . '</td>
        </tr>';

        $counterK++;
        $taxAmountK += $row3['COM_taxAmt'];
        $totalKPrice += $row3['COM_price'];
}



$sqlAKawasan = "SELECT Z_perc
                FROM tb_zone
                JOIN tb_order_zone ON tb_zone.Z_state = tb_order_zone.Z_state
                                 AND tb_zone.Z_region = tb_order_zone.Z_region AND tb_zone.CM_ctgy = tb_order_zone.CM_ctgy
                WHERE tb_order_zone.CM_ctgy = 2
                  AND tb_order_zone.O_id = '$quotation'";

$resultAKawasan = mysqli_query($con, $sqlAKawasan);
$rowAKawasan = mysqli_fetch_array($resultAKawasan);

$AK_addon = $row['AK_addon'];

if ($AK_addon == '1') {
    $AK_Tperc = 0;
} else if ($AK_addon == '2') {
    $AK_Tperc = 2;
} else if ($AK_addon == '3') {
    $AK_Tperc = 5;
} else if ($AK_addon == '4') {
    $AK_Tperc = 5;
}

$sqlAKadar = "SELECT AK_price, tb_order_rate.AK_ctgy, tb_order_rate.AK_name, tb_order_rate.AK_region, AK_unit 
              FROM tb_rate
              LEFT JOIN tb_order_rate ON tb_rate.AK_name = tb_order_rate.AK_name AND tb_rate.AK_ctgy = tb_order_rate.AK_ctgy AND tb_rate.AK_region = tb_order_rate.AK_region
                WHERE O_id = '$quotation'";

$resultAKadar = mysqli_query($con, $sqlAKadar);

$html .= '<tr>
                <td colspan="4" class="data bold aligncenter" style="background-color: #f2f2f2;">KAWASAN</td>
                <td colspan="3" class="data bold aligncenter" style="background-color: #f2f2f2;">TUKANG / LOGI</td>
                <td class="data bold aligncenter" style="background-color: #f2f2f2;">UNIT</td>
                <td class="data bold alignright" style="background-color: #f2f2f2;">HARGA</td>
              </tr>';

while ($rowAKadar = mysqli_fetch_array($resultAKadar)) {
    $price = (float)($rowAKadar['AK_price'] + $rowAKadar['AK_price'] * $row['CO_markup']);
    $html .= '<tr>
                <td colspan="4" class="data aligncenter">' . $rowAKadar['AK_region'] . '</td>
                <td colspan="3" class="data aligncenter">' . $rowAKadar['AK_name'] . '</td>
                <td class="data aligncenter">' . $rowAKadar['AK_unit'] .'</td>
                <td class="data alignright">' . number_format($price, 2, '.', '') . '</td>
              </tr>';

    $totalKPrice += $rowAKadar['AK_price'];
};


$totalATransport = ($AK_Tperc / 100) * $totalKPrice;

$totalAKawasan = (($rowAKawasan['Z_perc']) / 100) * $totalKPrice;

$totalKPrice += $totalAKawasan + $totalATransport;

$html .= '<tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">TAMBAHAN KAWASAN ' . ($rowAKawasan['Z_perc']??0) . '%</td>
            <td class="data bold alignright">' . number_format($totalAKawasan, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">TAMBAHAN PERATUSAN KESUKARAN LOGISTIK ' . ($AK_Tperc??0) . '%</td>
            <td class="data bold alignright">' . number_format($totalATransport, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">TOTAL</td>
            <td class="data bold alignright">' . number_format($totalKPrice, 2, '.', '') . '</td>
          </tr>
          <tr>
            <td colspan="9" style="border:none;"></td>
          </tr>';

$grandtotal = $totalKPrice + $totalEPrice;

$html .= '<tr>
            <td colspan="8" class="data bold alignright" style="background-color: #f2f2f2;">GRAND TOTAL (RM)</td>
            <td class="data bold alignright">' . number_format($grandtotal, 2, '.', '') . '</td>
          </tr>
            </table>';
            
$pdf->SetCellHeightRatio(1.3);
$html .= '<table>
        <tr>
            <td colspan="8"></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="8"><i>Thanks for the opportunity to provide this quotation. We hope that our quotation is favourable to you and looking forward to receiving your valued orders in due course. If you have any further questions, please do not hesitate to call us.</i><br><i>All payments must be made to <strong>AK MAJU RESOURCES SDN BHD (Maybank Account: 5510 5238 4209)</strong></i></td>
            <td></td>
          </tr>
        </table>';

$pdf->writeHTML($html, true, false, true, false, '');

$current_page = $pdf->getPage();
$bottom_margin = 30; // Adjust this margin as needed
$right_margin = 0;  // Adjust this margin as needed

// Get the remaining height on the current page
$remaining_height = $pdf->getPageHeight() - $pdf->GetY() - $bottom_margin;
$pdf->SetCellHeightRatio(1.5);
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

$file_location = "CQuotation/";

$file_name = $newCQId . '_' . $quotation . ".pdf";

ob_end_clean();


// Specify the absolute path to save the PDF
$absoluteFilePath = '/C:/xampp/htdocs/AKMaju/AKMaju/' . $file_location . $file_name;

// Output PDF to file and update the database
$pdf->Output($absoluteFilePath, 'F');

$updateQuery = "UPDATE tb_construction_quotation 
                SET CQ_path = '$file_location$file_name' 
                WHERE CQ_id = '$newCQId'";
$result = mysqli_query($con, $updateQuery); 


mysqli_close($con);

echo "<script>
        window.location.href='save_CEditorder.php?id=$fid&co_id=$quotation';
     </script>";
?>