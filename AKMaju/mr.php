<?php
include ('dbconnect.php');

// Retrieve total orders
function calculateTotalOrders($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT COUNT(O_id) as total_orders 
            FROM tb_advertisement_order
            WHERE tb_advertisement_order.O_status = 1 
            AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($row && isset($row['total_orders'])) {
            return $row['total_orders'];
        }

    return 0;
}

// Retrieve total products sold
function calculateSoldQty($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT SUM(AOM_qty) AS total_quantity_sold
            FROM tb_ao_material
            LEFT JOIN tb_advertisement_order ON tb_ao_material.O_id = tb_advertisement_order.O_id
            WHERE tb_advertisement_order.O_status = 1 
            AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($row && isset($row['total_quantity_sold'])) {
            return $row['total_quantity_sold'];
        }

    return 0;
}

// Retrieve total sales
function calculateTotalSales($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT SUM(O_totalPrice) as total_sales 
            FROM tb_advertisement_order
            WHERE O_status = 1 AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($row && isset($row['total_sales'])) {
            return $row['total_sales'];
        }

    return '0.00';
}

// Retrieve total cost
function calculateTotalCost($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT SUM(O_totalCost) as total_cost 
            FROM tb_advertisement_order
            WHERE O_status = 1 AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    return $row['total_cost'];

}

// Retrieve gross profit
function calculateGrossProfit($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT SUM(O_totalPrice - O_totalCost) as gross_profit
            FROM tb_advertisement_order 
            WHERE O_status = 1 AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($row && isset($row['gross_profit'])) {
            return $row['gross_profit'];
        }

    return '0.00';
}

function calculateProductRanking($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT tb_ao_material.AM_id, SUM(AOM_qty) AS total_quantity_sold, AM_name 
            FROM tb_ao_material
            LEFT JOIN tb_advertisement_order ON tb_ao_material.O_id = tb_advertisement_order.O_id
            LEFT JOIN tb_advertisement_material ON tb_ao_material.AM_id = tb_advertisement_material.AM_id
            WHERE tb_advertisement_order.O_status = 1 
            AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear
            GROUP BY AM_id 
            ORDER BY total_quantity_sold DESC
            LIMIT 5";

    $result = mysqli_query($con, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        // Return null if there is no data
        return null;
    }

    $productNames = [];
    $totalQuantities = [];

    while ($rowProductRanking = mysqli_fetch_array($result)) {
        $productNames[] = (string)$rowProductRanking['AM_name'];
        $totalQuantities[] = $rowProductRanking['total_quantity_sold'];
    }

    // Convert arrays to JSON for use in JavaScript
    $productNamesJSON = json_encode($productNames);
    $totalQuantitiesJSON = json_encode($totalQuantities);

    return [$productNamesJSON, $totalQuantitiesJSON];
}

function calculateTopSpender($con, $selectedMonth, $selectedYear)
{
    $sql = "SELECT tb_advertisement_order.C_id, SUM(O_totalPrice) AS total_spent, C_name 
            FROM tb_advertisement_order
            LEFT JOIN tb_customer ON tb_advertisement_order.C_id = tb_customer.C_id
            WHERE tb_advertisement_order.O_status = 1
            AND MONTH(O_date) = $selectedMonth AND YEAR(O_date) = $selectedYear 
            GROUP BY C_id, C_name 
            ORDER BY total_spent DESC 
            LIMIT 3";

    $result = mysqli_query($con, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        // Return null if there is no data
        return null;
    }

    // Arrays to store data for the chart
    $customerIds = [];
    $customerNames = [];
    $totalSpentAmounts = [];

    while ($rowTopSpender = mysqli_fetch_array($result)) {
        $customerIds[] = (string)$rowTopSpender['C_id'];
        $customerNames[] = (string)$rowTopSpender['C_name'];
        $totalSpentAmounts[] = $rowTopSpender['total_spent'];
    }

    // Convert arrays to JSON for use in JavaScript
    $customerIdsJSON = json_encode($customerIds);
    $customerNamesJSON = json_encode($customerNames);
    $totalSpentAmountsJSON = json_encode($totalSpentAmounts);


    return [$customerIdsJSON, $customerNamesJSON, $totalSpentAmountsJSON];
}

function calculateOpeningStock($con, $materialId, $selectedYear, $selectedMonth)
{
    // If the selected month is January, adjust the year and month for the previous month
    if ($selectedMonth == 1) {
        $previousMonth = 12;
        $previousYear = $selectedYear - 1;
    } 
    else {
        $previousMonth = $selectedMonth - 1;
        $previousYear = $selectedYear;
    }

    $sql = "SELECT COALESCE(AMH_unsoldQty, 0) AS opening_stock
            FROM tb_advertisement_adjustment
            WHERE AM_id = '$materialId' 
                AND MONTH(AMH_date) = $previousMonth 
                AND YEAR(AMH_date) = $previousYear
            ORDER BY AMH_date DESC
            LIMIT 1";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['opening_stock'];
    } else {
        // No rows found, return 0 as default
        return 0;
    }
}

function calculateStockReceived($con, $materialId, $selectedYear, $selectedMonth)
{
    $sql = "SELECT *
            FROM tb_advertisement_adjustment
            LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AM_id = tb_advertisement_material.AM_id
            WHERE tb_advertisement_material.AM_id = '$materialId'
            AND MONTH(tb_advertisement_adjustment.AMH_date) = $selectedMonth
            AND YEAR(tb_advertisement_adjustment.AMH_date) = $selectedYear
            ORDER BY tb_advertisement_adjustment.AMH_date DESC";

    $result = mysqli_query($con, $sql);

    $stockReceived = 0;

    while ($row = mysqli_fetch_array($result)) 
    {
        $prevSql = "SELECT AMH_unsoldQty AS prevUnsoldQty
                    FROM tb_advertisement_adjustment
                    LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AM_id = tb_advertisement_material.AM_id
                    WHERE tb_advertisement_material.AM_id = '$materialId'
                    AND tb_advertisement_adjustment.AMH_date < '{$row['AMH_date']}'
                    ORDER BY tb_advertisement_adjustment.AMH_date DESC
                    LIMIT 1";

        $prevResult = mysqli_query($con, $prevSql);
        $prevRow = mysqli_fetch_array($prevResult);

        $prevUnsoldQty = 0;

        if ($prevRow !== false && isset($prevRow['prevUnsoldQty'])) {
            $prevUnsoldQty = $prevRow['prevUnsoldQty'];
        }

        $unsoldChange = $row['AMH_unsoldQty'] - $prevUnsoldQty;

        if ($unsoldChange > 0) {
            $stockReceived += $unsoldChange;
        }
    }   

    return $stockReceived;
}

function calculateStockSold($con, $materialId, $selectedYear, $selectedMonth)
{
    $sql = "SELECT *
            FROM tb_advertisement_adjustment
            LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AM_id = tb_advertisement_material.AM_id
            WHERE tb_advertisement_material.AM_id = '$materialId'
            AND MONTH(tb_advertisement_adjustment.AMH_date) = $selectedMonth
            AND YEAR(tb_advertisement_adjustment.AMH_date) = $selectedYear
            ORDER BY tb_advertisement_adjustment.AMH_date DESC";

    $result = mysqli_query($con, $sql);

    $stockSold = 0;

    while ($row = mysqli_fetch_array($result)) 
    {
        $prevSql = "SELECT AMH_soldQty AS prevSoldQty
                    FROM tb_advertisement_adjustment
                    LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AM_id = tb_advertisement_material.AM_id
                    WHERE tb_advertisement_material.AM_id = '$materialId'
                    AND tb_advertisement_adjustment.AMH_date < '{$row['AMH_date']}'
                    ORDER BY tb_advertisement_adjustment.AMH_date DESC
                    LIMIT 1";

        $prevResult = mysqli_query($con, $prevSql);
        $prevRow = mysqli_fetch_array($prevResult);

        $prevSoldQty = 0;

        if($prevRow !== null)
        {
            $prevSoldQty = $prevRow['prevSoldQty'];
        }

        $soldChange = $row['AMH_soldQty'] - $prevSoldQty;

        if ($soldChange > 0) {
            $stockSold += $soldChange;
        }
    }   

    return $stockSold;
}

function calculateClosingStock($con, $materialId, $selectedYear, $selectedMonth)
{
    $sql = "SELECT COALESCE(AMH_unsoldQty, 0) AS closing_stock
            FROM tb_advertisement_adjustment
            WHERE AM_id = '$materialId' 
                AND MONTH(AMH_date) = $selectedMonth 
                AND YEAR(AMH_date) = $selectedYear
            ORDER BY AMH_date DESC
            LIMIT 1";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['closing_stock'];
}

function getNumberOfOrders($con, $customerId, $selectedYear, $selectedMonth) {
    $sql = "SELECT COUNT(*) AS numOrders
            FROM tb_advertisement_order
            WHERE C_id = '$customerId'
                AND O_status = '1'
                AND MONTH(O_date) = $selectedMonth
                AND YEAR(O_date) = $selectedYear";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['numOrders'];
}

function calculateUnpaidOrders($con) {
    $sql = "SELECT COUNT(*) AS unpaidOrders
            FROM tb_advertisement_order
            WHERE AO_paymentStatus = '6' || AO_paymentStatus = '7'
                AND O_status = '2'";   

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['unpaidOrders'];
}

function calculateUndeliveredOrders($con) {
    $sql = "SELECT COUNT(*) AS undeliveredOrders
            FROM tb_advertisement_order
            WHERE AO_paymentStatus = '7'";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['undeliveredOrders'];
}

function calculatePendingApprove($con) {
    $sql = "SELECT
            (SELECT COUNT(*) FROM tb_advertisement_quotation WHERE AQ_status IN (11)) AS pendingAQ,
            (SELECT COUNT(*) FROM tb_construction_quotation WHERE CQ_status IN (11)) AS pendingCQ,
            (SELECT COUNT(*) FROM tb_invoice WHERE I_status IN (11, 12)) AS pendingI,
            (SELECT COUNT(*) FROM tb_delivery_order WHERE DO_status IN (11)) AS pendingDO";

$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    $pendingAQ = $row['pendingAQ'];
    $pendingCQ = $row['pendingCQ'];
    $pendingInvoice = $row['pendingI'];
    $pendingDO = $row['pendingDO'];
}

$totalpending = $pendingAQ + $pendingCQ + $pendingInvoice + $pendingDO;    

    return $totalpending;
}

function calculateCompletedOrders($con) {
    $sql = "SELECT COUNT(*) AS completedOrders
            FROM tb_advertisement_order
            WHERE O_status = '1'";

    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['completedOrders'];
}

?>