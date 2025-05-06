<?php

include('dbconnect.php');
include('mr.php');
include_once('tcpdf_6_2_13/tcpdf.php');


if (isset($_GET['YEAR']) && isset($_GET['MONTH'])) {
        $selected_year = $_GET['YEAR'];
        $selected_month = $_GET['MONTH'];
        // Now you can use $selected_year and $selected_month in your code
} 
else {
        // Handle the case when parameters are not set, set default values or show an error message
        $selected_year = date('Y'); // Set the default year to the current year
        $selected_month = date('m'); // Set the default month to the current month
}

class PDF extends TCPDF
{
    function Header()
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
        $this->SetCellHeightRatio(0.8);
        $this->SetXY(13, 13);
        $this->writeHTML($companyInfo, true, false, false, false, '');
    }

    function Header3()
    {
        $option3 = '
    <table cellpadding="0" cellspacing="0" style="border:none; width:100%;">
        <tr>
            <td colspan="2">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <b>STOCK BALANCE</b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
        </tr>
    </table>';

        $this->SetCellPaddings(0, 0, 0, 0);
        $this->SetCellHeightRatio(0.8);
        $this->SetXY(10, 43);
        $this->writeHTML($option3, true, false, false, false, '');
    }
}

//----- Code for generate pdf
$pdf = new PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
$pdf->SetHeaderData('', '', 'Sales Monthly Report', '');
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont('helvetica');
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetMargins('13', '13', '10');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 12);

$sql_material = "SELECT AM_id AS i_AMid, AM_name AS i_AMname 
                 FROM tb_advertisement_material";

$result_material = mysqli_query($con, $sql_material);

$pdf->AddPage();

$pdf->Header();

$pdf->Header3();

   // Reset cell height settings
$pdf->SetCellPaddings(1, 1, 1, 1);
$pdf->SetCellHeightRatio(1.5);

// Create line above the header
$lineYPosition = 53; // Adjust this value to set the line higher or lower
$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));
$pdf->Line(10, $lineYPosition, 200, $lineYPosition);
$pdf->SetXY(13, 56);

// Create table header
$html = '<style type="text/css">
            th {
                font-size: 10px;
                font-weight: bold;
                line-height: 24px;
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                color: #000;
                text-align: center;
                background-color: #f2f2f2;
                border-bottom: 1px solid black;
            }

            td {
                font-size: 10px;
                line-height: 24px;
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                color: #000;
                text-align: center;
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

            .small-column {
                width: 30px;
            }

            .small {
                line-height:1px;
            }

            .bold {
                font-weight: bold;
            }
        </style> 
<table>
    <tr>
        <th style="width: 40px">ID</th>
        <th style="width: 110px">DESCRIPTION</th>
        <th style="width: 96px">OPENING STOCK</th>
        <th style="width: 100px">STOCK RECEIVED</th>
        <th style="width: 76px">STOCK SOLD</th>
        <th style="width: 95px">CLOSING STOCK</th>
    </tr>';

$totalQuantitySold = calculateSoldQty($con, $selected_month, $selected_year);
[$productNamesJSON, $totalQuantitiesJSON] = calculateProductRanking($con, $selected_month, $selected_year);
$productNames = json_decode($productNamesJSON);
$totalQuantities = json_decode($totalQuantitiesJSON);


// Check if there are any materials
if (mysqli_num_rows($result_material) > 0) {
    $rowCount = 0;
    while ($row_material = mysqli_fetch_array($result_material)) {
        $materialId = $row_material['i_AMid'];
        $materialName = $row_material['i_AMname'];

        $openingStock = calculateOpeningStock($con, $materialId, $selected_year, $selected_month) ?? 0;
        $stockReceived = calculateStockReceived($con, $materialId, $selected_year, $selected_month) ?? 0;
        $stockSold = calculateStockSold($con, $materialId, $selected_year, $selected_month) ?? 0;
        $closingStock = calculateClosingStock($con, $materialId, $selected_year, $selected_month) ?? 0;

        $html .= ' 
    <tr>
        <td>' . $materialId . '</td>
        <td>' . $materialName . '</td>
        <td>' . $openingStock . '</td>
        <td>' . $stockReceived . '</td>
        <td>' . $stockSold . '</td>
        <td>' . $closingStock . '</td>
    </tr>';
    }
}

$html .= '<tr>
            <td class="small top"></td>
            <td class="small top"></td>
            <td class="small top"></td>
            <td class="small top"></td>
            <td class="small top"></td>
            <td class="small top"></td>
          </tr>
          </table>';
$html .= '<div style="height: 20px;"></div>';


$html .= '<table>
            <tr>
                <td style="width: 110px;"></td>
                <td class="top left alignright bold" style="width: 110px;">Total Products Sold:</td>
                <td class="top small-column bold">' . $totalQuantitySold . '</td>
                <td class="top alignleft"></td>
                <td class="top right" style="width: 50px;"></td>
            </tr>
            <tr>
                <td></td>
                <td rowspan="' . count($productNames) . '" class="left alignright bold">Top Selling Products:</td>
                <td>1</td>
                <td>' . $productNames[0] . '</td>
                <td class="right">' . $totalQuantities[0] . '</td>
            </tr>';

for ($i = 1; $i < count($productNames); $i++) {
    $rank = $i + 1;
    $productName = $productNames[$i];
    $totalQuantity = $totalQuantities[$i];

    $html .= '<tr>
                <td></td>
                <td>' . $rank . '</td>
                <td>' . $productName . '</td>
                <td class="right">' . $totalQuantity . '</td>
              </tr>';
}

$html .= '<tr>
            <td></td>
            <td class="small top"></td>
            <td class="small top"></td>
            <td class="small top"></td>
            <td class="top"></td>
          </tr>
        </table>';


$pdf->writeHTML($html, true, false, true, false, '');

$file_name = "MR_Stock_Balance" . $selected_year . $selected_month . ".pdf";

ob_end_clean();

if (isset($_GET['ACTION'])) {
    $action = $_GET['ACTION'];
    $pdf->Output($file_name, 'D'); // D means download
}