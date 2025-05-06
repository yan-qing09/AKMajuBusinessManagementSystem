<?php
include ('dbconnect.php');
include ('mysession.php');

$sql = "SELECT tb_customer.C_id, tb_customer.C_name, tb_customer.C_email, tb_customer.C_street, tb_customer.C_city, tb_customer.C_postcode, tb_customer.C_state, tb_customer_phone.C_phone
        FROM tb_customer
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        LEFT JOIN tb_agency_government ON tb_customer.C_id = tb_agency_government.C_id
        LEFT JOIN tb_ag_phone ON tb_agency_government.C_id = tb_ag_phone.C_id";

$result = mysqli_query($con,$sql);

$sql1 = "SELECT tb_customer.C_id, tb_customer.C_name, tb_agency_government.AG_name, tb_ag_phone.AG_phone
        FROM tb_customer
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        LEFT JOIN tb_agency_government ON tb_customer.C_id = tb_agency_government.C_id
        LEFT JOIN tb_ag_phone ON tb_agency_government.C_id = tb_ag_phone.C_id
        WHERE tb_customer.C_type = 2";
$result1 = mysqli_query($con,$sql1);

$sql2 = "SELECT tb_customer.C_id, tb_customer.C_name, tb_agency_government.AG_name, tb_ag_phone.AG_phone
        FROM tb_customer
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        LEFT JOIN tb_agency_government ON tb_customer.C_id = tb_agency_government.C_id
        LEFT JOIN tb_ag_phone ON tb_agency_government.C_id = tb_ag_phone.C_id
        WHERE C_type = 3";
$result2 = mysqli_query($con,$sql2);


$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

include ('customerheader.php');
?>

<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Customer Management</h3>
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

                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-4">Customer</h3>
                        <?php
                            if ($rows['U_type'] === 'Admin') { 
                                echo "<button class='btn btn-primary btn-sm d-sm-inline-block' data-bs-toggle='modal' data-bs-target='#modal-3' type='button'>&nbsp;Export Customer Report</button>";
                            }
                        ?>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Customer Info</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th style="min-width: 300px;">Address</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($row=mysqli_fetch_array($result))
                                        {
                                            echo "<tr>";
                                            echo "<td>".$row['C_id']."</td>";
                                            echo "<td>".$row['C_name']."</td>";
                                            echo "<td>".$row['C_email']."</td>";
                                            echo "<td>".$row['C_street'].', '.$row['C_city'].', '.$row['C_postcode'].' '.$row['C_state']."</td>";
                                            echo "<td>".$row['C_phone']."</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Government Info</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="governmentTable_info">
                                <table class="table my-0" id="governmentTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Representative Name</th>
                                            <th>Government</th>
                                            <th>Government Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($row1=mysqli_fetch_array($result1))
                                        {
                                            if ($row1['C_id'] !== null && $row1['C_id'] !== ''){
                                                echo "<tr>";
                                                echo "<td>".$row1['C_id']."</td>";
                                                echo "<td>".$row1['C_name']."</td>";
                                                echo "<td>".$row1['AG_name']."</td>";
                                                echo "<td>".$row1['AG_phone']."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Agency Info</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="agencyTable_info">
                                <table class="table my-0" id="agencyTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Representative Name</th>
                                            <th>Agency</th>
                                            <th>Agency Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($row2=mysqli_fetch_array($result2))
                                        {   
                                            if ($row2['C_id'] !== null && $row2['C_id'] !== ''){
                                                echo "<tr>";
                                                echo "<td>".$row2['C_id']."</td>";
                                                echo "<td>".$row2['C_name']."</td>";
                                                echo "<td>".$row2['AG_name']."</td>";
                                                echo "<td>".$row2['AG_phone']."</td>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
        </div><a class="d-inline border rounded scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="modal-3" style="margin: 0px;margin-top: 0px;text-align: left;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
            <div class="modal-content">
                <div class="modal-header" style="margin: 0px;">
                    <h4 class="modal-title" style="color: rgb(0,0,0);">Export Customer Information</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="get" action="exportcustomer.php?id=<?php echo $fid; ?>" onsubmit="return toggleDateFields3()">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" style="color: black;">Range of Date
                                        <select style="margin-top: 10px; margin-bottom: 20px;" class="d-inline-block form-select form-select-sm" id="rangedate" name="rangedate" onchange="toggleDateFields()">
                                            <option value="0" selected>None</option>
                                            <option value="1">1 Month</option>
                                            <option value="3">3 Months</option>
                                            <option value="6">6 Months</option>
                                            <option value="12">12 Months</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" style="color: black;">Date From
                                        <input type="date" name="datefrom" id="datefrom" class="d-inline-block form-select form-select-sm" style="margin-bottom: 20px;"  onchange="toggleDateFields2()">
                                        <?php echo"<input type='hidden' name='id' value='$fid'>" ?>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color: black;">Date To
                                        <input type="date" name="dateto" id="dateto" class="d-inline-block form-select form-select-sm" style="margin-bottom: 20px;"  onchange="toggleDateFields2()">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" style="color: white; background: blue;" >Export</button>
                        </div>

                        <script>
                            function toggleDateFields() {
                                var rangeDate = document.getElementById('rangedate');
                                var dateFrom = document.getElementById('datefrom');
                                var dateTo = document.getElementById('dateto');

                                if (rangeDate.value === 'custom') {
                                    dateFrom.disabled = false;
                                    dateTo.disabled = false;
                                } else {
                                    dateFrom.disabled = true;
                                    dateTo.disabled = true;
                                }
                            }

                            function toggleDateFields2() {
                                var rangeDate = document.getElementById('rangedate');
                                var dateFrom = document.getElementById('datefrom');
                                var dateTo = document.getElementById('dateto');

                                // Disable the rangeDate dropdown if dateFrom or dateTo have values
                                if (dateFrom.value !== '' || dateTo.value !== '') {
                                    rangeDate.disabled = true;
                                } else {
                                    rangeDate.disabled = false;
                                }
                            }

                            function toggleDateFields3() {
                                var rangeDate = document.getElementById('rangedate');
                                var dateFrom = document.getElementById('datefrom');
                                var dateTo = document.getElementById('dateto');

                                rangeDate.disabled = false;
                                dateFrom.disabled = false;
                                dateTo.disabled = false;

                                console.log('Form submitted');
                            }
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });

        $('#governmentTable').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });

        $('#agencyTable').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });
    });
</script>

</html>