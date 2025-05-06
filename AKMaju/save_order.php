<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$ao_id = $_GET['o_id'];

$sql_aq = "SELECT *
           FROM tb_advertisement_quotation
           LEFT JOIN tb_advertisement_order ON tb_advertisement_order.O_id = tb_advertisement_quotation.O_id
           LEFT JOIN tb_order_status ON tb_advertisement_quotation.AQ_status = tb_order_status.O_status
           WHERE tb_advertisement_order.O_id = '$ao_id'";

$resultaq = mysqli_query($con, $sql_aq); 


include ('AOrderheader.php');

?>

<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Advertisement Order Management</h3>
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
                        <h3 class="text-dark mb-4">Order Summary</h3>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Order Summary</p>
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query = "SELECT
                                                        tb_advertisement_order.O_id,
                                                        tb_advertisement_order.O_date,
                                                        tb_customer.C_name,
                                                        tb_customer_phone.C_phone,
                                                        tb_advertisement_order.O_totalCost,
                                                        tb_advertisement_order.O_totalPrice
                                                      FROM
                                                        tb_advertisement_order
                                                      JOIN
                                                        tb_customer ON tb_advertisement_order.C_id = tb_customer.C_id
                                                      JOIN
                                                        tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
                                                      WHERE tb_advertisement_order.O_id LIKE '%$ao_id%' ";

                                            $stmt = $con->prepare($query);
                                            if (!$stmt) {
                                                echo "Error in preparing statement: " . $con->error;
                                                exit;
                                            }

                                            $stmt->execute();
                                            if ($stmt->error) {
                                                echo "Error in executing statement: " . $stmt->error;
                                                exit;
                                            }
                                            $result = $stmt->get_result();
                                            if ($result && $result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['O_id'] . "</td>"; // Corrected 'id' to 'C_id'
                                                    echo "<td>" . $row['O_date'] . "</td>"; // Corrected 'date' to 'AO_date'
                                                    echo "<td>" . $row['C_name'] . "</td>"; // Corrected 'customer_name' to 'C_name'
                                                    echo "<td>" . $row['C_phone'] . "</td>"; // Corrected 'contact_number' to 'C_phone'
                                                    echo "<td>" . $row['O_totalCost'] . "</td>"; // Corrected 'total_cost' to 'AO_totalCost'
                                                    echo "<td>" . $row['O_totalPrice'] . "</td>"; // Corrected 'total_price' to 'AO_totalPrice'
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
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Quotation</p>
                        </div>
                        <div class="card-body">
                             <button id="generateButton"class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#generateModal">Generate</button>
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
                                            echo "<button type='button' class='btn btn-success m-1' id='modalTrigger-" . $currentAQId . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                <i class='fa fa-send' style='color: white;'></i>";
                                                echo "</button>";

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
                                                                            <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent' required></textarea><br>    
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
                <div class="modal fade" role="dialog" tabindex="-1" id="generateModal" style="margin: 0px;margin-top: 0px;text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0,0,0);">Generate Advertisement Quotation</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="AquotationForm" method="post">
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
                            <input type="hidden" name="O_id" value="<?php echo $ao_id; ?>">
                            <input type="hidden" name="U_id" value="<?php echo $fid; ?>">
                            <button class="btn btn-primary" type="submit" id="GenerateAQ">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                    <?php
                        echo "<div class='mb-3'>
                        <a href='save_AOM2.php?id=" . $fid . "&o_id=" . $ao_id . "'><button class='btn btn-primary btn-sm'>< Back to Order Material</button></a>
                        </div>";
                    ?>
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
$(document).ready(function () {
    $("#AquotationForm").submit(function (e) {
        e.preventDefault(); // Prevent default form submission
    
        var dueDate = $("#dueDate").val();

        if (!dueDate) {
            alert('Please fill out all required fields.');
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "generateAQ.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#AquotationForm").serialize(),
            success: function (response) {
                console.log(response);
                alert("Document generated successfully");
                window.location.href = "EditAOrder.php?id=<?php echo urlencode($rows['U_id']); ?>&o_id=<?php echo $ao_id; ?>";

                // Close the modal after successful generation
                $("#generateModal").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Error generating document. Please try again.");
            }
        });
    });

    $("#generateButton").click(function () {
        $("#AquotationForm")[0].reset();
        $("#generateModal").modal("show");
    });
});
</script>

<?php 
// ... Close other statements
$con->close();
?>