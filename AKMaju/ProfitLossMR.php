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

    function Header1()
    {
        $option1 = '
    <table cellpadding="0" cellspacing="0" style="border:none; width:100%;">
        <tr>
            <td colspan="2">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <b>PROFIT AND LOSS</b>
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
        $this->writeHTML($option1, true, false, false, false, '');
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


$sql = "SELECT tb_ao_material.AM_id AS s_AMid,AM_name AS s_AMname, SUM(AOM_qty) AS s_AOMqty, AOM_unit AS s_AOMunit, SUM(AOM_totalcost) AS s_AOMcost, SUM(AOM_totalprice) AS s_AOMprice
        FROM tb_ao_material
        LEFT JOIN tb_advertisement_order ON tb_ao_material.O_id = tb_advertisement_order.O_id
        LEFT JOIN tb_advertisement_material ON tb_ao_material.AM_id = tb_advertisement_material.AM_id
        WHERE O_status = '1' AND MONTH(O_date) = $selected_month AND YEAR(O_date) = $selected_year
        GROUP BY s_AMid
        ORDER BY s_AOMqty DESC";

$result = mysqli_query($con, $sql);

$totalSales = calculateTotalSales($con, $selected_month, $selected_year);
$totalCost = calculateTotalCost($con, $selected_month, $selected_year);
$grossProfit = calculateGrossProfit($con, $selected_month, $selected_year);
[$productNamesJSON, $totalQuantitiesJSON] = calculateProductRanking($con, $selected_month, $selected_year);


$pdf->AddPage(); //default A4
//$pdf->AddPage('P','A5'); //when you require custome page size 
$pdf->Header();

$pdf->Header1();

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
    }

    .small-column {
        width: 30px;
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
<table>
    <tr>
        <th>MATERIAL ID</th>
        <th style="width: 170px">MATERIAL NAME</th>
        <th>COST (RM)</th>
        <th class="small-column"></th>
        <th>SALES (RM)</th>
    </tr>';

while ($row = mysqli_fetch_array($result)) {
    // Add the data to the table
    $html .= ' 
        <tr>
            <td class="aligncenter">' . $row['s_AMid'] . '</td>
            <td>' . $row['s_AMname'] . '</td>
            <td class="alignright">' . number_format($row['s_AOMcost'], 2, '.', '') . '</td>
            <td class="small-column"></td>
            <td class="alignright">' . number_format($row['s_AOMprice'], 2, '.', '') . '</td>
        </tr>';
}


// Add the total row to the table
$html .= '<tr>
            <td class="top bottom"><b>Total</b></td>
            <td class="top bottom"></td>
            <td class="top bottom alignright">' . number_format($totalCost, 2, '.', '') . '</td>
            <td class="small-column top bottom"></td>
            <td class="top bottom alignright">' . number_format($totalSales, 2, '.', '') . '</td>
        </tr>';
$html .= '</table>';

$html .= '<div style="height: 20px;"></div>';
$html .= '<table>
            <tr>
                <td></td>
                <td style="width: 95px";></td>
                <td class="top left alignright bold">Total Sales:</td>
                <td class="top small-column"></td>
                <td class="top right alignleft bold">RM ' . number_format($totalSales, 2, '.', '') . '</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="left alignright bold">Total Cost:</td>
                <td class="small-column"></td>
                <td class="right alignleft bold">RM ' . number_format($totalCost, 2, '.', '') . '</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="left bottom alignright bold">Gross Profit:</td>
                <td class="bottom small-column"></td>
                <td class="right bottom alignleft bold">RM ' . number_format($grossProfit, 2, '.', '') . '</td>
                <td></td>
                <td></td>
            </tr>';

$html .= '</table>';


$pdf->writeHTML($html, true, false, true, false, '');


$file_name = "MR_Profit_Loss" . $selected_year . $selected_month . ".pdf";

ob_end_clean();

if (isset($_GET['ACTION'])) {
    $action = $_GET['ACTION'];
    $pdf->Output($file_name, 'D'); // D means download
}