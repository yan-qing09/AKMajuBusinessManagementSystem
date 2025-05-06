<?php
include ('dbconnect.php');
include ('mysession.php');

$sql = "SELECT *
        FROM tb_am_history";
$sqlp = "SELECT *
        FROM tb_advertisement_adjustment";
$result = mysqli_query($con,$sql);
$result2 = mysqli_query($con,$sqlp);
$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);
include('datableheader.php');
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Advertisement Material</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Filter.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
    <link rel="stylesheet" href="assets/css/sidebar-style4.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Advertisement Material</h3>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form><ul class="navbar-nav flex-nowrap ms-auto">
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
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <?php echo"<div class='nav-item dropdown no-arrow'><a class='dropdown-toggle nav-link' aria-expanded='false' data-bs-toggle='dropdown' href='#''><span class='d-none d-lg-inline me-2 text-gray-600 small'>".$rows['U_id']."<br>".$rows['U_name']."</span></a>" ?>
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
                        <div class="col-md-6">
                            <h3 class="text-dark mb-4">Advertisement Material History</h3>
                            <p style="color: black; font-size: 16px;">
                            <a href="#historyCard" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Material History</a>
                            /
                           <a href="#adjustCard" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Material Adjustments</a>

                        </p>
                        </div>
                          <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <?php
                                echo "<a href='admaterial.php?id=".$rows['U_id']."' class='btn btn-primary' role='button' style='text-align: justify; height:auto;'><i class='fas fa-table' style='position: sticky;''></i> Material</a>";
                            ?>
                        </div>
                </div>
            </div>
                <div class="container-fluid">
                    <div class="card shadow" id="historyCard">
                        <div class="card-header py-3" >
                            <p class="text-primary m-0 fw-bold">Material History</p>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 3px;">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable24">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;width: 25.6562px;padding-top: 8px;padding-bottom: 8px;margin-top: 32px;">Material ID</th>
                                            <th style="width: 96.831px;text-align: center;">Modified Date</th>
                                            <th style="width: 88.194px;text-align: center;">Cost</th>
                                            <th style="width: 97.837px;text-align: center;">Price</th>
                                            <th style="text-align: center;width: 80px;">Modified by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row=mysqli_fetch_array($result)){
                                                echo "<tr>";
                                                echo "<td style='width: 30px;text-align: center;'>".$row['AM_id']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['AMH_date']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['AMH_cost']. "</td>";
                                                echo "<td style='text-align: center;width: 130px;'>".$row['AMH_price']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_id']. "</td>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header py-3" id="adjustCard">
                            <p class="text-primary m-0 fw-bold">Material Adjustments</p>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 3px;">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable23">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;width: 25.6562px;padding-top: 8px;padding-bottom: 8px;margin-top: 32px;">Material ID</th>
                                            <th style="width: 96.831px;text-align: center;">Modified Date</th>
                                            <th style="width: 88.194px;text-align: center;">Sold Quantity</th>
                                            <th style="width: 97.837px;text-align: center;">Selling Quantity</th>
                                          <th style="width: 97.837px;text-align: center;">Unsold Quantity</th>
                                          <th style="width: 97.837px;text-align: center;">Modified by</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row=mysqli_fetch_array($result2)){
                                                echo "<tr>";
                                                echo "<td style='width: 30px;text-align: center;'>".$row['AM_id']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['AMH_date']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['AMH_soldQty']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['AMH_sellingQty']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['AMH_unsoldQty']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_id']. "</td>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
        $(document).ready(function() {
    $('#dataTable23').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "order": [[1, "desc"]],
        responsive: true
       });
    });
    $(document).ready(function() {
    $('#dataTable24').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "order": [[1, "desc"]],
        responsive: true
       });
    });
</script>
<script src='https://cdn.jsdelivr.net/gh/itaypanda/simpletoast@master/SimpleToast.min.js'></script>
<script src='https://cdn.tailwindcss.com/3.2.4'></script>
 <script>
    <?php if (!empty($message)) : ?>
        toastInit();
        toast('Low Stock Alert', '<?php echo $message; ?>', toastStyles.error);
    <?php endif; ?>
</script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="assets/js/Sidebar-Menu-sidebar.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>