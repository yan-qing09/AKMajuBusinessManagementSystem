<?php
include ('dbconnect.php');
include ('mysession.php');

$sql = "SELECT *
        FROM tb_customer
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        LEFT JOIN tb_government ON tb_customer.C_id = tb_government.G_id
        LEFT JOIN tb_agency ON tb_customer.C_id = tb_agency.A_id
        LEFT JOIN tb_agency_phone ON tb_agency.A_id = tb_agency_phone.A_id
        LEFT JOIN tb_government_phone ON tb_government.G_id = tb_government_phone.G_id";
$result = mysqli_query($con,$sql);
$result1 = mysqli_query($con,$sql);
$result2 = mysqli_query($con,$sql);

// Fetch data from the database to populate the dropdown
$query4 = "SELECT T_Desc FROM tb_am_type"; 
$result4 = $con->query($query4);

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

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
                    <?php
                        echo "<form method='post' action='save_order.php?id=".$rows['U_id']."'>"
                    ?>
                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-dark mb-4">Add Order</h3>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Customer Information</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cname">
                                                <strong>Customer Name</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cname" placeholder="Name" name="Cname">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Ctype">
                                                <strong>Customer Type</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="Ctype" name="Ctype">
                                                <option value="1" selected="">Personnel</option>
                                                <option value="2">Government</option>
                                                <option value="3">Agency</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cemail">
                                                <strong>Customer email</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cemail" placeholder="123@gmail.com" name="Cemail">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cphone">
                                                <strong>Customer phone</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cphone" placeholder="0123456789" name="Cphone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cstreet">
                                                <strong>Street</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cstreet" placeholder="Street Details" name="Cstreet">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Ccity">
                                                <strong>City</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Ccity" placeholder="City Details" name="Ccity">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cpostcode">
                                                <strong>Postcode</strong>
                                            </label>
                                            <input class="form-control" type="number" id="Cpostcode" placeholder="Postcode Details" name="Cpostcode">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cstate">
                                                <strong>State</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cstate" placeholder="State Details" name="Cstate">
                                        </div>
                                    </div>
                                </div>
                                <div id="governmentFields" style="display: none;">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="governmentName">
                                                    <strong>Government Name</strong>
                                                </label>
                                                <input class="form-control" type="text" id="governmentName" placeholder="Government Name" name="governmentName">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="governmentPhone">
                                                    <strong>Government Phone</strong>
                                                </label>
                                                <input class="form-control" type="text" id="governmentPhone" placeholder="Government Phone" name="governmentPhone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="agencyFields" style="display: none;">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Aname">
                                                    <strong>Agency Name</strong>
                                                </label>
                                                <input class="form-control" type="text" id="Aname" placeholder="Agency Name" name="Aname">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Aphone">
                                                    <strong>Agency Phone</strong>
                                                </label>
                                                <input class="form-control" type="Phone" id="Aphone" placeholder="Agency Phone" name="Aphone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Order Material</p>
                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Mtype"><strong>Material Type</strong></label>
                                                <?php 
                                                    // Check if there are rows returned from the query
                                                    if ($result4 && $result4->num_rows > 0) {
                                                        // Start generating the select dropdown
                                                        echo '<select class="form-select" id="Mtype" name="Mtype">';
                                                        
                                                        // Loop through the fetched rows to create options
                                                        while ($row4 = $result4->fetch_assoc()) {
                                                            $MtypeValue = $row4['T_Desc']; // Replace 'Mtype_column' with your actual column name

                                                            // Generate an option for each row retrieved from the database
                                                            echo "<option value='$MtypeValue'>$MtypeValue</option>";
                                                        }

                                                        // Close the select dropdown
                                                        echo '</select>';
                                                    } else {
                                                        // If no rows are returned or an error occurs, display a default option or a message
                                                        echo '<select class="form-select" id="Mtype" name="Mtype">';
                                                        echo '<option value="">No options available</option>'; // Display a default option
                                                        echo '</select>';
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="Mname"><strong>Material Name</strong></label><input class="form-control" type="text" id="Mname" placeholder="Material Name" name="Mname"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Mvariation"><strong>Material Variation</strong></label>
                                                <select class="form-select" id="Mvariation" name="Mvariation">
                                                    <!-- Options will be dynamically populated -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Mdimension"><strong>Material Dimension</strong></label>
                                                <select class="form-select" id="Mdimension" name="Mdimension">
                                                    <!-- Options will be dynamically populated -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Munit">
                                                    <strong>Material Unit</strong>
                                                </label>
                                                <span id="materialUnitLabel"></span>
                                                <input class="form-control" type="text" id="Munit" placeholder="Material Unit" name="Munit">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="Mcost"><strong>Material Cost</strong></label><input class="form-control" type="text" id="Mcost" placeholder="Material Cost" name="Mcost"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="Mprice"><strong>Material Price</strong></label><input class="form-control" type="text" id="Mprice" placeholder="Material Price" name="Mprice"></div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="Mquantity"><strong>Quantity</strong></label><input class="form-control" type="text" id="Mquantity" placeholder="Quantity" name="Mquantity"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Dtype">
                                                    <strong>Discount Type</strong>
                                                </label>
                                                <select class="d-inline-block form-select form-select-sm" id="Dtype" name="Dtype">
                                                    <option value="1" selected>Percentage</option>
                                                    <option value="2">Amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col" id="percentageFields" style="display: block;">
                                            <div class="mb-3">
                                                <label class="form-label" for="MdiscountPerc">
                                                    <strong>Discount Percentage (in %)</strong>
                                                </label>
                                                <input class="form-control" type="text" id="MdiscountPerc" placeholder="20" name="MdiscountPerc">
                                            </div>
                                        </div>
                                        <div class="col" id="amountFields" style="display: none;">
                                            <div class="mb-3">
                                                <label class="form-label" for="MdiscountAmt">
                                                    <strong>Discount Amount (in RM)</strong>
                                                </label>
                                                <input class="form-control" type="text" id="MdiscountAmt" placeholder="15" name="MdiscountAmt">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="taxcode"><strong>Tax Code</strong></label><input class="form-control" type="text" id="taxcode" placeholder="AJS_A" name="taxcode"></div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="taxamount"><strong>Tax Amount</strong></label><input class="form-control" type="text" id="taxamount" placeholder="RM37.00" name="taxamount"></div>
                                        </div>
                                    </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="button" id="saveMaterial">Save Material</button>
                                </div> 
                            </div>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Material Selected</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                    <table class="table my-0" id="dataTableNew">
                                        <thead>
                                            <tr>
                                                <th>Material Type</th>
                                                <th>Material Name</th>
                                                <th>Material Variation</th>
                                                <th>Material Dimension</th>
                                                <th>Material Unit</th>
                                                <th>Material Price</th>
                                                <th>Material Cost</th>
                                                <th>Quantity</th>
                                                <th>Discount Percentage</th>
                                                <th>Discount Amount</th>
                                                <th>Tax Code</th>
                                                <th>Tax Amount</th>
                                                <th></th>
                                                <th></th>
                                                <input type="hidden" name="materialsData" id="materialsData">
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 align-self-center">
                                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
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
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Order Details</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="AOdate"><strong>Order Date</strong></label><input class="form-control" type="date" id="AOdate" placeholder="date" name="AOdate"></div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="AOremark"><strong>Order Remark</strong></label><input class="form-control" type="text" id="AOremark" placeholder="Sign Board to AKMaju" name="AOremark"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="addonprice"><strong>Add On Price</strong></label><input class="form-control" type="text" id="addonprice" placeholder="RM20.00" name="addonprice"></div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="TOP"><strong>Term of Payment</strong></label><input class="form-control" type="text" id="TOP" placeholder="LO" name="TOP"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" id="saveOrder" type="submit">Save Order</button>
                        </div>
                    </form>
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
    <script src="assets/js/addorder.js"></script>

    <div class="modal fade" role="dialog" tabindex="-1" id="editMaterialModal" style="margin: 0px; margin-top: 0px; text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0, 0, 0);">Edit Material</h4>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editMaterialForm">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Material Type</label>
                                <input class="form-control" type="text" id="edit_Mtype" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Material Name</label>
                                <input class="form-control" type="text" id="edit_Mname" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Material Variation</label>
                                <input class="form-control" type="text" id="edit_Mvariation" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Material Dimension</label>
                                <input class="form-control" type="text" id="edit_Mdimension">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Material Unit</label>
                                <input class="form-control" type="text" id="edit_Munit">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Material Price</label>
                                <input class="form-control" type="text" id="edit_Mprice">
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                <label class="form-label">Material Cost</label>
                                <input class="form-control" type="text" id="edit_Mcost">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity</label>
                                <input class="form-control" type="text" id="edit_Mquantity">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Discount Type</label>
                                <select class="form-select" id="Dtype1" name="Dtype1">
                                    <option value="1" selected>Percentage</option>
                                    <option value="2">Amount</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="percentageFields1">
                                <label class="form-label">Discount Percentage (in %)</label>
                                <input class="form-control" type="text" id="edit_MdiscountPerc" placeholder="" name="edit_MdiscountPerc">
                            </div>
                            <div class="col-md-6" id="amountFields1" style="display: none;">
                                <label class="form-label">Discount Amount (in RM)</label>
                                <input class="form-control" type="text" id="edit_MdiscountAmt" placeholder="" name="edit_MdiscountAmt">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tax Code</label>
                                <input class="form-control" type="text" id="edit_taxcode" placeholder="" name="edit_taxcode">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tax Amount</label>
                                <input class="form-control" type="text" id="edit_taxamount" placeholder="" name="edit_taxamount">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="button" id="saveEditedMaterial">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>