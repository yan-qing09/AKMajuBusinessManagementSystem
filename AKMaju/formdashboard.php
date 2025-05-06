<?php
include('dbconnect.php');
include('mysession.php');
include('mr.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected year and month values from the form
    $selected_year = isset($_POST["selected_year"]) ? $_POST["selected_year"] : date('Y');
    $selected_month = isset($_POST["selected_month"]) ? $_POST["selected_month"] : date('m');
} else {
    // Set default values if the form is not submitted
    $selected_year = date('Y');
    $selected_month = date('m');
}
?>

<?php
// Example usage
$totalOrders = calculateTotalOrders($con, $selected_month, $selected_year);
$totalQuantitySold = calculateSoldQty($con, $selected_month, $selected_year);
$totalSales = calculateTotalSales($con, $selected_month, $selected_year);
$grossProfit = calculateGrossProfit($con, $selected_month, $selected_year);
[$productNamesJSON, $totalQuantitiesJSON] = calculateProductRanking($con, $selected_month, $selected_year);
[$customerIdsJSON, $customerNamesJSON, $totalSpentAmountsJSON] = calculateTopSpender($con, $selected_month, $selected_year);


//Retrieve adjusted items
$sql_adjusted = "SELECT * FROM tb_advertisement_adjustment
                 LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AJ_id = tb_advertisement_material.AM_id
                 ORDER BY AJ_adjustedDate DESC";

//Execute
$result = mysqli_query($con, $sql_adjusted);


//Retrieve low stock items
$sql_lowstock = "SELECT *
                 FROM tb_advertisement_material
                 WHERE LS_status = 'Low'";

//Execute
$result1 = mysqli_query($con, $sql_lowstock);

$fid = $_GET['id'];
$sqls = "SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con, $sqls);
$rows = mysqli_fetch_array($result3);

include('headerdashboard.php');
?>

<body id="page-top">
    <!-- side nav bar -->
    <div id="wrapper">
        <?php include('navbar.php'); ?>


        <!-- top nav bar -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Dashboard</h3>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1"></li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown">
                                </div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <?php echo "<div class='nav-item dropdown no-arrow'><a class='dropdown-toggle nav-link' aria-expanded='false' data-bs-toggle='dropdown' href='#''><span class='d-none d-lg-inline me-2 text-gray-600 small'>" . $rows['U_id'] . "<br>" . $rows['U_name'] . "</span></a>" ?>
                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                    </div>
                    </li>
                    </ul>
            </div>
            </nav>
            <div class="row">
                <div class="col">
                    <div class="container-fluid">
                        <?php
                        echo "<form method='post' id='filterForm' action='admindashboard.php?id=" . $rows['U_id'] . "'>"
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="d-sm-flex justify-content-between align-items-center mb-4" style="text-align: left;">
                                    <div class="row" style="width: 100%; margin-right: -20px;">

                                        <!-- Year Dropdown -->
                                        <div class="col-md-3 col-lg-2 col-xl-1 col-xxl-1 mb-4">
                                            <div class="input-group" style="width: 90px;">
                                                <select class="border rounded border-2 shadow-sm form-select" name="selected_year" id="selected_year" onchange="submitForm()" style="width: 100%; height: 37.6px; color: var(--bs-body-color); margin-right: 4px;padding-right: 12px;position: relative;">
                                                    <?php
                                                    $sql_y = "SELECT DISTINCT YEAR(AO_date) AS year 
                                                          FROM tb_advertisement_order 
                                                          ORDER BY AO_date DESC";

                                                    $resulty = mysqli_query($con, $sql_y);

                                                    while ($row = mysqli_fetch_array($resulty)) {
                                                        $year = $row['year'];
                                                        $selected = ($year == $selected_year) ? 'selected' : ''; // Check if the year is the selected year
                                                        echo "<option value='$year' $selected>$year</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Month Dropdown -->
                                        <div class="col-md-9 col-lg-4 col-xl-2 col-xxl-2 mb-4">
                                            <div class="input-group" style="width: 90px;">
                                                <select class="border rounded border-2 shadow-sm form-select" name="selected_month" id="selected_month" onchange="submitForm()" style="width: 100%; height: 37.6px; color: var(--bs-body-color); padding-left: 8px;margin-left: 0px;text-align: left;">
                                                    <?php
                                                    $monthAbbreviations = [
                                                        1 => 'JAN',
                                                        2 => 'FEB',
                                                        3 => 'MAR',
                                                        4 => 'APR',
                                                        5 => 'MAY',
                                                        6 => 'JUN',
                                                        7 => 'JUL',
                                                        8 => 'AUG',
                                                        9 => 'SEP',
                                                        10 => 'OCT',
                                                        11 => 'NOV',
                                                        12 => 'DEC'
                                                    ];

                                                    $sql_month = "SELECT DISTINCT MONTH(AO_date) AS month 
                                                                  FROM tb_advertisement_order 
                                                                  ORDER BY AO_date DESC";
                                                    $result_month = mysqli_query($con, $sql_month);

                                                    while ($row_month = mysqli_fetch_array($result_month)) {
                                                        $monthNumber = $row_month['month'];
                                                        $selected1 = ($monthNumber == $selected_month) ? 'selected' : ''; // Check if the month is the current month
                                                        $monthAbbreviation = $monthAbbreviations[$monthNumber];
                                                        echo "<option value='$monthNumber' $selected1>$monthAbbreviation</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xl-4 col-xxl-2 mb-4">
                                            <a href="#" class="btn btn-primary bg-primary float-start justify-content-start align-items-start align-content-start;" id="emailPdfButton" style="font-size: 14px; text-align: center; font-weight: bold;height: 37.6px;padding-right: 6px;"><i class="fa fa-send" style="color: white; margin-right: 5px;margin-left: -2px; padding-top: 6px";></i></a>
                                        </div>

                                        <div class="w-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="row">
                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-primary py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span style="display: block;"><b>TOTAL ORDERS</b></span><span><b>(monthly)</b></span></div>
                                                <div class="text-dark fw-bold h5 mb-0">
                                                    <span>
                                                        <?php
                                                        echo $totalOrders;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-shopping-cart fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                    <footer class="bg-primary-subtle" style="margin-bottom: -7px;border-radius: 5.6px;border-top-left-radius: 0px;"><span class="text-primary-emphasis" style="display: block;font-size: 13.2px;margin: 0px;margin-left: 17px;margin-right: 17px;">Transaction Listing Report<a href="TransactionListingMR.php?YEAR=<?php echo urlencode($selected_year); ?>&MONTH=<?php echo urlencode($selected_month); ?>&ACTION=DOWNLOAD" class="btn btn-primary btn-sm bg-primary bg-opacity-75 float-end" type="button" style="margin-right: -17px;border-top-left-radius: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 5.6px;border-bottom-left-radius: 0px;"><i class="fas fa-download text-end float-end"></i></a></span></footer>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-success py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span style="display: block;"><b>TOTAL PRODUCTS SOLD&nbsp; &nbsp;</b></span><span><b>(MONTHLY)</b></span></div>
                                                <div class="text-dark fw-bold h5 mb-0">
                                                    <span>
                                                        <?php
                                                        echo $totalQuantitySold;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-cart-plus fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                    <footer class="bg-success-subtle" style="margin-bottom: -7px;border-top-right-radius: 5.6px;border-bottom-right-radius: 5.6px;border-bottom-left-radius: 5.6px;"><span class="text-primary-emphasis" style="display: block;font-size: 13.2px;margin: 0px;margin-left: 17px;margin-right: 17px;"><a href="StockBalanceMR.php?YEAR=<?php echo urlencode($selected_year); ?>&MONTH=<?php echo urlencode($selected_month); ?>&ACTION=DOWNLOAD" class="btn btn-primary btn-sm bg-success bg-opacity-75 border-success float-end" type="button" style="border-top-left-radius: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 5.6px;border-bottom-left-radius: 0px;margin-right: -17px;"><i class="fas fa-download text-end float-end"></i></a>Stock Balance Report</span></footer>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-info py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span style="display: block;"><b>TOTAL SALES&nbsp;</b></span><span><b>(MONTHLY)</b></span></div>
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-auto col-xxl-12">
                                                        <div class="text-dark fw-bold h5 mb-0 me-3">
                                                            <span> RM
                                                                <?php
                                                                echo $totalSales;
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-cash-coin fa-2x text-gray-300">
                                                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"></path>
                                                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"></path>
                                                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"></path>
                                                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"></path>
                                                </svg></div>
                                        </div>
                                    </div>
                                     <footer class="bg-info-subtle" style="margin-bottom: -7px;border-top-right-radius: 0px;border-bottom-right-radius: 5.6px;border-bottom-left-radius: 5.6px;height:23.6px"><span class="text-primary-emphasis" style="display: block;font-size: 13.2px;margin: 0px;margin-left: 17px;margin-right: 17px;">Profit and Loss Report</span></footer>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-warning py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span style="display: block;"><b>GROSS PROFIT&nbsp;</b></span><span><b>(MONTHLY)</b></span></div>
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-auto col-xxl-12">
                                                        <div class="text-dark fw-bold h5 mb-0 me-3">
                                                            <span> RM
                                                               <?php
                                                                    echo $grossProfit;
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto"><i class="material-icons fa-2x text-gray-300" style="font-size:36px">trending_up</i></div>
                                        </div>
                                    </div>
                                     <footer class="bg-warning-subtle" style="margin-bottom: -7px;border-top-right-radius: 5.6px;border-bottom-right-radius: 5.6px;border-bottom-left-radius: 5.6px;"><span class="text-primary-emphasis" style="display: block;font-size: 13.2px;margin: 0px;margin-left: 17px;margin-right: 17px;"><a href="ProfitLossMR.php?YEAR=<?php echo urlencode($selected_year); ?>&MONTH=<?php echo urlencode($selected_month); ?>&ACTION=DOWNLOAD" class="btn btn-primary btn-sm bg-warning bg-opacity-75 border-warning float-end" type="button" style="border-top-left-radius: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 5.6px;border-bottom-left-radius: 0px;margin-right: -17px;"><i class="fas fa-download text-end float-end"></i></a>Profit and Loss Report</span></footer>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-6 mb-5">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="text-primary fw-bold m-0">Top Selling Products</h6>
                                    </div>
                                    <div class="card-body">
                                        <div style="width: 90%; margin: auto;">
                                            <canvas id="productRankingChart" width="800px" height="500px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary fw-bold m-0">Top Spenders Ranking</h6>
                                    </div>
                                    <div class="card-body">
                                        <div style="width: 70%; height: 100%; margin: auto;">
                                            <canvas id="topSpendersChart" width="800px" height="700px"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow" style="margin: 2.5%;">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">ADJUSTMENT TABLE</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col"><span>From:&nbsp; &nbsp;</span><input class="border rounded form-control-sm" type="date" style="margin-bottom: 5px;"><span>&nbsp; &nbsp;To:&nbsp; &nbsp;</span><input class="border rounded form-control-sm" type="date" style="margin-bottom: 5px;"></div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTableadjust">
                                <thead>
                                    <tr>
                                        <th style="width: 17%;text-align: left;padding-left: 25px;">Product</th>
                                        <th style="width: 15%;text-align: center;">Type</th>
                                        <th style="width: 15%;text-align: center;">Variation</th>
                                        <th style="width: 15%;text-align: center;">Dimension</th>
                                        <th style="width: 15%;text-align: center;">Quantity</th>
                                        <th style="text-align: center;">Date and Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) == 0) {
                                        echo "<tr>";
                                        echo "<td id='no-items' colspan='6'>No records found.</td>";
                                        echo "</tr>";
                                    } else {
                                        while ($row = mysqli_fetch_array($result)) {
                                            // Fetch previous adjustment record
                                            $prevSql = "SELECT AJ_soldQty AS prevSoldQty, AJ_unsoldQty AS prevUnsoldQty
                                                              FROM tb_advertisement_adjustment
                                                              LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AJ_id = tb_advertisement_material.AM_id
                                                              WHERE tb_advertisement_material.AM_id = '{$row['AM_id']}'
                                                              AND tb_advertisement_adjustment.AJ_adjustedDate < '{$row['AJ_adjustedDate']}'
                                                              ORDER BY AJ_adjustedDate DESC
                                                              LIMIT 1";

                                            $prevResult = mysqli_query($con, $prevSql);
                                            $prevRow = mysqli_fetch_array($prevResult);

                                            $prevUnsoldQty =  0;
                                            $prevSoldQty =  0;
                                            $quantityDisplay = '';

                                            if ($prevRow !== null) {
                                                $prevUnsoldQty = $prevRow['prevUnsoldQty'];
                                            }

                                            if ($prevRow !== null) {
                                                $prevSoldQty =  $prevRow['prevSoldQty'];
                                            }

                                            $unsoldChange = $row['AJ_unsoldQty'] - $prevUnsoldQty;

                                            if ($unsoldChange > 0) {
                                                $quantityDisplay .= "+{$unsoldChange}";
                                            }

                                            $soldChange = $row['AJ_soldQty'] - $prevSoldQty;

                                            if ($soldChange > 0) {

                                                $quantityDisplay .= "-{$soldChange}";
                                            }

                                            if ($quantityDisplay !== '') {
                                                echo "<tr>";
                                                echo "<td class='items'>" . $row['AM_name'] . "</td>";
                                                echo "<td class='items'>" . $row['AM_type'] . "</td>";
                                                echo "<td class='items'>" . $row['AM_variation'] . "</td>";
                                                echo "<td class='items'>" . $row['AM_dimension'] . "</td>";
                                                echo "<td class='items'>" . $quantityDisplay . "</td>";
                                                echo "<td class='items'>" . $row['AJ_adjustedDate'] . "</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow" style="margin: 2.5%;">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">LOW STOCK ITEMS</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTablelow">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;padding-left: 25px;">Product</th>
                                        <th style="width: 18%;text-align: center;">Type</th>
                                        <th style="width: 18%;text-align: center;">Variation</th>
                                        <th style="width: 18%;text-align: center;">Dimension</th>
                                        <th style="text-align: center;">Inventory Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result1) == 0) {
                                        echo "<tr>";
                                        echo "<td id='no-items' colspan='5'>No low stock items found.</td>";
                                        echo "</tr>";
                                    } else {
                                        while ($row = mysqli_fetch_array($result1)) {
                                            echo "<tr>";
                                            echo "<td class='items'>" . $row['AM_name'] . "</td>";
                                            echo "<td class='items'>" . $row['AM_type'] . "</td>";
                                            echo "<td class='items'>" . $row['AM_variation'] . "</td>";
                                            echo "<td class='items'>" . $row['AM_dimension'] . "</td>";
                                            echo "<td class='items'>" . $row['AM_unsoldQty'] . "</td>";
                                        }
                                    }
                                    ?>
                                    <tr></tr>
                                </tbody>
                                <tfoot>
                                    <tr></tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <p id="dataTable_info-1" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
                            </div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                        <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © AK MAJU 2023</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="emailModal" style="margin: 0px;margin-top: 0px;text-align: left;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
            <div class="modal-content">
                <div class="modal-header" style="margin: 0px;">
                    <h4 class="modal-title" style="color: rgb(0,0,0);">Email Monthly Report</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="contact" action="pdf_maker.php" method="post">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Email</label><input placeholder="Your Email Address" class="form-control" type="email" required="" name="email"><br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="selected_year" value="<?php echo $selected_year; ?>">
                                <input type="hidden" name="selected_month" value="<?php echo $selected_month; ?>">
                                <input type="hidden" name="ACTION" value="EMAIL">
                                <button class="btn btn-primary" type="button" id="contact-submit" name="send">Send</button>
                            </div>
                        </div>
                    </form>
                     <div id="successMessage" style="display: none;">
                    <div style="border-radius: 200px; height: 200px; width: 200px; background: #F8FAF5; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="checkmark" style="color: #9ABC66; font-size: 100px; line-height: 200px;">✓</i>
                    </div>
                    <h1 style="text-align: center; color: #88B04B; font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif; font-weight: 900;">Success</h1>
                    <p style="text-align: center; color: #404F5E; font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif; font-size:20px;">Your monthly report has been sent successfully!</p>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $("#emailPdfButton").click(function () {
            $("#contact")[0].reset(); // Reset the form
            $("#successMessage").hide(); // Hide the success message
            $("#emailModal").modal("show");
        });

        $('#contact-submit').on('click', function () {
            // Change button text to "Sending" when clicked
            $(this).text('Sending...');
            $.ajax({
                type: "POST",
                url: "pdf_maker.php",
                data: $("#contact").serialize(),
                success: function (response) {
                    if ($.trim(response) === "Message sent!") {
                        // Hide the form and display the success message
                        $("#contact").hide();
                        $("#successMessage").show();
                    } else {
                        // Display an error message to the user
                        alert("Failed to send email. Please try again.");
                    }
                },
                error: function () {
                    alert("Error in AJAX request.");
                }
            });
        });

        // Reset the modal to its original state when hidden
        $("#emailModal").on("hidden.bs.modal", function () {
            $("#contact")[0].reset(); // Reset the form
            $("#contact").show(); // Show the form
            $("#successMessage").hide(); // Hide the success message
        });
    });

    $(document).ready(function() {
        $('#dataTableadjust').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10 // Initial page length
        });
    });

    $(document).ready(function() {
        $('#dataTablelow').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10 // Initial page length
        });
    });
</script>

    <script>
        // Function to update charts based on selected year and month
        function updateCharts(selected_year, selected_month) {
            var userId = <?php echo $fid; ?>;
            // AJAX request
            $.ajax({
                type: 'GET',
                url: 'admindashboard-2.php?id=' + userId, // Replace with the correct path to your PHP file
                data: {
                    selected_year: selected_year,
                    selected_month: selected_month
                },
                success: function(response) {
                    // Update the results on the page
                    $('#total_orders').text(response.total_orders);
                    $('#total_products_sold').text(response.total_products_sold);
                    $('#total_sales').text(response.total_sales);
                    $('#total_gross_profit').text(response.total_gross_profit);

                    // Update chart data
                    updateProductRankingChart(response.product_names, response.total_quantities);
                    updateTopSpendersChart(response.customer_names, response.total_spent_amounts);

                    // Add logic to update other elements or charts as needed
                },
                error: function(error) {
                    console.error('AJAX request failed:', error);
                }
            });
        }

        // Attach the function to the change event of the year and month dropdowns
        $('#selected_year, #selected_month').change(function() {
            // Trigger form submission
            document.getElementById("filterForm").submit();
        });


        // Function to update the Product Ranking Chart
        function updateProductRankingChart(productNames, totalQuantities) {
            // Assuming you have a reference to your chart
            // Replace 'productRankingChart' with the actual ID of your chart
            var productRankingChart = "productRankingChart";

                // Update chart data
                productRankingChart.data.labels = productNames;
            productRankingChart.data.datasets[0].data = totalQuantities;

            // Redraw the chart
            productRankingChart.update();
        }

        // Function to update the Top Spenders Chart
        function updateTopSpendersChart(customerNames, totalSpentAmounts) {
            // Assuming you have a reference to your chart
            // Replace 'topSpendersChart' with the actual ID of your chart
            var topSpendersChart = "topSpendersChart";

                // Update chart data
                topSpendersChart.data.labels = customerNames;
            topSpendersChart.data.datasets[0].data = totalSpentAmounts;

            // Redraw the chart
            topSpendersChart.update();
        }
    </script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script>
        // Parse PHP arrays to JavaScript arrays
        var productNames = <?php echo $productNamesJSON; ?>;
        var totalQuantities = <?php echo $totalQuantitiesJSON; ?>;

        // Choose different colors for the top 5 products
        var colors = ['rgb(134, 227, 206)', 'rgb(210, 230, 165)', 'rgb(255, 221, 148)', 'rgb(250, 137, 123)', 'rgb(204, 171, 219)'];

        // Create an array to store the background colors for each data point
        var backgroundColors = totalQuantities.map(function(_, index) {
            // Use a different color for the top 5 products, default to the first color otherwise
            return index < 5 ? colors[index] : colors[0];
        });

        // Limit arrays to the top 5 elements
        productNames = productNames.slice(0, 5);
        totalQuantities = totalQuantities.slice(0, 5);

        // Create horizontal bar chart
        const data = {
            labels: productNames,
            datasets: [{
                label: 'Total Quantity Sold',
                data: totalQuantities,
                backgroundColor: backgroundColors,
                borderColor: backgroundColors,
                borderWidth: 1,
                barThickness: 50,
                borderRadius: 20
            }]
        };

        const configTotalQ = {
            type: 'bar',
            data,
            options: {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawTicks: false,
                            drawOnChartArea: false
                        }
                    },
                    x: {
                        beginAtZero: true,
                        
                        grid: {
                            display: false,
                            drawTicks: false,
                            drawOnChartArea: false
                        }
                    }
                }
            },
        };

        // render init block
        const productRankingChart = new Chart(
            document.getElementById('productRankingChart'),
            configTotalQ
        );

        // Instantly assign Chart.js version
        const chartVersion1 = document.getElementById('chartVersion1');
        chartVersion1.innerText = Chart.version;
    </script>



    <script>
        // setup 
        var customerIds = <?php echo $customerIdsJSON; ?>;
        var customerNames = <?php echo $customerNamesJSON; ?>;
        var totalSpentAmounts = <?php echo $totalSpentAmountsJSON; ?>;

        if (customerNames.length >= 2) {
            [customerIds[0], customerIds[1]] = [customerIds[1], customerIds[0]];
            [customerNames[0], customerNames[1]] = [customerNames[1], customerNames[0]];
            [totalSpentAmounts[0], totalSpentAmounts[1]] = [totalSpentAmounts[1], totalSpentAmounts[0]];
        }

        var colors1 = ['rgb(243, 171, 182)', 'rgb(199, 155, 168)', 'rgb(245, 188, 159)'];

        // Create an array to store the background colors for each data point
        var backgroundColors1 = totalSpentAmounts.map(function(_, index) {
            // Use a different color for the top 5 products, default to the first color otherwise
            return index < 5 ? colors1[index] : colors1[0];
        });

        const data1 = {
            labels: customerIds,
            datasets: [{
                label: 'Total Amount Spent',
                data: totalSpentAmounts,
                backgroundColor: backgroundColors1,
                borderColor: backgroundColors1,
                borderWidth: 1,
                barPercentage: 0.5,
                categoryPercentage: 1.0,
                barThickness: 60
            }]
        };

        // config 
        const configTopS = {
            type: 'bar',
            data: data1,
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            afterTitle: function(context) {
                                        console.log(context);
                                        return customerNames[context[0].dataIndex];
                                    }
                                }
                        }
                    },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawTicks: false,
                            drawOnChartArea: false
                        }
                    },
                    x: {
                        beginAtZero: true,
                        
                        grid: {
                            display: false,
                            drawTicks: false,
                            drawOnChartArea: false
                        }
                    }
                }
            },
        };

        // render init block
        const topSpendersChart = new Chart(
            document.getElementById('topSpendersChart'),
            configTopS
        );

        // Instantly assign Chart.js version
        const chartVersion2 = document.getElementById('chartVersion2');
        chartVersion2.innerText = Chart.version;
    </script>
</body>

<?php
mysqli_close($con);
?>