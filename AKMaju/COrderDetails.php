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

$co_id = $_GET['co_id'];

$sql_cq = "SELECT *
           FROM tb_construction_quotation
           LEFT JOIN tb_construction_order ON tb_construction_order.O_id = tb_construction_quotation.O_id
           LEFT JOIN tb_order_status ON tb_construction_quotation.CQ_status = tb_order_status.O_status
           WHERE tb_construction_order.O_id = '$co_id'";

$resultcq = mysqli_query($con, $sql_cq);  
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Construction Order</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
  <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="shortcut icon" type="image/jpg" href="assets/img/dogs/akmaju.jpg"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" href="assets/css/sidebar-style4.css">

</head>

<body id="page-top">
  <div id="wrapper">
    <?php include ('navbar.php');?>
    <div class="d-flex flex-column" id="content-wrapper">
      <div id="content">
        <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
          <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop"
              type="button"><i class="fas fa-bars"></i></button>
            <h3 class="text-dark mb-0">Construction Order Management</h3>
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
                              LEFT JOIN tb_construction_order co ON c.C_id = co.C_id
                              LEFT JOIN tb_customer_phone cp ON c.C_id = cp.C_id
                              WHERE co.O_id = ?"; // Using a placeholder for the AO_id value

                      // Prepare the statement
                      $stmt = mysqli_prepare($con, $sql);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmt, 's', $co_id);

                      // Execute the query
                      mysqli_stmt_execute($stmt);

                      // Get the result
                      $result = mysqli_stmt_get_result($stmt);

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
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-3">
            <div class="card-header py-3">
              <p class="text-primary m-0 fw-bold">Electric Information</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                  <thead>
                    <tr>
                      <th>Negeri</th>
                      <th>Daerah</th>
                      <th>Jarak</th>
                      <th>Tambahan Peratusan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      // Prepare the SQL statement
                      $sqlorder = "SELECT *
                       FROM tb_construction_order
                       JOIN tb_order_zone ON tb_construction_order.O_id = tb_order_zone.O_id
                       WHERE tb_construction_order.O_id = ? AND CM_ctgy = 1"; 

                      // Prepare the statement
                      $stmtorder = mysqli_prepare($con, $sqlorder);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmtorder, 's', $co_id);

                      // Execute the query
                      mysqli_stmt_execute($stmtorder);

                      // Get the result
                      $resultorder = mysqli_stmt_get_result($stmtorder);

                      // Check if the query executed successfully
                      if ($resultorder) {
                          // Fetch data and populate the table
                          $roworder = mysqli_fetch_assoc($resultorder);
                          echo "<tr>";
                          echo "<td>" . $roworder['Z_state'] . "</td>";
                          echo "<td>" . $roworder['Z_region'] . "</td>";
                          if($roworder['Z_distance']=='A'){
                            echo "<td>A: kurang dari 16km</td>";
                          } else if($roworder['Z_distance']=='B'){
                            echo "<td>B: 16-32km</td>";
                          } else if($roworder['Z_distance']=='C'){
                            echo "<td>C: 32-48km</td>";
                          } else if($roworder['Z_distance']=='D'){
                            echo "<td>D: lebih dari 48km</td>";
                          }

                          if($roworder['EK_addon']=='1'){
                            echo "<td style='max-width:200px;'>Tiada</td>";
                          } else if($roworder['EK_addon']=='2'){
                            echo "<td style='max-width:200px;'>Jalan ke tempat kerja hanya boleh dilalui oleh kenderaan darat berjentera beroda dua atau kenderaan berjentera yang mempunyai pacuan empat roda</td>";
                          } else if($roworder['EK_addon']=='3'){
                            echo "<td style='max-width:200px;'>Jalan ke tempat kerja hanya boleh dilalui menggunakan kenderaan air dengan mengharungi sungai, tasik atau laut, tanpa jambatan</td>";
                          }
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
              <p class="text-primary m-0 fw-bold">Kejuteraan Awam Information</p>
            </div>
            <div class="card-body">
              <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                  <thead>
                    <tr>
                      <th>Negeri</th>
                      <th>Daerah</th>
                      <th>Jarak</th>
                      <th>Tambahan Peratusan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Prepare the SQL statement
                      $sqlorder1 = "SELECT *
                       FROM tb_construction_order
                       JOIN tb_order_zone ON tb_construction_order.O_id = tb_order_zone.O_id
                       WHERE tb_construction_order.O_id = ? AND CM_ctgy = 2"; 

                      // Prepare the statement
                      $stmtorder1 = mysqli_prepare($con, $sqlorder1);

                      // Bind the parameter
                      mysqli_stmt_bind_param($stmtorder1, 's', $co_id);

                      // Execute the query
                      mysqli_stmt_execute($stmtorder1);

                      // Get the result
                      $resultorder1 = mysqli_stmt_get_result($stmtorder1);
                      $roworder1 = mysqli_fetch_assoc($resultorder1);

                      echo "<tr>";
                      echo "<td>" . $roworder1['Z_state'] . "</td>";
                      echo "<td>" . $roworder1['Z_region'] . "</td>";
                      if($roworder1['Z_distance']=='A'){
                        echo "<td>A: kurang dari 16km</td>";
                      } else if($roworder1['Z_distance']=='B'){
                        echo "<td>B: 16-32km</td>";
                      } else if($roworder1['Z_distance']=='C'){
                        echo "<td>C: 32-48km</td>";
                      } else if($roworder1['Z_distance']=='D'){
                        echo "<td>D: lebih dari 48km</td>";
                      }

                      if($roworder1['AK_addon']=='1'){
                        echo "<td style='max-width:200px;'>Tiada</td>";
                      } else if($roworder1['AK_addon']=='2'){
                        echo "<td style='max-width:200px;'>Jalan ke tempat kerja hanya boleh dilalui oleh kenderaan darat berjentera beroda dua atau kenderaan berjentera yang mempunyai pacuan empat roda</td>";
                      } else if($roworder1['AK_addon']=='3'){
                        echo "<td style='max-width:200px;'>alan ke tempat kerja tidak boleh dilalui oleh kenderaan berjentera</td>";
                      } else if($roworder1['AK_addon']=='4'){
                        echo "<td style='max-width:200px;'>Jalan ke tempat kerja tidak boleh dihalang oleh sungai tanpa jambatan ataupun laut</td>";
                      }
                      echo "</tr>";
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Upah Buruh / Sewa Logi</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTableNew">
                            <thead>
                                <tr>
                                    <th>Tukang / Logi</th>
                                    <th>Unit</th>
                                    <th>Kawasan</th>
                                    <th>Harga</th>
                                    <th>Jumlah Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql6 = "SELECT * FROM tb_order_rate
                                JOIN tb_rate ON tb_order_rate.AK_name = tb_rate.AK_name AND tb_order_rate.AK_region = tb_rate.AK_region AND tb_order_rate.AK_ctgy = tb_rate.AK_ctgy WHERE tb_order_rate.O_id = '$co_id'";
                                $result6 = $con->query($sql6);

                                // Check if there's any data
                                if ($result6->num_rows > 0) {
                                    // Output data of each row
                                    while ($row6 = $result6->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row6["AK_name"] . "</td>"; 
                                        echo "<td>" . $row6["AKR_unit"] . "</td>"; 
                                        echo "<td>" . $row6["AK_region"] . "</td>"; 
                                        echo "<td>RM" . $row6["AK_price"] . "</td>"; 
                                        echo "<td>RM" . $row6["AKR_unit"] * $row6["AK_price"] . "</td>";
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
                    <p class="text-primary m-0 fw-bold">Electric Material Selected</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTableNew">
                            <thead>
                                <tr>
                                    <th>Material ID</th>
                                    <th>Material Type</th>
                                    <th>Material Name</th>
                                    <th>Material Variation</th>
                                    <th>Material Unit</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Quantity</th>
                                    <th>Discount Percentage</th>
                                    <th>Discount Amount</th>
                                    <th>Tax Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sqlEmaterial = "SELECT co.*, cd.*, cmt.*
                                         FROM tb_co_material AS co
                                         INNER JOIN tb_construction_material AS cd 
                                         ON co.CM_variation = cd.CM_variation
                                         AND co.CM_id = cd.CM_id
                                         AND co.CM_type = cd.CM_type
                                         INNER JOIN tb_cm_type AS cmt 
                                         ON co.CM_type = cmt.CM_type
                                         WHERE co.O_id = '$co_id' AND cmt.CM_ctgy = '1'";
                                $resultEmaterial = $con->query($sqlEmaterial);

                                // Check if there's any data
                                if ($resultEmaterial->num_rows > 0) {
                                    // Output data of each row
                                    while ($rowEmaterial = $resultEmaterial->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $rowEmaterial["CM_id"] . "</td>"; 
                                        echo "<td>" . $rowEmaterial["T_desc"] . "</td>"; 
                                        echo "<td>" . $rowEmaterial["CM_name"] . "</td>"; 
                                        echo "<td>" . $rowEmaterial["CM_variation"] . "</td>"; 
                                        echo "<td>" . $rowEmaterial["COM_unit"] . " (" . $rowEmaterial["CM_unit"] . ")</td>";
                                        echo "<td>RM" . $rowEmaterial["CM_price"] . "</td>"; 
                                        echo "<td>RM" . $rowEmaterial["COM_price"] . "</td>"; 
                                        echo "<td>" . $rowEmaterial["COM_qty"] . "</td>"; 
                                        echo "<td>" . $rowEmaterial["COM_discPct"] . "%</td>"; 
                                        echo "<td>RM" . $rowEmaterial["COM_discAmt"] . "</td>"; 
                                        echo "<td>RM" . $rowEmaterial["COM_taxAmt"] . "</td>"; 
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
                    <p class="text-primary m-0 fw-bold">Kejuteraan Awam Material Selected</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTableNew">
                            <thead>
                                <tr>
                                    <th>Material ID</th>
                                    <th>Material Type</th>
                                    <th>Material Name</th>
                                    <th>Material Variation</th>
                                    <th>Material Unit</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Quantity</th>
                                    <th>Discount Percentage</th>
                                    <th>Discount Amount</th>
                                    <th>Tax Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sqlAKMaterial = "SELECT co.*, cd.*, cmt.*
                                         FROM tb_co_material AS co
                                         INNER JOIN tb_construction_material AS cd 
                                         ON co.CM_variation = cd.CM_variation
                                         AND co.CM_id = cd.CM_id
                                         AND co.CM_type = cd.CM_type
                                         INNER JOIN tb_cm_type AS cmt 
                                         ON co.CM_type = cmt.CM_type
                                         WHERE co.O_id = '$co_id' AND cmt.CM_ctgy = '2'";
                                $resultAKMaterial = $con->query($sqlAKMaterial);

                                // Check if there's any data
                                if ($resultAKMaterial->num_rows > 0) {
                                    // Output data of each row
                                    while ($rowAKMaterial = $resultAKMaterial->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $rowAKMaterial["CM_id"] . "</td>"; 
                                        echo "<td>" . $rowAKMaterial["T_desc"] . "</td>"; 
                                        echo "<td>" . $rowAKMaterial["CM_name"] . "</td>"; 
                                        echo "<td>" . $rowAKMaterial["CM_variation"] . "</td>"; 
                                        echo "<td>" . $rowAKMaterial["COM_unit"] . " (" . $rowAKMaterial["CM_unit"] . ")</td>";
                                        echo "<td>RM" . $rowAKMaterial["CM_price"] . "</td>"; 
                                        echo "<td>RM" . $rowAKMaterial["COM_price"] . "</td>"; 
                                        echo "<td>" . $rowAKMaterial["COM_qty"] . "</td>"; 
                                        echo "<td>" . $rowAKMaterial["COM_discPct"] . "%</td>"; 
                                        echo "<td>RM" . $rowAKMaterial["COM_discAmt"] . "</td>"; 
                                        echo "<td>RM" . $rowAKMaterial["COM_taxAmt"] . "</td>"; 
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
                            <p class="text-primary m-0 fw-bold">Quotation</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTableCQ">
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
                                    if (mysqli_num_rows($resultcq) == 0) {
                                        echo "<tr>";
                                        echo "<td id='no-items' colspan='8'>No quotation has been generated.</td>";
                                        echo "</tr>";
                                    } else {
                                        while ($row1 = mysqli_fetch_array($resultcq)) {
                                            $currentCQId = $row1['CQ_id'];

                                            $sql_gnrcq = "SELECT *
                                                       FROM tb_construction_quotation
                                                       LEFT JOIN tb_cq_generation ON tb_construction_quotation.CQ_id = tb_cq_generation.CQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_cq_generation.U_id
                                                       WHERE tb_construction_quotation.CQ_id = '$currentCQId' AND tb_cq_generation.D_progress = '1'";

                                            $resultgnrcq = mysqli_query($con, $sql_gnrcq);

                                            $rowgnrcq = mysqli_fetch_array($resultgnrcq);

                                            $sql_appcq = "SELECT *
                                                       FROM tb_construction_quotation
                                                       LEFT JOIN tb_cq_generation ON tb_construction_quotation.CQ_id = tb_cq_generation.CQ_id
                                                       LEFT JOIN tb_user ON tb_user.U_id = tb_cq_generation.U_id
                                                       WHERE tb_construction_quotation.CQ_id = '$currentCQId' AND tb_cq_generation.D_progress = '3'";

                                            $resultappcq = mysqli_query($con, $sql_appcq);

                                            $rowappcq = mysqli_fetch_array($resultappcq);

                                            echo "<tr>";
                                            echo "<td class='items1'>" . $currentCQId . "</td>";
                                            echo "<td class='items2'>" . ($row1['CQ_remark'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . $row1['CQ_issueDate'] . "</td>";
                                            echo "<td class='items'>" . $row1['CQ_dueDate'] . "</td>";
                                            echo "<td class='items'>" . $row1['O_desc'] . "</td>";
                                            echo "<td class='items'>" . ($rowgnrcq['U_name'] ?? '-') . "</td>";
                                            echo "<td class='items'>" . ($rowappcq['U_name'] ?? '-') . "</td>";


                                            echo "<script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var modalId = 'emailCQModal-" . $currentCQId . "';
                                                    var modalTrigger = document.getElementById('modalTrigger-" . $currentCQId . "');
                                                    var myModal = new bootstrap.Modal(document.getElementById(modalId));
                                                    modalTrigger.addEventListener('click', function() {
                                                        myModal.show();
                                                    });
                                                });
                                              </script>";

                                            $aid = $row1['O_id'];

                                            echo "<td class='items'>
                                                    <div style='display: flex; align-items: center; justify-content: center;'>
                                                      <a href='openCquotation.php?id=".$fid."&cqid=".$currentCQId."' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='fas fa-book-open'></i></a>";

                                                echo"
                                                </div>
                                                </td>";
                                            echo "</tr>";
                                            echo "<div class='modal fade' role='dialog' tabindex='-1' id='emailCQModal-" . $currentCQId . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                    <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header' style='margin: 0px;'>
                                                                <h4 class='modal-title' style='color: rgb(0,0,0);'>Email Construction Quotation</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='emailCQ' method='post' action='emailCQ.php?id=" . $fid . "'>
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
                                                                        <input type='hidden' name='CQ_id' value='$currentCQId'>
                                                                        <button class='btn btn-primary' type='submit' id='EmailCQ'>Send</button>
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
                                <th>Electric Total Cost</th>
                                <th>Kejuteraan Awam Total Cost</th>
                                <th>Total Cost</th>
                                <th>Total Price</th>
                                <th>Markup</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT
                                            tb_construction_order.O_id,
                                            tb_construction_order.O_date,
                                            tb_customer.C_name,
                                            tb_customer_phone.C_phone,
                                            tb_construction_order.COE_totalCost,
                                            tb_construction_order.COA_totalCost,
                                            tb_construction_order.O_totalCost,
                                            tb_construction_order.O_totalPrice,
                                            tb_construction_order.CO_markup
                                          FROM
                                            tb_construction_order
                                          JOIN
                                            tb_customer ON tb_construction_order.C_id = tb_customer.C_id
                                          JOIN
                                            tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
                                          WHERE
                                            tb_construction_order.O_id = ?"; 

                                $stmt = $con->prepare($query);
                                $stmt->bind_param("s", $co_id);

                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['O_id'] . "</td>"; // Corrected 'id' to 'C_id'
                                        echo "<td>" . $row['O_date'] . "</td>"; // Corrected 'date' to 'AO_date'
                                        echo "<td>" . $row['C_name'] . "</td>"; // Corrected 'customer_name' to 'C_name'
                                        echo "<td>" . $row['C_phone'] . "</td>"; // Corrected 'contact_number' to 'C_phone'
                                        echo "<td>RM" . $row['COE_totalCost'] . "</td>"; // Corrected 'total_cost' to 'AO_totalCost'
                                        echo "<td>RM" . $row['COA_totalCost'] . "</td>"; // Corrected 'total_cost' to 'AO_totalCost'
                                        echo "<td>RM" . $row['O_totalCost'] . "</td>"; // Corrected 'total_cost' to 'AO_totalCost'
                                        echo "<td>RM" . $row['O_totalPrice'] . "</td>"; // Corrected 'total_price' to 'AO_totalPrice'
                                        echo "<td>" . $row['CO_markup'] . "%</td>"; // Corrected 'total_price' to 'AO_totalPrice'
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No data found</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
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
  <script>
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10 // Initial page length
        });
    });
    </script>
</body>

</html>