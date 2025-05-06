<?php
include 'dbconnect.php';

$rangedate = !empty($_GET['rangedate']) ? $_GET['rangedate'] : 0;
$datefrom = !empty($_GET['datefrom']) ? $_GET['datefrom'] : null;
$dateto = !empty($_GET['dateto']) ? $_GET['dateto'] : null;

// Set the default time zone (you may need to change this based on your requirements)
date_default_timezone_set('UTC');

if ($rangedate == '0') {
    // Calculate from datefrom to dateto
    $startDate = date('Y-m-d', strtotime($datefrom));
    $endDate = date('Y-m-d', strtotime($dateto));
} else {
    // Calculate date range based on the selected option
    $endDate = date('Y-m-d'); // Current date

    if ($rangedate == '1') {
        // Last month
        $startDate = date('Y-m-d', strtotime('-1 month', strtotime($endDate)));
    } else if ($rangedate == '3') {
        // Last three months
        $startDate = date('Y-m-d', strtotime('-3 months', strtotime($endDate)));
    } else if ($rangedate == '6') {
        // Last six months
        $startDate = date('Y-m-d', strtotime('-6 months', strtotime($endDate)));
    } else if ($rangedate == '12') {
        // Last twelve months
        $startDate = date('Y-m-d', strtotime('-12 months', strtotime($endDate)));
    }
}

// Filter the excel data
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

// Excel file name for download 
$fileName = "customers-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID', 'NAME', 'TYPE', 'EMAIL', 'STREET', 'CITY', 'POSTCODE', 'STATE'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = "SELECT * FROM tb_customer AS c
          LEFT JOIN tb_advertisement_order AS ao ON ao.C_id = c.C_id
          WHERE O_date BETWEEN '$startDate' AND '$endDate'
          ORDER BY c.C_id ASC";

$result = $con->query($query);
if($result->num_rows > 0){ 
    // Output each row of the data 
    while($row = $result->fetch_assoc()){ 
        $lineData = array($row['C_id'], $row['C_name'], $row['C_type'], $row['C_email'], $row['C_street'], $row['C_city'], $row['C_postcode'], $row['C_state']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 

// Separator or header for the second data set
$excelData .= "\nConstruction Orders Data:\n";

// Fetch records from database 
$query2 = "SELECT * FROM tb_customer AS c
          LEFT JOIN tb_construction_order AS co ON co.C_id = c.C_id
          WHERE O_date BETWEEN '$startDate' AND '$endDate'
          ORDER BY c.C_id ASC";

$result2 = $con->query($query2);
if($result2->num_rows > 0){ 
    // Output each row of the data 
    while($rows = $result2->fetch_assoc()){ 
        $lineData2 = array($rows['C_id'], $rows['C_name'], $rows['C_type'], $rows['C_email'], $rows['C_street'], $rows['C_city'], $rows['C_postcode'], $rows['C_state']); 
        array_walk($lineData2, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData2)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;
?>