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

    function Header2()
    {
        $option2 = '
    <table cellpadding="0" cellspacing="0" style="border:none; width:100%;">
        <tr>
            <td colspan="2">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <b>TRANSACTION LISTING</b>
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
        $this->writeHTML($option2, true, false, false, false, '');
    }

    public function Footer() {
        // Set content
        $rightContent = "\t\t\t\t" . $this->getAliasNumPage();

        // Calculate the width of the right content
        $rightContentWidth = $this->GetStringWidth($rightContent);

        // Set up the table
        $this->SetY(-15);
        $this->SetX($this->GetPageWidth() - $rightContentWidth);
        $this->Cell($rightContentWidth, 10, $rightContent, 0, 'R');
    }
}

$sql_c = "SELECT O_id AS c_AOid, O_remark AS c_description, O_totalPrice AS c_totalPrice, tb_advertisement_order.C_id AS c_cid, c_name, AO_payDate AS c_AOpayDate,
        (
            SELECT SUM(O_totalPrice) 
            FROM tb_advertisement_order 
            WHERE tb_advertisement_order.C_id = tb_customer.C_id
                AND O_status = '1'
                AND MONTH(O_date) = $selected_month
                AND YEAR(O_date) = $selected_year
        ) AS c_totalPurchase
        FROM tb_advertisement_order
        INNER JOIN tb_customer ON tb_customer.C_id = tb_advertisement_order.C_id
        WHERE tb_advertisement_order.O_status = '1' 
              AND MONTH(tb_advertisement_order.O_date) = $selected_month 
              AND YEAR(tb_advertisement_order.O_date) = $selected_year
        ORDER BY c_totalPurchase DESC";

$result_c = mysqli_query($con, $sql_c);


[$customerIdsJSON, $customerNamesJSON, $totalSpentAmountsJSON] = calculateTopSpender($con, $selected_month, $selected_year);
$customerNames = json_decode($customerNamesJSON);
$totalSpentAmounts = json_decode($totalSpentAmountsJSON);
$totalOrders = calculateTotalOrders($con, $selected_month, $selected_year);

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
$pdf->setPrintFooter(true);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->SetFont('helvetica', '', 12);

$pdf->AddPage();

$pdf->Header();

$pdf->Header2();

// Reset cell height settings
$pdf->SetCellPaddings(1, 1, 1, 1);
$pdf->SetCellHeightRatio(1.5);
$pdf->SetXY(13, 56);

// Create line above the header
$lineYPosition = 53; // Adjust this value to set the line higher or lower
$pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));
$pdf->Line(10, $lineYPosition, 200, $lineYPosition);

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

    .small {
        line-height: 5px;
    }

    .small-column {
        width: 30px;
    }

    .bold {
        font-weight: bold;
    }

</style> 
<table>
    <tr>
        <th style="width: 120px">CUSTOMER NAME</th>
        <th style="width: 60px">ORDER NO.</th>
        <th style="width: 130px">DESCRIPTION</th>
        <th style="width: 110px">TRANSACTION DATE</th>
        <th style="width: 100px">AMOUNT (RM)</th>
    </tr>';

$prevCustomerId = null;
$totalAmount = 0;
$ordersCount = 0;

while ($row = mysqli_fetch_array($result_c)) {
    // Check if the customer has changed
    if ($row['c_cid'] !== $prevCustomerId) {
        // Output rows for additional orders by the same customer
        if ($prevCustomerId !== null) {
            $html .= '<tr>
                        <td colspan="4" class="alignright bold">Total</td>
                        <td class="total alignright top bottom">' . number_format($totalAmount, 2) . '</td>
                      </tr>';
            $totalAmount = 0; // Reset total amount for the new customer
            $ordersCount = 0; // Reset order count
        }

        // Output a row for the new customer
        $html .= '<tr>
                    <td class="alignleft">' . $row['c_name'] . '</td>
                    <td>' . ($row['c_AOid'] ? $row['c_AOid'] : '-') . '</td>
                    <td>' . ($row['c_description'] ? $row['c_description'] : '-') . '</td>
                    <td>' . ($row['c_AOpayDate'] ? $row['c_AOpayDate'] : '-') . '</td>
                    <td class="alignright">' . ($row['c_totalPrice'] ? $row['c_totalPrice'] : '0.00') . '</td>
                  </tr>';
        $totalAmount += floatval($row['c_totalPrice']); // Accumulate the total amount for the current customer
        $ordersCount++;
        $prevCustomerId = $row['c_cid'];
    } else {
        // Output rows for additional orders by the same customer
        $html .= '<tr>
                    <td style="width: 120px"></td>
                    <td>' . ($row['c_AOid'] ? $row['c_AOid'] : '-') . '</td>
                    <td>' . ($row['c_description'] ? $row['c_description'] : '-') . '</td>
                    <td>' . ($row['c_AOpayDate'] ? $row['c_AOpayDate'] : '-') . '</td>
                    <td class="alignright">' . ($row['c_totalPrice'] ? $row['c_totalPrice'] : '0.00') . '</td>
                  </tr>';
        $totalAmount += floatval($row['c_totalPrice']); // Accumulate the total amount for the current customer
        $ordersCount++;
    }
}

// Output total amount for the last customer
if ($prevCustomerId !== null) {
    $html .= '<tr>
                <td colspan="4" class="alignright bold">Total</td>
                <td class="total alignright top bottom">' . number_format($totalAmount, 2) . '</td>
              </tr>';
}

$html .= '</table>';
$html .= '<div style="height: 20px;"></div>';

$html .= '<table>
            <tr>
                <td style="width: 95px;"></td>
                <td class="top left alignright bold" style="width: 90px;">Total Orders:</td>
                <td class="top small-column bold">' . $totalOrders . '</td>
                <td class="top alignleft"></td>
                <td class="top right"></td>
            </tr>
            <tr>
                <td></td>
                <td rowspan="' . count($customerNames) . '" class="left alignright bold">Top 3 Spenders:</td>
                <td>1</td>
                <td>' . $customerNames[0] . '</td>
                <td class="right">RM ' . number_format($totalSpentAmounts[0], 2) . '</td>
            </tr>';

for ($i = 1; $i < count($customerNames); $i++) {
    $rank = $i + 1;
    $customerName = $customerNames[$i];
    $totalSpentAmount = number_format($totalSpentAmounts[$i], 2);

    $html .= '<tr>
                <td></td>
                <td>' . $rank . '</td>
                <td>' . $customerName . '</td>
                <td class="right">RM ' . $totalSpentAmount . '</td>
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

$file_name = "MR_Transaction_Listing" . $selected_year . $selected_month . ".pdf";

ob_end_clean();

if (isset($_GET['ACTION'])) {
    $action = $_GET['ACTION'];
    $pdf->Output($file_name, 'D'); // D means download
}