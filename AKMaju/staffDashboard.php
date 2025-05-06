<?php
include('dbconnect.php');
include('mysession.php');
include('mr.php');


$totalUnpaidOrders = calculateUnpaidOrders($con);
$totalDeliveredOrders = calculateUnpaidOrders($con);
$totalPendingApprove = calculatePendingApprove($con);
$totalCompleteOrders = calculateCompletedOrders($con);

//Retrieve adjusted items
$sql_adjusted = "SELECT * FROM tb_advertisement_adjustment
                 LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AM_id = tb_advertisement_material.AM_id
                 WHERE AMH_date >= DATE(NOW()) - INTERVAL 30 DAY
                 ORDER BY AMH_date DESC";

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
             <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-xl-3 col-xxl-3 mb-4" style="padding: 10px 5px;">
                                <div class="card text-white shadow" style="background-color: #ad466c">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2 text-center">
                                                <p style="color: white;"><b>PENDING APPROVAL</b></p>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <div class="text-white fw-bold h5 mb-0" style="font-size: 35px;"><?php
                                                        echo $totalPendingApprove;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 col-xxl-3 mb-4" style="padding: 10px 5px;">
                                <div class="card text-white shadow" style="background-color: #cc607d;">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2 text-center">
                                                <p style="color: white;"><b>UNPAID ORDERS</b></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <div class="text-white fw-bold h5 mb-0" style="font-size: 35px;">
                                                    <?php
                                                        echo $totalUnpaidOrders;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-6 col-xl-3 col-xxl-3 mb-4" style="padding: 10px 5px;">
                                <div class="card text-white shadow" style="background-color: #e38191;">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2 text-center">
                                                <p style="color: white;"><b>UNDELIVERED ORDERS</b></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <div class="text-white fw-bold h5 mb-0" style="font-size: 35px;">
                                                    <?php
                                                        echo $totalDeliveredOrders;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-md-6 col-xl-3 col-xxl-3 mb-4" style="padding: 10px 5px;">
                                <div class="card text-white shadow" style="background-color: #f4a3a8">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2 text-center">
                                                <p style="color: white;"><b>COMPLETED ORDERS</b></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <div class="text-white fw-bold h5 mb-0" style="font-size: 35px;">
                                                    <?php
                                                        echo $totalCompleteOrders;
                                                    ?>
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
                                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
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
                                               while ($row = mysqli_fetch_array($result)) 
                                              {
                                                  // Fetch previous adjustment record
                                                  $prevSql = "SELECT AMH_soldQty AS prevSoldQty, AMH_unsoldQty AS prevUnsoldQty
                                                              FROM tb_advertisement_adjustment
                                                              LEFT JOIN tb_advertisement_material ON tb_advertisement_adjustment.AM_id = tb_advertisement_material.AM_id
                                                              WHERE tb_advertisement_material.AM_id = '{$row['AM_id']}'
                                                              AND tb_advertisement_adjustment.AMH_date < '{$row['AMH_date']}'
                                                              ORDER BY AMH_date DESC
                                                              LIMIT 1";

                                                  $prevResult = mysqli_query($con, $prevSql);
                                                  $prevRow = mysqli_fetch_array($prevResult);

                                                  $prevUnsoldQty =  0;
                                                  $prevSoldQty =  0;
                                                  $quantityDisplay = '';

                                                  if($prevRow !== null)
                                                  {
                                                       $prevUnsoldQty = $prevRow['prevUnsoldQty'];
                                                  }

                                                  if($prevRow !== null)
                                                  {
                                                       $prevSoldQty =  $prevRow['prevSoldQty'];   
                                                  }

                                                  $unsoldChange = $row['AMH_unsoldQty'] - $prevUnsoldQty;

                                                  if ($unsoldChange > 0) 
                                                  {
                                                      $quantityDisplay .= "+{$unsoldChange}";
                                                  }

                                                  $soldChange = $row['AMH_soldQty'] - $prevSoldQty;

                                                  if ($soldChange > 0) {

                                                      $quantityDisplay .= "-{$soldChange}";
                                                  }

                                                  if ($quantityDisplay !== '')
                                                  {       echo "<tr>";
                                                          echo "<td class='items'>" . $row['AM_name'] . "</td>";
                                                          echo "<td class='items'>" . $row['AM_type'] . "</td>";
                                                          echo "<td class='items'>" . $row['AM_variation'] . "</td>";
                                                          echo "<td class='items'>" . $row['AM_dimension'] . "</td>";
                                                          echo "<td class='items'>" . $quantityDisplay . "</td>";
                                                          echo "<td class='items'>" . $row['AMH_date'] . "</td>";
                                                          echo "</tr>";
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
                                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
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
                                                while($row = mysqli_fetch_array($result1))
                                                {
                                                     echo "<tr>";
                                                     echo "<td class='items'>".$row['AM_name']."</td>";
                                                     echo "<td class='items'>".$row['AM_type']."</td>";
                                                     echo "<td class='items'>".$row['AM_variation']."</td>";
                                                     echo "<td class='items'>".$row['AM_dimension']."</td>";
                                                     echo "<td class='items'>".$row['AM_unsoldQty']."</td>";
                                                     echo "</tr>";
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
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © AK MAJU 2023</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
    $(document).ready(function () {
        var adjustmentTable = $('#dataTableadjust').DataTable({
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5 // Initial page length
    });

    var lowStockTable = $('#dataTablelow').DataTable({
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5 // Initial page length
    });
    });
</script>
<script src="assets/js/theme.js"></script>
</body>

<?php
mysqli_close($con);
?>