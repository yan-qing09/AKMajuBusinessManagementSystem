<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('dbconnect.php');
include('mr.php');
include_once('tcpdf_6_2_13/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = isset($_POST["email"]) ? $_POST["email"] : "";

    if (isset($_POST['selected_year']) && isset($_POST['selected_month'])) {
        $selected_year = $_POST['selected_year'];
        $selected_month = $_POST['selected_month'];
        // Now you can use $selected_year and $selected_month in your code
    } else {
        // Handle the case when parameters are not set, set default values or show an error message
        $selected_year = date('Y'); // Set the default year to the current year
        $selected_month = date('m'); // Set the default month to the current month
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve form data
    if (isset($_GET['YEAR']) && isset($_GET['MONTH'])) {
        $selected_year = $_GET['YEAR'];
        $selected_month = $_GET['MONTH'];
        // Now you can use $selected_year and $selected_month in your code
    } else {
        // Handle the case when parameters are not set, set default values or show an error message
        $selected_year = date('Y'); // Set the default year to the current year
        $selected_month = date('m'); // Set the default month to the current month
    }
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



$pdf->AddPage(); //default A4
//$pdf->AddPage('P','A5'); //when you require custome page size 
$pdf->Header();

$pdf->Header1();

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
    .page-break {
        page-break-before: always;
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


$pdf->AddPage();

$pdf->Header();

$pdf->Header2();

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

[$customerIdsJSON, $customerNamesJSON, $totalSpentAmountsJSON] = calculateTopSpender($con, $selected_month, $selected_year);
$customerNames = json_decode($customerNamesJSON);
$totalSpentAmounts = json_decode($totalSpentAmountsJSON);
$totalOrders = calculateTotalOrders($con, $selected_month, $selected_year);
$prevCustomerId = null;
$totalAmount = 0;

while ($row = mysqli_fetch_array($result_c)) {
    // Check if the customer has changed
    if ($row['c_cid'] !== $prevCustomerId) {
        // Output total amount for the previous customer
        if ($prevCustomerId !== null) {
            $html .= '<tr>
                        <td colspan="4" class="alignright bold">Total</td>
                        <td class="total" class="alignright top bottom">' . number_format($totalAmount, 2) . '</td>
                      </tr>';
            $totalAmount = 0; // Reset total amount for the new customer
        }

        // Output a row for the new customer
        $numOrders = getNumberOfOrders($con, $row['c_cid'], $selected_year, $selected_month);
        $html .= '<tr>
                    <td rowspan="' . $numOrders . '" class="alignleft">' . $row['c_name'] . '</td>
                    <td>' . ($row['c_AOid'] ? $row['c_AOid'] : '-') . '</td>
                    <td>' . ($row['c_description'] ? $row['c_description'] : '-') . '</td>
                    <td>' . ($row['c_AOpayDate'] ? $row['c_AOpayDate'] : '-') . '</td>
                    <td class="alignright">' . ($row['c_totalPrice'] ? $row['c_totalPrice'] : '0.00') . '</td>
                  </tr>';
        $totalAmount += floatval($row['c_totalPrice']); // Accumulate the total amount for the current customer
        $prevCustomerId = $row['c_cid'];
    } else {
        // Output rows for additional orders by the same customer
        $html .= '<tr>
                    <td>' . ($row['c_AOid'] ? $row['c_AOid'] : '-') . '</td>
                    <td>' . ($row['c_description'] ? $row['c_description'] : '-') . '</td>
                    <td>' . ($row['c_AOpayDate'] ? $row['c_AOpayDate'] : '-') . '</td>
                    <td class="alignright">' . ($row['c_totalPrice'] ? $row['c_totalPrice'] : '0.00') . '</td>
                  </tr>';
        $totalAmount += floatval($row['c_totalPrice']); // Accumulate the total amount for the current customer
    }
}

// Output total amount for the last customer
if ($prevCustomerId !== null) {
    $html .= '<tr>
                <td colspan="4" class="alignright bold">Total</td>
                <td class="total" class="alignright top bottom">' . number_format($totalAmount, 2) . '</td>
              </tr>';
}

$html .= '<tr>
            <td class="small bottom"></td>
            <td class="small bottom"></td>
            <td class="small bottom"></td>
            <td class="small bottom"></td>
            <td class="small bottom"></td>
          </tr>
          </table>';
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


$pdf->AddPage();

$pdf->Header();

$pdf->Header3();

$sql_material = "SELECT AM_id AS i_AMid, AM_name AS i_AMname 
                 FROM tb_advertisement_material";

$result_material = mysqli_query($con, $sql_material);


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

$file_location = "C:/xampp/htdocs/AKMaju/AKMaju/MonthlyReport/";

$file_name = "MR_" . $selected_year . $selected_month . ".pdf";

ob_end_clean();

if (isset($_GET['ACTION'])) {
    $action = $_GET['ACTION'];
    $pdf->Output($file_name, 'D'); // D means download
}

if (isset($_POST['ACTION'])) {
    $action = $_POST['ACTION'];
    
    //required files
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $pdf->Output($file_location . $file_name, 'F');

    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'chuqingruoyun99@gmail.com';   //SMTP write your email
    $mail->Password   = 'zhngxzjpcgzpjssv';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom($_POST["email"], 'AK MAJU'); // Sender Email and name
    $mail->addAddress($_POST["email"]);     //Add a recipient email  
    $mail->addReplyTo($_POST["email"]); // reply to sender email

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = "Monthly Report";   // email subject headings
    $mail->Body    = "Here is the monthly report for you."; //email message
    $mail->AddAttachment($file_location . $file_name);

    // Success sent message alert
    $mail->send();
    $mail->SmtpClose();
    if ($mail->IsError()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    };
}


mysqli_close($con);
?>