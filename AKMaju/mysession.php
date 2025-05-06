<?php
if (!session_id()) {
    session_start();
}

if (isset($_SESSION['U_id']) != session_id()) {
    header('Location:index.php');
}

// Include dbconnect.php to ensure the database connection is available
include('dbconnect.php');

$sql = "SELECT COUNT(*) AS low_stock_count FROM tb_advertisement_material 
        WHERE LS_status='Low'
        AND is_archived=0";
$result = $con->query($sql);

$row = $result->fetch_assoc();
$currentLowStockCount = $row['low_stock_count'];

// Get the previous count from the session
$previousLowStockCount = isset($_SESSION['previous_low_stock_count']) ? $_SESSION['previous_low_stock_count'] : 0;
$message = '';

// Compare current count with previous count
if ($currentLowStockCount != $previousLowStockCount && $currentLowStockCount > 0) {
    $message = "" . $currentLowStockCount . " advertisement materials are running out of stock.";
    $_SESSION['previous_low_stock_count'] = $currentLowStockCount;
}
?>
