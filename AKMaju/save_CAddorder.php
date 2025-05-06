<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

$sqlEmaterial = "SELECT * FROM tb_co_material
                LEFT JOIN tb_cm_type ON tb_co_material.CM_type = tb_cm_type.CM_type
                WHERE tb_co_material.O_id = '$co_id' AND tb_cm_type.CM_ctgy = '1'";

$resultEmaterial = mysqli_query($con, $sqlEmaterial);

$total_EMaterial = 0; // Initialize total to zero

while ($rowEmaterial = mysqli_fetch_array($resultEmaterial)) {
    // Assuming 'COM_price' is the column containing the material price
    $total_EMaterial += $rowEmaterial['COM_price'];
}


$resultEmaterial = mysqli_query($con, $sqlEmaterial);

$sqlEKawasan = "SELECT Z_perc
                FROM tb_zone
                JOIN tb_order_zone ON tb_zone.Z_state = tb_order_zone.Z_state
                                 AND tb_zone.Z_region = tb_order_zone.Z_region AND tb_zone.CM_ctgy = tb_order_zone.CM_ctgy
                WHERE tb_order_zone.CM_ctgy = 1
                  AND tb_order_zone.O_id = '$co_id'";

$resultEKawasan = mysqli_query($con, $sqlEKawasan);
$rowEKawasan = mysqli_fetch_array($resultEKawasan);

$EK_addon = $row6['EK_addon'];

if ($EK_addon == '1') {
    $EK_Tperc = 0;
} else if ($EK_addon == '2') {
    $EK_Tperc = 2;
} else if ($EK_addon == '3') {
    $EK_Tperc = 5;
}

$total_EMaterial = ((100 + $EK_Tperc + $rowEKawasan['Z_perc']) / 100) * $total_EMaterial;

$sqlAKmaterial = "SELECT * FROM tb_co_material
                LEFT JOIN tb_cm_type ON tb_co_material.CM_type = tb_cm_type.CM_type
                WHERE tb_co_material.O_id = '$co_id' AND tb_cm_type.CM_ctgy = '2'";

$resultAKmaterial = mysqli_query($con, $sqlAKmaterial);

$total_AKMaterial = 0; // Initialize total to zero

while ($rowAKmaterial = mysqli_fetch_array($resultAKmaterial)) {
    // Assuming 'COM_price' is the column containing the material price
    $total_AKMaterial += $rowAKmaterial['COM_price'];
}


$resultAKmaterial = mysqli_query($con, $sqlAKmaterial);

$sqlAKawasan = "SELECT Z_perc
                FROM tb_zone
                JOIN tb_order_zone ON tb_zone.Z_state = tb_order_zone.Z_state
                                 AND tb_zone.Z_region = tb_order_zone.Z_region AND tb_zone.CM_ctgy = tb_order_zone.CM_ctgy
                WHERE tb_order_zone.CM_ctgy = 2
                  AND tb_order_zone.O_id = '$co_id'";

$resultAKawasan = mysqli_query($con, $sqlAKawasan);
$rowAKawasan = mysqli_fetch_array($resultAKawasan);

$AK_addon = $row6['AK_addon'];

if ($AK_addon == '1') {
    $AK_Tperc = 0;
} else if ($AK_addon == '2') {
    $AK_Tperc = 2;
} else if ($AK_addon == '3') {
    $AK_Tperc = 5;
} else if ($AK_addon == '4') {
    $AK_Tperc = 5;
}

$sqlAKadar = "SELECT AK_price FROM tb_rate
              JOIN tb_order_rate ON tb_rate.AK_name = tb_order_rate.AK_name AND tb_rate.AK_ctgy = tb_order_rate.AK_ctgy AND tb_rate.AK_region = tb_order_rate.AK_region
                WHERE O_id = '$co_id'";

$resultAKadar = mysqli_query($con, $sqlAKadar);

$total_AKadar = 0; // Initialize total to zero

while ($rowAKadar = mysqli_fetch_array($resultAKadar)) {
    // Assuming 'COM_price' is the column containing the material price
    $total_AKadar += $rowAKadar['AK_price'];
};

$total_AKMaterial += $total_AKadar;

$total_AKMaterial = ((100 + $AK_Tperc + $rowAKawasan['Z_perc']) / 100) * $total_AKMaterial;

$totalCost = $total_AKMaterial + $total_EMaterial;

$totalPrice = ((100 + $row6['CO_markup'])/100)*$totalCost;

// Update tb_construction_order with the total material cost
$sqlUpdate = "UPDATE tb_construction_order SET COE_totalCost = '$total_EMaterial', COA_totalCost  = '$total_AKMaterial', O_totalCost = '$totalCost', O_totalPrice = '$totalPrice'
              WHERE O_id = '$co_id'";

$resultUpdate = mysqli_query($con, $sqlUpdate);

$sql_cq = "SELECT *
           FROM tb_construction_quotation
           LEFT JOIN tb_construction_order ON tb_construction_order.O_id = tb_construction_quotation.O_id
           LEFT JOIN tb_order_status ON tb_construction_quotation.CQ_status = tb_order_status.O_status
           WHERE tb_construction_order.O_id = '$co_id'";

$resultcq = mysqli_query($con, $sql_cq); 

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

include ('COrderheader.php');
?>

<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Construction Order Management</h3>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form><ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" id="searchField" name="searchField" placeholder="Search for ...">
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
                        <h3 class="text-dark mb-4">Add Order</h3>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Add Order Material</p>
                        </div>
                        <div class="card-body">
                            <?php
                                echo "<form method='get' onsubmit='return validateForm()' action='save_markup.php?id=".$rows['U_id']."&co_id=$co_id'>";
                            ?>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="OMarkup"><strong>Order Markup</strong></label>
                                        <input class="form-control" type="text" id="OMarkup" placeholder="Profit (%)" name="OMarkup"><input type='hidden' name='co_id' value='<?php echo $co_id; ?>'><input type='hidden' name='id' value='<?php echo $fid; ?>'>
                                    </div>
                                </div>
                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save Markup</button></div>
                            </div>
                            </form>
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
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Quotation</p>
                        </div>
                        <div class="card-body">
                             <button id="generateButton"class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#generateModal">Generate</button>
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
                                            echo "<button type='button' class='btn btn-success m-1' id='modalTrigger-" . $currentCQId . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                <i class='fa fa-send' style='color: white;'></i>";
                                                echo "</button>";

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
                                                                            <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent' required></textarea><br>    
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
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" role="dialog" tabindex="-1" id="generateModal" style="margin: 0px;margin-top: 0px;text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0,0,0);">Generate Construction Quotation</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="CquotationForm" method="post" action="">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="remark">Remark</label><br>
                                <input placeholder="(Optional)" class="form-control" type="text" name="remark" maxlength="50"><br>
                            </div>
                            <div class="col-md-6">
                                <label class="issueDate">Issue Date</label><br>
                                <input class="form-control" type="date" id="issueDate" name="issueDate" value="<?php echo date('Y-m-d'); ?>"><br>
                            </div>
                            <div class="col-md-6">
                                <label class="dueDate">Due Date</label><br>
                                <input class="form-control" type="date" id="dueDate" name="dueDate" required
                                    min="<?php echo date('Y-m-d'); ?>" max="2030-12-31"><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="CO_id" value="<?php echo $co_id; ?>">
                            <input type="hidden" name="U_id" value="<?php echo $fid; ?>">
                            <button class="btn btn-primary" type="button" id="GenerateCQ">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/addorder.js"></script>
    
<script>
$(document).ready(function() {
    $("#generateButton").click(function () {
        $("#CquotationForm")[0].reset();
        $("#generateModal").modal("show");
    });

    $('#GenerateCQ').on('click', function () {
        var dueDate = $("#dueDate").val();

        if (!dueDate) {
            alert('Please fill out all required fields.');
            return;
        }
        $.ajax({
            type: "POST",
            url: "generateCQ.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#CquotationForm").serialize(),
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");
                window.location.href = "save_CEditorder.php?id=<?php echo urlencode($rows['U_id']); ?>&co_id=<?php echo $co_id; ?>";

                // Close the modal after successful generation
                $("#generateModal").modal("hide");
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Error generating document. Please try again.");
            }
        });
    });
});

</script>

<?php 
// ... Close other statements
$con->close();
?>