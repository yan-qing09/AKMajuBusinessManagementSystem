<?php
include('dbconnect.php');
include('mysession.php');

//AQ
$sql_taq = "SELECT *
             FROM tb_advertisement_quotation
             LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_advertisement_quotation.O_id
             LEFT JOIN tb_customer ON tb_advertisement_order.C_id = tb_customer.C_id
             LEFT JOIN tb_order_status ON tb_advertisement_quotation.AQ_status = tb_order_status.O_status
             ORDER BY AQ_issueDate DESC";


$resulttaq = mysqli_query($con, $sql_taq);

//CQ
$sql_tcq = "SELECT *
             FROM tb_construction_quotation
             LEFT JOIN tb_construction_order ON tb_construction_order.O_id = tb_construction_quotation.O_id
             LEFT JOIN tb_customer ON tb_construction_order.C_id = tb_customer.C_id
             LEFT JOIN tb_order_status ON tb_construction_quotation.CQ_status = tb_order_status.O_status
             ORDER BY CQ_issueDate DESC";


$resulttcq = mysqli_query($con, $sql_tcq);

//Invoice
$sql_invoice = "SELECT *
                  FROM tb_invoice
                  LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_invoice.O_id
                  LEFT JOIN tb_customer ON tb_advertisement_order.C_id = tb_customer.C_id
                  LEFT JOIN tb_order_status ON tb_invoice.I_status = tb_order_status.O_status
                  WHERE I_status = '12'";


$resultinvoice = mysqli_query($con, $sql_invoice);

$sql_tinvoice = "SELECT *
                  FROM tb_invoice
                  LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_invoice.O_id
                  LEFT JOIN tb_customer ON tb_advertisement_order.C_id = tb_customer.C_id
                  LEFT JOIN tb_order_status ON tb_invoice.I_status = tb_order_status.O_status
                  ORDER BY I_issueDate DESC";


$resulttinvoice = mysqli_query($con, $sql_tinvoice);

//DO
$sql_tdo = "SELECT *
             FROM tb_delivery_order
             LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_delivery_order.O_id
             LEFT JOIN tb_customer ON tb_advertisement_order.C_id = tb_customer.C_id
             LEFT JOIN tb_order_status ON tb_delivery_order.DO_status = tb_order_status.O_status
             ORDER BY DO_issueDate DESC";

//Execute
$resulttdo = mysqli_query($con, $sql_tdo);



$fid = $_GET['id'];
$sqls = "SELECT *FROM tb_user
          WHERE U_id='$fid'";
$result3 = mysqli_query($con, $sqls);
$rows = mysqli_fetch_array($result3);

include('headerverification.php');
?>

<style>
    .link-button {
  background: none;
  border: none;
  padding: 0;
  margin-left: 5px;
  margin-right:5px;
  font-size: inherit;
  color: #0366d6;
  font-weight: bold;
  text-decoration: underline;
  cursor: pointer;
}

.link-button:hover {
  color: #004080; /* Adjust the hover color as needed */
}

.button-row {
    margin-left:33px;
}
</style>

<body id="page-top">
    <!-- side nav bar -->
    <div id="wrapper">
        <?php include('navbar.php'); ?>


        <!-- top nav bar -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Document Verification</h3>
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
            <div class="col-md-6">
                <h3 class="text-dark mb-4" style="margin-left:34px;">Document Verification Details</h3>
            </div>
        </div>

        <div class="button-row">
            <button class="link-button" onclick="showDocuments('invoices')">Invoices</button> /
            <button class="link-button" onclick="showDocuments('advertisementQuotations')">Advertisement Quotations</button> /
            <button class="link-button" onclick="showDocuments('constructionQuotations')">Construction Quotations</button> /
            <button class="link-button" onclick="showDocuments('deliveryOrders')">Delivery Orders</button>
        </div>

            <div id="advertisementQuotationsTable"  style="display: none;">
                <div class="card shadow" style="margin-left: 2%;margin-right: 2%;margin-top: 2%">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">All Advertisement Quotations</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2" id="dataTableTAQ">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 18%;">Customer</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generation Date</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generated By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Approved By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($rowtaq = mysqli_fetch_array($resulttaq)) {
                                            $hisAQId = $rowtaq['AQ_id'];

                                            $sql_gnraq1 = "SELECT *
                                                       FROM tb_advertisement_quotation
                                                       LEFT JOIN tb_aq_generation ON tb_advertisement_quotation.AQ_id = tb_aq_generation.AQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_aq_generation.U_id
                                                       WHERE tb_advertisement_quotation.AQ_id = '$hisAQId' AND tb_aq_generation.D_progress = '1'";

                                            $resultgnraq1 = mysqli_query($con, $sql_gnraq1);

                                            $rowgnraq1 = mysqli_fetch_array($resultgnraq1);

                                            $sql_appaq = "SELECT *
                                                       FROM tb_advertisement_quotation
                                                       LEFT JOIN tb_aq_generation ON tb_advertisement_quotation.AQ_id = tb_aq_generation.AQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_aq_generation.U_id
                                                       WHERE tb_advertisement_quotation.AQ_id = '$hisAQId' AND tb_aq_generation.D_progress = '3'";

                                            $resultappaq = mysqli_query($con, $sql_appaq);

                                            $rowappaq = mysqli_fetch_array($resultappaq);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $rowtaq['AQ_id'] . "</td>";
                                            echo "<td class='items2'>" . $rowtaq['C_name'] . "</td>";
                                            echo "<td class='items'>" . $rowtaq['AQ_issueDate'] . "</td>";
                                            echo "<td class='items'>" . (isset($rowgnraq1['U_name']) ? $rowgnraq1['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . (isset($rowappaq['U_name']) ? $rowappaq['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . $rowtaq['O_desc'] . "</td>";
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


            <div id="constructionQuotationsTable" style="display: none;">
                <div class="card shadow" style="margin-left: 2%;margin-right: 2%;margin-top: 2%">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">All Construction Quotations</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2" id="dataTableTCQ">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 18%;">Customer</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generation Date</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generated By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Approved By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($rowtcq = mysqli_fetch_array($resulttcq)) {
                                            $hisCQid = $rowtcq['CQ_id'];

                                            $sql_gnrcq1 = "SELECT *
                                                       FROM tb_construction_quotation
                                                       LEFT JOIN tb_cq_generation ON tb_construction_quotation.CQ_id = tb_cq_generation.CQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_cq_generation.U_id
                                                       WHERE tb_construction_quotation.CQ_id = '$hisCQid' AND tb_cq_generation.D_progress = '1'";

                                            $resultgnrcq1 = mysqli_query($con, $sql_gnrcq1);

                                            $rowgnrcq1 = mysqli_fetch_array($resultgnrcq1);

                                            $sql_appcq = "SELECT *
                                                       FROM tb_construction_quotation
                                                       LEFT JOIN tb_cq_generation ON tb_construction_quotation.CQ_id = tb_cq_generation.CQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_cq_generation.U_id
                                                       WHERE tb_construction_quotation.CQ_id = '$hisCQid' AND tb_cq_generation.D_progress = '3'";

                                            $resultappcq = mysqli_query($con, $sql_appcq);

                                            $rowappcq = mysqli_fetch_array($resultappcq);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $rowtcq['CQ_id'] . "</td>";
                                            echo "<td class='items2'>" . $rowtcq['C_name'] . "</td>";
                                            echo "<td class='items'>" . $rowtcq['CQ_issueDate'] . "</td>";
                                            echo "<td class='items'>" . (isset($rowgnrcq1['U_name']) ? $rowgnrcq1['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . (isset($rowappcq['U_name']) ? $rowappcq['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . $rowtcq['O_desc'] . "</td>";
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

            <div id="invoicesTable">
                <div class="card shadow" style="margin-left: 2%;margin-right: 2%;margin-top: 2%">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Invoices Awaiting Approval</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2" id="dataTableIA">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 18%;">Customer</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generation Date</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generated By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Status</th>
                                        <th class='items' style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row3 = mysqli_fetch_array($resultinvoice)) {
                                            $currentIid = $row3['I_id'];
                                            $IAOid = $row3['O_id'];

                                            $sql_gnri = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$currentIid' AND tb_invoice_generation.D_progress = '1'";

                                            $resultgnri = mysqli_query($con, $sql_gnri);

                                            $rowgnri = mysqli_fetch_array($resultgnri);

                                                echo "<tr>";
                                                echo "<td class='items1'>" . $row3['I_id'] . "</td>";
                                                echo "<td class='items2'>" . $row3['C_name'] . "</td>";
                                                echo "<td class='items'>" . $row3['I_issueDate'] . "</td>";
                                                echo "<td class='items'>" . $rowgnri['U_name'] . "</td>";
                                                echo "<td class='items'>" . $row3['O_desc'] . "</td>";
                                                echo "<td class='items'>
                                                      <div style='display: flex; align-items: center; justify-content: center;'>
                                                          <a href='openInvoice.php?id=" . $fid . "&iid=" . $currentIid . "' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='fas fa-book-open'></i></a>";
                                                echo "<script>
                                                  document.addEventListener('DOMContentLoaded', function() {
                                                      var checkmodalId = 'checkIModal-" . $currentIid . "';
                                                      var checkmodalTrigger = document.getElementById('checkmodalTrigger-" . $currentIid . "');
                                                      var checkModal = new bootstrap.Modal(document.getElementById(checkmodalId));
                                                      checkmodalTrigger.addEventListener('click', function() {
                                                          checkModal.show();
                                                      });
                                                  });
                                              </script>";
                                              
                                        echo "<script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var rejectcModalId = 'rejectcModal-" . $currentIid . "';
                                                    var rejectcModalTrigger = document.getElementById('rejectcModalTrigger-" . $currentIid . "');
                                                    var rejectcModal = new bootstrap.Modal(document.getElementById(rejectcModalId));
                                                    
                                                    rejectcModalTrigger.addEventListener('click', function() {
                                                        rejectcModal.show();
                                                    });
                                                });
                                            </script>";

                                                echo "<button class='btn btn-warning m-1' type='button' id='checkmodalTrigger-" . $currentIid . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='material-icons' style='color: white;font-size:20px'>check</i>
                                              </button>";
                                                echo "<button type='button' class='btn btn-danger m-1' id='rejectcModalTrigger-" . $currentIid . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                <i class='las la-times' style='color: white; font-size:20px'></i>
                                            </button>";
                                            echo "</td>";
                                                echo "<div class='modal fade' role='dialog' tabindex='-1' id='checkIModal-" . $currentIid . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                    <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header' style='margin: 0px;'>
                                                                <h4 class='modal-title' style='color: rgb(0,0,0);'>Check Invoice</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='checkI' method='post' action='staffVerificationProcess.php?id=" . $fid . "'>
                                                                    <div class='container'>
                                                                      <p>Are you sure you want to approve this invoice?</p>
                                                                  </div>
                                                                    <div class='modal-footer'>
                                                                              <input type='hidden' name='form_type' value='I'>
                                                                              <input type='hidden' name='form_id' value='$currentIid'>
                                                                              <input type='hidden' name='order_id' value='$IAOid'>
                                                                              <input type='hidden' name='action' value='check'>
                                                                              <button type='submit' class='btn btn-primary'>Yes</button>
                                                                              <button type='submit' class='btn btn-secondary' data-bs-dismiss='modal'>No</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                                echo "<div class='modal fade' role='dialog' tabindex='-1' id='rejectcModal-" . $currentIid . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                  <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                      <div class='modal-content'>
                                                          <div class='modal-header' style='margin: 0px;'>
                                                              <h4 class='modal-title' style='color: rgb(0,0,0);'>Reject Invoice</h4>
                                                              <button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                          </div>
                                                          <div class='modal-body'>
                                                              <form id='rejectcI' method='post' action='reject.php?id=" . $fid . "'>
                                                                  <div class='container'>
                                                                      <p>Are you sure you want to reject this invoice?</p>
                                                                  </div>
                                                                  <div class='modal-footer'>
                                                                      <input type='hidden' name='form_id' value='$currentIid'>
                                                                      <input type='hidden' name='order_id' value='$IAOid'>
                                                                      <input type='hidden' name='action' value='rejectcheck'>
                                                                      <button type='submit' class='btn btn-danger'>Yes</button>
                                                                      <button type='submit' class='btn btn-secondary' data-bs-dismiss='modal'>No</button>
                                                                  </div>
                                                              </form>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>";

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
                <div class="card shadow" style="margin-left: 2%;margin-right: 2%;margin-top: 2%">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">All Invoice</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2" id="dataTableTI">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 18%;">Customer</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generation Date</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generated By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Checked By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Approved By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($rowti = mysqli_fetch_array($resulttinvoice)) {
                                            $hisIid = $rowti['I_id'];

                                            $sql_gnri1 = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$hisIid' AND tb_invoice_generation.D_progress = '1'";

                                            $resultgnri1 = mysqli_query($con, $sql_gnri1);

                                            $rowgnri1 = mysqli_fetch_array($resultgnri1);

                                            $sql_cki1 = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$hisIid' AND tb_invoice_generation.D_progress = '2'";

                                            $resultcki1 = mysqli_query($con, $sql_cki1);

                                            $rowcki1 = mysqli_fetch_array($resultcki1);

                                            $sql_appi = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$hisIid' AND tb_invoice_generation.D_progress = '3'";

                                            $resultappi = mysqli_query($con, $sql_appi);

                                            $rowappi = mysqli_fetch_array($resultappi);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $rowti['I_id'] . "</td>";
                                            echo "<td class='items2'>" . $rowti['C_name'] . "</td>";
                                            echo "<td class='items'>" . $rowti['I_issueDate'] . "</td>";
                                            echo "<td class='items'>" . $rowgnri1['U_name'] . "</td>";
                                            echo "<td class='items'>" . (isset($rowcki1['U_name']) ? $rowcki1['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . (isset($rowappi['U_name']) ? $rowappi['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . $rowti['O_desc'] . "</td>";
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

            <div id="deliveryOrdersTable" style="display: none;">
                <div class="card shadow" style="margin-left: 2%;margin-right: 2%;margin-top: 2%">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">All Delivery Orders</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2" id="dataTableTDO">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th style="width: 18%;">Customer</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generation Date</th>
                                        <th class='items' style="width: 18%;text-align:center;">Generated By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Approved By</th>
                                        <th class='items' style="width: 18%;text-align:center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($rowtdo = mysqli_fetch_array($resulttdo)) {
                                            $hisDOid = $rowtdo['DO_id'];

                                            $sql_gnrdo1 = "SELECT *
                                                       FROM tb_delivery_order
                                                       LEFT JOIN tb_do_generation ON tb_delivery_order.DO_id = tb_do_generation.DO_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_do_generation.U_id
                                                       WHERE tb_delivery_order.DO_id = '$hisDOid' AND tb_do_generation.D_progress = '1'";

                                            $resultgnrdo1 = mysqli_query($con, $sql_gnrdo1);

                                            $rowgnrdo1 = mysqli_fetch_array($resultgnrdo1);

                                            $sql_appdo = "SELECT *
                                                       FROM tb_delivery_order
                                                       LEFT JOIN tb_do_generation ON tb_delivery_order.DO_id = tb_do_generation.DO_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_do_generation.U_id
                                                       WHERE tb_delivery_order.DO_id = '$hisDOid' AND tb_do_generation.D_progress = '3'";

                                            $resultappdo = mysqli_query($con, $sql_appdo);

                                            $rowappdo = mysqli_fetch_array($resultappdo);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $rowtdo['DO_id'] . "</td>";
                                            echo "<td class='items2'>" . $rowtdo['C_name'] . "</td>";
                                            echo "<td class='items'>" . $rowtdo['DO_issueDate'] . "</td>";
                                            echo "<td class='items'>" . (isset($rowgnrdo1['U_name']) ? $rowgnrdo1['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . (isset($rowappdo['U_name']) ? $rowappdo['U_name'] : '-') . "</td>";
                                            echo "<td class='items'>" . $rowtdo['O_desc'] . "</td>";
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
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        function showDocuments(documentType) {
            var advertisementQuotationsTable = document.getElementById('advertisementQuotationsTable');
            var constructionQuotationsTable = document.getElementById('constructionQuotationsTable');
            var invoicesTable = document.getElementById('invoicesTable');
            var deliveryOrdersTable = document.getElementById('deliveryOrdersTable');

            if (documentType === 'advertisementQuotations') {
                advertisementQuotationsTable.style.display = 'block';
                constructionQuotationsTable.style.display = 'none';
                invoicesTable.style.display = 'none';
                deliveryOrdersTable.style.display = 'none';
            } else if (documentType === 'constructionQuotations') {
                advertisementQuotationsTable.style.display = 'none';
                constructionQuotationsTable.style.display = 'block';
                invoicesTable.style.display = 'none';
                deliveryOrdersTable.style.display = 'none';
            } else if (documentType === 'invoices') {
                advertisementQuotationsTable.style.display = 'none';
                constructionQuotationsTable.style.display = 'none';
                invoicesTable.style.display = 'block';
                deliveryOrdersTable.style.display = 'none';
            } else if (documentType === 'deliveryOrders') {
                advertisementQuotationsTable.style.display = 'none';
                constructionQuotationsTable.style.display = 'none';
                invoicesTable.style.display = 'none';
                deliveryOrdersTable.style.display = 'block';
            }
        }

        $(document).ready(function() {
            $('#dataTableTAQ').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 5 // Initial page length
            });


            $('#dataTableTCQ').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 5 // Initial page length
            });

            $('#dataTableIA').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 5 // Initial page length
            });

            $('#dataTableTI').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 5 // Initial page length
            });


            $('#dataTableTDO').DataTable({
                "lengthMenu": [5, 10, 25, 50],
                "pageLength": 5 // Initial page length
            });
        });
    </script>
<script src="assets/js/theme.js"></script>







