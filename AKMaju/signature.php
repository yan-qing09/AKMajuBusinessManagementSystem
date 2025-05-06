<?php
include('dbconnect.php');
include('mysession.php');

$fid = $_GET['id'];
$sqls = "SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con, $sqls);
$rows = mysqli_fetch_array($result3);

$sqlsig = "SELECT *
         FROM tb_signature
         LEFT JOIN tb_user ON tb_user.U_id = tb_signature.U_id
         WHERE tb_signature.U_id = '$fid'
         ORDER BY S_uploadDate DESC";

$resultsig = mysqli_query($con, $sqlsig);


include('headersignature.php');
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
                        <h3 class="text-dark mb-0">Signature</h3>
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
                <!-- content -->
                <div class="row">
                    <div class="col">
                        <h3 class="text-dark mb-4" style="margin-left:34px;">Signature Details</h3>
                    </div>
                    <div class="col d-flex justify-content-end" style="margin-right: 34px;">
                        <button class="btn btn-success m-1 mr-2" type="button" style="width: 35px; height: 35px; display: flex; justify-content: center; align-items: center; margin-right: 3%;" data-bs-toggle="modal" data-bs-target="#uploadModal">
                            <i class='fas fa-upload' style='color: white;'></i>
                        </button>
                    </div>
                </div>
                <div class="card shadow" style="margin-left: 2%;margin-right: 2%">
                    <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-primary m-0 fw-bold">Signature</p>
                        </div>
                    </div>
                </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th style="width: 21%;padding-left: 35px;">User Name</th>
                                        <th class="text-center" style="width: 28%;">Upload Date</th>
                                        <th class="text-center" style="width: 20%;">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php 
                                            while ($rowsig = mysqli_fetch_array($resultsig)) {
                                                $status = $rowsig['S_status'];
                                                $statusdesc = ($status == '0') ? 'inactive' : 'active';
                                                $currentfile = $rowsig['S_id'];
                                                $deleteButtonDisabled = ($status == '0') ? 'disabled' : '';
                                                echo"<script>
                                              document.addEventListener('DOMContentLoaded', function() {
                                                 var modalId = 'addSigr-" . $currentfile . "';
                                                 var modalTrigger = document.getElementById('modalTrigger-" . $currentfile . "');
                                                 var myModal = new bootstrap.Modal(document.getElementById(modalId));
                                                 modalTrigger.addEventListener('click', function() {
                                                     myModal.show();
                                                 });
                                               });
                                              </script>";
                                                echo "<tr>
                                                        <td style='padding-left: 25px;'>{$rowsig['U_name']}</td>
                                                        <td class='text-center'>{$rowsig['S_uploadDate']}</td>
                                                        <td class='text-center'>$statusdesc</td>
                                                        <td class='text-center'>
                                                            <div style='display: flex; align-items: center; justify-content: center;'>
                                                                <a href='opensignature.php?id=" . $rowsig['U_id'] . "&sigid=" . $rowsig['S_id'] . "' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                                    <i class='fas fa-book-open'></i>
                                                                </a>";
                                                                if ($status == '1') {
                                                                    echo "<button type='button' class='btn btn-danger m-1 delete-btn' id='modalTrigger-" . $currentfile . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;' $deleteButtonDisabled>
                                                                                <i class='fas fa-trash'></i>
                                                                            </button>";
                                                                }
                                                            echo "</div>
                                                        </td>
                                                      </tr>
                                                      <div class='modal fade' role='dialog' tabindex='-1' id='addSigr-" . $currentfile . "' style='margin: 0px; margin-top: 0px; text-align: left;'>
                                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header' style='margin: 0px;'>
                                                                <h4 class='modal-title'> Delete Signature</h4>
                                                                <button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p>Do you sure you want to delete this signature?</p>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                <a href='deleteSig.php?id=" . $rowsig['U_id'] . "&sigid=" . $rowsig['S_id'] . "' class='btn btn-danger' style='background: rgb(205,10,10);'>Delete</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                            }
                                            ?>
                                    <tr></tr>
                                    <tr></tr>
                                </tbody>
                                <tfoot>
                                    <tr></tr>
                                </tfoot>
                            </table>
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
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<div class="modal fade" role="dialog" tabindex="-1" id="uploadModal" style="margin: 0px; margin-top: 0px; text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0, 0, 0);">Upload Signature</h4>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id='upload' action='upload.php?id=<?php echo $fid; ?>' method='post' enctype='multipart/form-data'>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="signature">Select Signature</label><br>
                                <input type="file" name="signature" id="signature" accept=".png, .jpg, .jpeg" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="signature-upload">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/theme.js"></script>


