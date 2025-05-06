<?php
include ('dbconnect.php');
include ('mysession.php');

$sql = "SELECT *
        FROM tb_customer
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        LEFT JOIN tb_agency_government ON tb_customer.C_id = tb_agency_government.C_id
        LEFT JOIN tb_ag_phone ON tb_agency_government.C_id = tb_ag_phone.C_id";

$result = mysqli_query($con,$sql);
$result1 = mysqli_query($con,$sql);
$result2 = mysqli_query($con,$sql);


$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$ao_id = $_GET['o_id'];

//AQ
$sql_aq = "SELECT *
           FROM tb_advertisement_quotation
           LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_advertisement_quotation.O_id
           LEFT JOIN tb_order_status ON tb_advertisement_quotation.AQ_status = tb_order_status.O_status
           WHERE tb_advertisement_order.O_id = '$ao_id'";

$resultaq = mysqli_query($con, $sql_aq); 


//Invoice
$sql_invoice = "SELECT *
                FROM tb_invoice
                LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_invoice.O_id
                LEFT JOIN tb_order_status ON tb_invoice.I_status = tb_order_status.O_status
                WHERE tb_advertisement_order.O_id = '$ao_id'";

$resulti = mysqli_query($con, $sql_invoice); 


//DO
$sql_do = "SELECT *
           FROM tb_delivery_order
           LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_delivery_order.O_id
           LEFT JOIN tb_order_status ON tb_delivery_order.DO_status = tb_order_status.O_status
           WHERE tb_advertisement_order.O_id = '$ao_id'";

//Execute
$resultdo = mysqli_query($con, $sql_do);
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Advertisement Order</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
  <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
  <link rel="shortcut icon" type="image/jpg" href="assets/img/dogs/akmaju.jpg"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" href="assets/bootstrap/css/verification.css">


</head>

<body id="page-top">
  <div id="wrapper">
    <?php include ('navbar.php');?>
    <div class="d-flex flex-column" id="content-wrapper">
      <div id="content">
        <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
          <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop"
              type="button"><i class="fas fa-bars"></i></button>
            <h3 class="text-dark mb-0">Advertisement Order Management</h3>
            <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
              <div class="input-group"></div>
            </form>
            <ul class="navbar-nav flex-nowrap ms-auto">
              <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false"
                  data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="me-auto navbar-search w-100">
                    <div class="input-group"><input class="bg-light form-control border-0 small" type="text"
                        placeholder="Search for ...">
                      <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i
                            class="fas fa-search"></i></button></div>
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
            <h3 class="text-dark mb-4">Order Details</h3>
          </div>
          <div class="card shadow mb-3">
            <div class="card-header py-3">
              <p class="text-primary m-0 fw-bold">Customer Information</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      // Prepare the SQL statement
                      $sql = "SELECT c.C_name, cp.C_phone, c.C_street, c.C_city, c.C_postcode, c.C_state, c.C_email
                              FROM tb_customer c
                              LEFT JOIN tb_advertisement_order ao ON c.C_id = ao.C_id
                              LEFT JOIN tb_customer_phone cp ON c.C_id = cp.C_id
                              WHERE ao.O_id = ?"; // Using a placeholder for the O_id value

                      // Prepare the statement
                      $stmt = mysqli_prepare($con, $sql);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmt, 's', $ao_id);

                      // Execute the query
                      mysqli_stmt_execute($stmt);

                      if (mysqli_stmt_error($stmt)) {
                          // Print any errors
                          echo "Error executing statement: " . mysqli_stmt_error($stmt);
                      } else {
                          // Get the result
                          $result = mysqli_stmt_get_result($stmt);
                      }

                      // Check if the query executed successfully
                      if ($result) {
                          // Fetch data and populate the table
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>";
                              echo "<td>" . $row['C_name'] . "</td>";
                              echo "<td>" . $row['C_phone'] . "</td>";
                              echo "<td>" . $row['C_email'] . "</td>";
                              echo "<td>" . $row['C_street'] . ", " . $row['C_city'] . ", " . $row['C_postcode'] . ", " . $row['C_state'] . "</td>";
                              echo "</tr>";
                          }
                      } else {
                          // Print any errors
                          echo "Error: " . mysqli_error($con);
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-3">
            <div class="card-header py-3">
              <p class="text-primary m-0 fw-bold">Order Material</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable2">
                  <thead>
                    <tr>
                      <th>Material Name</th>
                      <th>Material Variation</th>
                      <th>Material Dimension</th>
                      <th>Material Price</th>
                      <th>Material Cost</th>
                      <th>Material MarkUp</th>
                      <th>Quantity</th>
                      <th>Material Unit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      // Prepare the SQL statement
                      $sql = "SELECT m.AM_name, m.AM_variation, m.AM_dimension, om.AOM_adjustprice, om.AOM_origincost, om.AOM_qty, om.AOM_unit, m.AM_unit
                        FROM tb_ao_material om
                        INNER JOIN tb_advertisement_order ao ON om.O_id = ao.O_id
                        INNER JOIN tb_advertisement_material m ON om.AM_id = m.AM_id
                        WHERE ao.O_id = ?"; // Using a placeholder for the AO_id value

                      // Prepare the statement
                      $stmt = mysqli_prepare($con, $sql);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmt, 's', $ao_id);

                      // Execute the query
                      mysqli_stmt_execute($stmt);

                      // Get the result
                      $result = mysqli_stmt_get_result($stmt);

                      // Check if the query executed successfully
                      if ($result) {
                          // Fetch data and populate the table
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>";
                              echo "<td>" . $row['AM_name'] . "</td>";
                              echo "<td>" . $row['AM_variation'] . "</td>";
                              echo "<td>" . $row['AM_dimension'] . "</td>";
                              echo "<td>" . $row['AOM_adjustprice'] . "</td>";
                              echo "<td>" . $row['AOM_origincost'] . "</td>";
                              $price = $row['AOM_adjustprice'];
                              $cost = $row['AOM_origincost'];
                              $markup = ($price - $cost) / $cost * 100; // Calculate markup percentage
                              echo "<td>" . $markup . "%</td>"; // Display the markup percentage
                              echo "<td>" . $row['AOM_qty'] . "</td>";
                              echo "<td>" . $row['AOM_unit'] . $row['AM_unit'] . "</td>"; 
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
              <p class="text-primary m-0 fw-bold">Order Status</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                  <thead>
                    <tr>
                      <th>Quotation Status</th>
                      <th>Invoice Status</th>
                      <th>Payment Status</th>
                      <th>Delivery Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php

                      // Prepare the SQL statement
                      $sql = "SELECT AO_deliveryStatus AS AOD, O_quotationStatus AS AOQ, AO_invoiceStatus AS AOI, AO_paymentStatus AS AOP
                              FROM tb_advertisement_order
                              WHERE O_id = ?";

                      // Prepare the statement
                      $stmt = mysqli_prepare($con, $sql);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmt, 's', $ao_id);

                      // Execute the query
                      mysqli_stmt_execute($stmt);

                      // Get the result
                      $result = mysqli_stmt_get_result($stmt);

                      if ($result) {
                          $statusColumns = ['AOD', 'AOQ', 'AOI', 'AOP'];

                          // Fetch the status values
                          $row = mysqli_fetch_assoc($result);

                          foreach ($statusColumns as $column) {
                              // Retrieve each status value
                              $$column = $row[$column];

                              // Prepare the SQL statement to fetch O_desc based on each status
                              $sql2 = "SELECT O_desc FROM tb_order_status WHERE O_status = ?";

                              // Prepare the statement
                              $stmt2 = mysqli_prepare($con, $sql2);

                              // Bind the parameter
                              mysqli_stmt_bind_param($stmt2, 'i', $$column);

                              // Execute the query
                              mysqli_stmt_execute($stmt2);

                              // Get the result
                              $result2 = mysqli_stmt_get_result($stmt2);

                              if ($result2 && $row2 = mysqli_fetch_assoc($result2)) {
                                  echo "<td>" . $row2['O_desc'] . "</td>";
                              }
                          }
                      }
                      
                    ?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-3">
                        <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Quotation</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTableAQ">
                                    <thead>
                                        <tr>
                                            <th style="width: 8%;padding-left: 25px;">ID</th>
                                            <th style="width: 13%;">Remark</th>
                                            <th style="width: 13%;text-align: center;">Issue Date</th>
                                            <th style="width: 13%;text-align: center;">Due Date</th>
                                            <th style="width: 13%;text-align: center;">Status</th>
                                            <th style="width: 13%;text-align: center;">Prepared By</th>
                                            <th style="text-align: center;width: 13%;">Approved By</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    if (mysqli_num_rows($resultaq) == 0) {
                                        echo "<tr>";
                                        echo "<td id='no-items' colspan='8'>No quotation has been generated.</td>";
                                        echo "</tr>";
                                    } else {
                                        while ($row1 = mysqli_fetch_array($resultaq)) {
                                            $currentAQId = $row1['AQ_id'];

                                            $sql_gnraq = "SELECT *
                                                       FROM tb_advertisement_quotation
                                                       LEFT JOIN tb_aq_generation ON tb_advertisement_quotation.AQ_id = tb_aq_generation.AQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_aq_generation.U_id
                                                       WHERE tb_advertisement_quotation.AQ_id = '$currentAQId' AND tb_aq_generation.D_progress = '1'";

                                            $resultgnraq = mysqli_query($con, $sql_gnraq);

                                            $rowgnraq = mysqli_fetch_array($resultgnraq);

                                            $sql_appaq = "SELECT *
                                                       FROM tb_advertisement_quotation
                                                       LEFT JOIN tb_aq_generation ON tb_advertisement_quotation.AQ_id = tb_aq_generation.AQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_aq_generation.U_id
                                                       WHERE tb_advertisement_quotation.AQ_id = '$currentAQId' AND tb_aq_generation.D_progress = '3'";

                                            $resultappaq = mysqli_query($con, $sql_appaq);

                                            $rowappaq = mysqli_fetch_array($resultappaq);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $currentAQId . "</td>";
                                            echo "<td class='items2'>" . ($row1['AQ_remark'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . $row1['AQ_issueDate'] . "</td>";
                                            echo "<td class='items'>" . $row1['AQ_dueDate'] . "</td>";
                                            echo "<td class='items'>" . $row1['O_desc'] . "</td>";
                                            echo "<td class='items'>" . ($rowgnraq['U_name'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . ($rowappaq['U_name'] ?? '-') . "</td>";


                                            echo "<script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var modalId = 'emailAQModal-" . $currentAQId . "';
                                                    var modalTrigger = document.getElementById('modalTrigger-" . $currentAQId . "');
                                                    var myModal = new bootstrap.Modal(document.getElementById(modalId));
                                                    modalTrigger.addEventListener('click', function() {
                                                        myModal.show();
                                                    });
                                                });
                                              </script>";

                                            $aid = $row1['O_id'];

                                            echo "<td class='items'>
                                                    <div style='display: flex; align-items: center; justify-content: center;'>
                                                      <a href='openAquotation.php?id=".$fid."&aqid=".$currentAQId."' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='fas fa-book-open'></i></a>";
                                                echo"
                                                </div>
                                                </td>";
                                            echo "</tr>";
                                            echo "<div class='modal fade' role='dialog' tabindex='-1' id='emailAQModal-" . $currentAQId . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                    <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header' style='margin: 0px;'>
                                                                <h4 class='modal-title' style='color: rgb(0,0,0);'>Email Advertisement Quotation</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='emailAQ' method='post' action='emailAQ.php?id=" . $fid . "'>
                                                                    <div class='container'>
                                                                        <div class='col-md-12'>
                                                                            <label class='email'>Email</label><br>
                                                                            <input placeholder='Enter the email address' class='form-control' type='email' name='email'><br>
                                                                        </div>
                                                                        <div class='col-md-6'>
                                                                            <label class='emailContent'></label><br>
                                                                            <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent'></textarea><br>    
                                                                        </div>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <input type='hidden' name='AQ_id' value='$currentAQId'>
                                                                        <button class='btn btn-primary' type='submit' id='EmailAQ'>Send</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
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
                    </div>
                </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <div>
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Invoice</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTableI">
                                    <thead>
                                        <tr>
                                            <th style="width: 8%;padding-left: 25px;">ID</th>
                                            <th style="width: 10%;">Remark</th>
                                            <th style="width: 10%;text-align: center;">Issue Date</th>
                                            <th style="width: 10%;text-align: center;">Expiry Date</th>
                                            <th style="width: 10%;text-align: center;">Status</th>
                                            <th style="text-align: center;">Prepared By</th>
                                            <th style="text-align: center;">Checked By</th>
                                            <th style="text-align: center;">Approved By</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                                    if (mysqli_num_rows($resulti) == 0) {
                                        echo "<tr>";
                                        echo "<td id='no-items' colspan='9'>No invoice has been generated.</td>";
                                        echo "</tr>";
                                    } else {
                                        while ($rowi = mysqli_fetch_array($resulti)) {
                                            $currentiId = $rowi['I_id'];

                                            $sql_gnri = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$currentiId' AND tb_invoice_generation.D_progress = '1'";

                                            $resultgnri = mysqli_query($con, $sql_gnri);

                                            $rowgnri = mysqli_fetch_array($resultgnri);

                                            $sql_cki = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$currentiId' AND tb_invoice_generation.D_progress = '2'";

                                            $resultcki = mysqli_query($con, $sql_cki);

                                            $rowcki = mysqli_fetch_array($resultcki);

                                            $sql_appi = "SELECT *
                                                       FROM tb_invoice
                                                       LEFT JOIN tb_invoice_generation ON tb_invoice.I_id = tb_invoice_generation.I_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_invoice_generation.U_id
                                                       WHERE tb_invoice.I_id = '$currentiId' AND tb_invoice_generation.D_progress = '3'";

                                            $resultappi = mysqli_query($con, $sql_appi);

                                            $rowappi = mysqli_fetch_array($resultappi);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $currentiId . "</td>";
                                            echo "<td class='items1'>" . ($rowi['I_remark'] ? $rowi['I_remark'] : '-') . "</td>";
                                            echo "<td class='items'>" . $rowi['I_issueDate'] . "</td>";
                                            echo "<td class='items'>" . $rowi['I_expiryDate'] . "</td>";
                                            echo "<td class='items'>" . $rowi['O_desc'] . "</td>";
                                            echo "<td class='items'>" . ($rowgnri['U_name'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . ($rowcki['U_name'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . ($rowappi['U_name'] ?? '-') . "</td>";

                                            echo"<script>
                                              document.addEventListener('DOMContentLoaded', function() {
                                                 var modalId2 = 'emailIModal-" . $currentiId . "';
                                                 var modalTrigger2 = document.getElementById('modalTrigger2-" . $currentiId . "');
                                                 var myModal2 = new bootstrap.Modal(document.getElementById(modalId2));
                                                 modalTrigger2.addEventListener('click', function() {
                                                     myModal2.show();
                                                 });
                                               });
                                              </script>";
                    

                                            $aid = $rowi['O_id'];

                                            echo "<td class='items'>
                                                    <div style='display: flex; align-items: center; justify-content: center;'>
                                                      <a href='openInvoice.php?id=".$fid."&iid=".$currentiId."' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='fas fa-book-open'></i></a>";

                                            echo "
                                                  </div>
                                                </td>";
                                            echo "</tr>";
                                            echo "<div class='modal fade' role='dialog' tabindex='-1' id='emailIModal-" . $currentiId . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header' style='margin: 0px;'>
                                                            <h4 class='modal-title' style='color: rgb(0,0,0);'>Email Invoice</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <form id='emailI' method='post' action='emailInvoice.php?id=" . $fid. "'>
                                                                <div class='container'>
                                                                    <div class='col-md-12'>
                                                                        <label class='email'>Email</label><br>
                                                                        <input placeholder='Enter the email address' class='form-control' type='email' name='email'><br>
                                                                    </div>
                                                                    <div class='col-md-6'>
                                                                        <label class='emailContent'></label><br>
                                                                        <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent'></textarea><br>    
                                                                    </div>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <input type='hidden' name='I_id' value='$currentiId'>
                                                                    <button class='btn btn-primary' type='submit' id='EmailI'>Send</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
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
                    </div>
                </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <div>
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Delivery Order</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTableDO">
                                    <thead>
                                        <tr>
                                            <th style="width: 8%;padding-left: 25px;">ID</th>
                                            <th style="width: 13%;">Remark</th>
                                            <th style="width: 13%;text-align: center;">Issue Date</th>
                                            <th style="width: 13%;text-align: center;">Delivery Date</th>
                                            <th style="width: 13%;text-align: center;">Status</th>
                                            <th style="width: 13%;text-align: center;">Prepared By</th>
                                            <th style="text-align: center;width: 13%;">Approved By</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (mysqli_num_rows($resultdo) == 0) {
                                        echo "<tr>";
                                        echo "<td id='no-items' colspan='8'>No delivery order has been generated.</td>";
                                        echo "</tr>";
                                    } 
                                    else {
                                        while ($rowdo = mysqli_fetch_array($resultdo)) {
                                            $currentdoId = $rowdo['DO_id'];

                                            $sql_gnrdo = "SELECT *
                                                       FROM tb_delivery_order
                                                       LEFT JOIN tb_do_generation ON tb_delivery_order.DO_id = tb_do_generation.DO_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_do_generation.U_id
                                                       WHERE tb_delivery_order.DO_id = '$currentdoId' AND tb_do_generation.D_progress = '1'";

                                            $resultgnrdo = mysqli_query($con, $sql_gnrdo);

                                            $rowgnrdo = mysqli_fetch_array($resultgnrdo);

                                            $sql_appdo = "SELECT *
                                                       FROM tb_delivery_order
                                                       LEFT JOIN tb_do_generation ON tb_delivery_order.DO_id = tb_do_generation.DO_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_do_generation.U_id
                                                       WHERE tb_delivery_order.DO_id = '$currentdoId' AND tb_do_generation.D_progress = '3'";

                                            $resultappdo = mysqli_query($con, $sql_appdo);

                                            $rowappdo = mysqli_fetch_array($resultappdo);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $rowdo['DO_id'] . "</td>";
                                            echo "<td class='items1'>" . ($rowdo['DO_remark'] ? $rowdo['DO_remark'] : '-') . "</td>";
                                            echo "<td class='items'>" . $rowdo['DO_issueDate'] . "</td>";
                                            echo "<td class='items'>" . $rowdo['DO_deliveryDate'] . "</td>";
                                            echo "<td class='items'>" . $rowdo['O_desc'] . "</td>";
                                            echo "<td class='items'>" . ($rowgnrdo['U_name'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . ($rowappdo['U_name'] ?? '-') . "</td>";

                                            echo"<script>
                                              document.addEventListener('DOMContentLoaded', function() {
                                                 var modalId3 = 'emailDOModal-" . $currentdoId . "';
                                                 var modalTrigger3 = document.getElementById('modalTrigger3-" . $currentdoId . "');
                                                 var myModal3 = new bootstrap.Modal(document.getElementById(modalId3));
                                                 modalTrigger3.addEventListener('click', function() {
                                                     myModal3.show();
                                                 });
                                               });
                                              </script>";

                                            $adoid = $rowdo['O_id'];

                                            echo "<td class='items'>
                                                    <div style='display: flex; align-items: center; justify-content: center;'>
                                                        <a href='openDO.php?id=".$fid."&doid=".$currentdoId."' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='fas fa-book-open'></i></a>";
                                            echo"
                                                </div>
                                                </td>";
                                            echo "</tr>";
                                            echo "<div class='modal fade' role='dialog' tabindex='-1' id='emailDOModal-" . $currentdoId . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header' style='margin: 0px;'>
                                                            <h4 class='modal-title' style='color: rgb(0,0,0);'>Email Delivery Order</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <form id='emailDO' method='post' action='emailDO.php?id=" . $fid . "'>
                                                                <div class='container'>
                                                                    <div class='col-md-12'>
                                                                        <label class='email'>Email</label><br>
                                                                        <input placeholder='Enter the email address' class='form-control' type='email' name='email'><br>
                                                                    </div>
                                                                    <div class='col-md-6'>
                                                                        <label class='emailContent'></label><br>
                                                                        <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent'></textarea><br>    
                                                                    </div>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <input type='hidden' name='DO_id' value='$currentdoId'>
                                                                    <button class='btn btn-primary' type='submit' id='EmailDO'>Send</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
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
                    </div>
                </div>
          <div class="card shadow mb-3">
            <div class="card-header py-3">
              <p class="text-primary m-0 fw-bold">Order Payment</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                  <thead>
                    <tr>
                      <th>Deposit Amount</th>
                      <th>Payment Method</th>
                      <th>Payment Date</th>
                      <th>Terms of Payment</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      // Prepare the SQL statement
                      $sql = "SELECT ao.AO_deposit, aop.P_desc, ao.AO_payDate, top.TOP_desc
                              FROM tb_advertisement_order ao
                              INNER JOIN tb_terms_of_payment top ON ao.O_TOP = top.TOP_id
                              INNER JOIN tb_paymethod aop ON ao.AO_payMethod = aop.P_id
                              WHERE ao.O_id = ?"; // Using a placeholder for the AO_id value

                      // Prepare the statement
                      $stmt = mysqli_prepare($con, $sql);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmt, 's', $ao_id);

                      // Execute the query
                      mysqli_stmt_execute($stmt);

                      // Get the result
                      $result = mysqli_stmt_get_result($stmt);

                      // Check if the query executed successfully
                      if ($result) {
                          // Fetch data and populate the table
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>";
                              echo "<td>RM" . $row['AO_deposit'] . "</td>";
                              echo "<td>" . $row['P_desc'] . "</td>";
                              echo "<td>" . $row['AO_payDate'] . "</td>";
                              echo "<td>" . $row['TOP_desc'] . "</td>";
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
              <p class="text-primary m-0 fw-bold">Order Overall</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                  <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Order Date</th>
                      <th>Customer Name</th>
                      <th>Contact Number</th>
                      <th>Total Cost</th>
                      <th>Total Price</th>
                      <th>Order Remark</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      // Prepare the SQL statement
                      $sql1 = "SELECT ao.O_date, c.C_name, cp.C_phone, ao.O_totalCost, ao.O_totalPrice, ao.O_remark
                              FROM tb_advertisement_order ao
                              LEFT JOIN tb_customer c ON ao.C_id = c.C_id
                              LEFT JOIN tb_customer_phone cp ON ao.C_id = cp.C_id
                              WHERE ao.O_id = ?"; // Using a placeholder for the AO_id value

                      // Prepare the statement
                      $stmt1 = mysqli_prepare($con, $sql1);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmt1, 's', $ao_id);

                      // Execute the query
                      mysqli_stmt_execute($stmt1);

                      // Get the result
                      $result1 = mysqli_stmt_get_result($stmt1);

                      // Check if the query executed successfully
                      if ($result1) {
                          // Fetch data and populate the table
                          while ($row1 = mysqli_fetch_assoc($result1)) {
                              echo "<tr>";
                              echo "<td>" . $ao_id . "</td>";
                              echo "<td>" . $row1['O_date'] . "</td>";
                              echo "<td>" . $row1['C_name'] . "</td>";
                              echo "<td>" . $row1['C_phone'] . "</td>";
                              echo "<td>RM". $row1['O_totalCost'] . "</td>";
                              echo "<td>RM". $row1['O_totalPrice'] . "</td>";
                              echo "<td>" . $row1['O_remark'] . "</td>";
                              echo "</tr>";
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
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/bs-init.js"></script>
  <script src="assets/js/theme.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10 // Initial page length
        });
    });
    </script>
    <?php 
// Script for event delegation
echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener for the common parent element
            document.getElementById('dataTableAQ').addEventListener('click', function (event) {
                console.log('Clicked on:', event.target);
                if (event.target.id === 'EmailAQ') {
                    console.log('EmailAQ button clicked');
                    // Handle the EmailAQ button click
                    event.target.textContent = 'Sending...';
                    var formData = new FormData(document.getElementById('AQ'));
                    fetch('A_quotation.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(response => {
                        if (response.trim() === 'Message sent!') {
                            document.getElementById('AQ').style.display = 'none';
                            document.getElementById('successMessage').style.display = 'block';
                        } else {
                            alert('Failed to send email. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error sending email. Please try again.');
                    });
                } else if (event.target.id && event.target.id.startsWith('modalTrigger-')) {
                    console.log('Modal trigger clicked');
                    // Handle modal triggers
                    var modalId = 'emailAQModal-' + event.target.id.split('-')[1];
                    var myModal = new bootstrap.Modal(document.getElementById(modalId));
                    myModal.show();
                }
            });
        });
    </script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener for the common parent element
            document.getElementById('dataTableI').addEventListener('click', function (event) {
                console.log('Clicked on:', event.target);
                if (event.target.id === 'EmailI') {
                    console.log('EmailI button clicked');
                    // Handle the EmailI button click
                    event.target.textContent = 'Sending...';
                    var formData = new FormData(document.getElementById('I'));
                    fetch('invoice.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(response => {
                        if (response.trim() === 'Message sent!') {
                            document.getElementById('I').style.display = 'none';
                            document.getElementById('successMessage').style.display = 'block';
                        } else {
                            alert('Failed to send email. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error sending email. Please try again.');
                    });
                } else if (event.target.id && event.target.id.startsWith('modalTrigger2-')) {
                    console.log('Modal trigger clicked');
                    // Handle modal triggers
                    var modalId = 'emailAQModal-' + event.target.id.split('-')[1];
                    var myModal = new bootstrap.Modal(document.getElementById(modalId));
                    myModal.show();
                }
            });
        });
    </script>";

?>

<script>
$(document).ready(function() {
    $("#generateButton").click(function () {
        $("#AquotationForm")[0].reset();
        $("#generateModal").modal("show");
    });

    $('#GenerateAQ').on('click', function () {
        $.ajax({
            type: "POST",
            url: "A_quotation.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#AquotationForm").serialize(),
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");

                // Close the modal after successful generation
                $("#generateModal").modal("hide");
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Error generating document. Please try again.");
            }
        });
    });

    $("#generateIButton").click(function () {
        console.log("Generate I button clicked");
        $("#IForm")[0].reset();
        $("#generateIModal").modal("show");
    });

    $('#GenerateI').on('click', function () {
        console.log("Generate I submit button clicked");
        $.ajax({
            type: "POST",
            url: "invoice.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#IForm").serialize(),  // Corrected selector
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");

                // Close the modal after successful generation
                $("#generateIModal").modal("hide");
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Error generating document. Please try again.");
            }
        });
    });

    $("#generateDOButton").click(function () {
        console.log("Generate DO button clicked");
        $("#DOForm")[0].reset();
        $("#generateDOModal").modal("show");
    });

    $('#GenerateDO').on('click', function () {
        console.log("Generate DO submit button clicked");
        $.ajax({
            type: "POST",
            url: "deliveryorder.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#DOForm").serialize(),  // Corrected selector
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");

                // Close the modal after successful generation
                $("#generateDOModal").modal("hide");
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Error generating document. Please try again.");
            }
        });
    });


    $('#AQ-submit').on('click', function () {
        $(this).text('Sending...');
        $.ajax({
            type: "POST",
            url: "A_quotation.php",
            data: $("#AQ").serialize(),
            success: function (response) {
                if ($.trim(response) === "Message sent!") {
                    $("#AQ").hide();
                    $("#successMessage").show();
                } else {
                    alert("Failed to send email. Please try again.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Error sending email. Please try again.");
            }
        });
    });
});

</script>
</body>

</html>