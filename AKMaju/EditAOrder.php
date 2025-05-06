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

$ao_id = $_GET['o_id']; // Capture the orderid from the URL

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$sql4 = "SELECT * FROM tb_customer WHERE C_id = (SELECT C_id FROM tb_advertisement_order WHERE O_id = '$ao_id')";
$result4 = mysqli_query($con, $sql4);

if ($result4) {
    // Fetch the customer details
    $customer4 = mysqli_fetch_assoc($result4);
}

$cType = $customer4['C_type'];

$sqlType = "SELECT C_desc FROM tb_customer_type WHERE C_type = $cType";
$resultType = mysqli_query($con, $sqlType);

if ($resultType) {
    // Fetch the customer type description
    $customerType = mysqli_fetch_assoc($resultType);
    $cDesc = isset($customerType['C_desc']) ? $customerType['C_desc'] : '';
}

$cid = $customer4['C_id'];

$sqlPhone = "SELECT C_phone FROM tb_customer_phone WHERE C_id = '$cid'";
$resultPhone = mysqli_query($con, $sqlPhone);

if (!$resultPhone) {
    echo "Error: " . mysqli_error($con);
} else {
    // Fetch the customer type description
    $customerPhone = mysqli_fetch_assoc($resultPhone);
    $cPhone = isset($customerPhone['C_phone']) ? $customerPhone['C_phone'] : '';
}

$sqlGname = "SELECT tb_agency_government.AG_name
             FROM tb_agency_government
             INNER JOIN tb_customer ON tb_agency_government.C_id = tb_customer.C_id
             WHERE tb_customer.C_type = 2 AND tb_agency_government.C_id = '$cid'";
$resultGname = mysqli_query($con, $sqlGname);

if ($resultGname) {
    $customerGname = mysqli_fetch_assoc($resultGname);
    $Gname = isset($customerGname['AG_name']) ? $customerGname['AG_name'] : '';
}

$sqlGphone = "SELECT tb_ag_phone.AG_phone
             FROM tb_ag_phone
             INNER JOIN tb_customer ON tb_ag_phone.C_id = tb_customer.C_id
             WHERE tb_customer.C_type = 2 AND tb_ag_phone.C_id = '$cid'";
$resultGphone = mysqli_query($con, $sqlGphone);

if ($resultGphone) {
    $customerGphone = mysqli_fetch_assoc($resultGphone);
    $Gphone = isset($customerGphone['AG_phone']) ? $customerGphone['AG_phone'] : '';
}

$sqlAname = "SELECT tb_agency_government.AG_name
             FROM tb_agency_government
             INNER JOIN tb_customer ON tb_agency_government.C_id = tb_customer.C_id
             WHERE tb_customer.C_type = 3 AND tb_agency_government.C_id = '$cid'";
$resultAname = mysqli_query($con, $sqlAname);

if ($resultAname) {
    $customerAname = mysqli_fetch_assoc($resultAname);
    $Aname = isset($customerAname['AG_name']) ? $customerAname['AG_name'] : '';
}

$sqlAphone = "SELECT tb_ag_phone.AG_phone
             FROM tb_ag_phone
             INNER JOIN tb_customer ON tb_ag_phone.C_id = tb_customer.C_id
             WHERE tb_customer.C_type = 3 AND tb_ag_phone.C_id = '$cid'";
$resultAphone = mysqli_query($con, $sqlAphone);

if ($resultAphone) {
    $customerAphone = mysqli_fetch_assoc($resultAphone);
    $Aphone = isset($customerAphone['AG_phone']) ? $customerAphone['AG_phone'] : '';
}

$sql5 = "SELECT * FROM tb_advertisement_order WHERE O_id = '$ao_id'";
$result5 = mysqli_query($con, $sql5);
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);


if ($result5) {
    // Fetch the customer details
    $order5 = mysqli_fetch_assoc($result5);
}

// Fetch data from the database to populate the dropdown
$queryMT = "SELECT T_Desc FROM tb_am_type"; 
$resultMT = $con->query($queryMT);

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

$sqlsig = "SELECT *
            FROM tb_payment_ref
            LEFT JOIN tb_user ON tb_user.U_id = tb_payment_ref.U_id
            WHERE tb_payment_ref.U_id = '$fid' AND tb_payment_ref.O_id = '$ao_id'";

$resultsig = mysqli_query($con, $sqlsig);

include ('AOrderheader.php');
?>

<html data-bs-theme="light" lang="en" data-bss-forced-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Advertisement Order</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/jpg" href="assets/img/dogs/akmaju.jpg"/>
    <script>
        $(document).ready(function () {
            
            // Add an event listener to the button
            $("#editButton").click(function () {
                // Toggle the 'readonly' attribute on input fields within the first card
                $("#orderSummaryCollapse input").prop("readonly", function (i, value) {
                    return !value;
                });

                // Toggle the 'disabled' attribute on select fields within the first card
                $("#orderSummaryCollapse select").prop("disabled", function (i, value) {
                    return !value;
                });
            });

            $("#editButton1").click(function () {
                // Toggle the 'readonly' attribute on input fields within the first card
                $("#orderSummaryCollapse1 input").prop("readonly", function (i, value) {
                    return !value;
                });

                // Toggle the 'disabled' attribute on select fields within the first card
                $("#orderSummaryCollapse1 select").prop("disabled", function (i, value) {
                    return !value;
                });
            });

            $("#editButton2").click(function () {
                // Toggle the 'readonly' attribute on input fields within the first card
                $("#orderSummaryCollapse2 input").prop("readonly", function (i, value) {
                    return !value;
                });

                // Toggle the 'disabled' attribute on select fields within the first card
                $("#orderSummaryCollapse2 select").prop("disabled", function (i, value) {
                    return !value;
                });
            });

            $("#editButton3").click(function () {
                // Toggle the 'readonly' attribute on input fields within the first card
                $("#orderSummaryCollapse3 input").prop("readonly", function (i, value) {
                    return !value;
                });

                // Toggle the 'disabled' attribute on select fields within the first card
                $("#orderSummaryCollapse3 select").prop("disabled", function (i, value) {
                    return !value;
                });
            });

            // Add a submit event listener to the form
            $("form").submit(function () {
                // Enable the disabled select field before submitting
                $("#Ctype").prop("disabled", false);

                // Enable the disabled select field before submitting
                $("#TOP").prop("disabled", false);
            });
        });
    </script>
</head>

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
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h3 class="text-dark mb-4 mr-auto">Manage Advertisement Order</h3>
                    </div>
                    <div class="card shadow mb-3">
                        <?php
                        echo "<form method='post' action='update_Acustomer_details.php?id=".$rows['U_id']."&ao_id=".$row6['O_id']."' onsubmit='return validateForm2(event)'>"
                        ?>
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse" aria-expanded="false" aria-controls="orderSummaryCollapse">
                            <p class="text-primary m-0 fw-bold">Customer Information</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse">
                        <div class="card-body">
                            <div class="row justify-content-end mb-3">
                                <!-- Move the button to the right -->
                                <button type="button" class="btn btn-primary" id="editButton" style="width:70px;margin-right: 20px;">Edit</button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cname">
                                            <strong>Customer Name</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cname" placeholder="Name" name="Cname" value="<?php echo isset($customer4['C_name']) ? $customer4['C_name'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Ctype">
                                            <strong>Customer Type</strong>
                                        </label>
                                        <select class="d-inline-block form-select form-select-sm" id="Ctype" name="Ctype" disabled>
                                            <option value="1" <?php echo ($cType == 1) ? 'selected' : ''; ?>>Personnel</option>
                                            <option value="2" <?php echo ($cType == 2) ? 'selected' : ''; ?>>Government</option>
                                            <option value="3" <?php echo ($cType == 3) ? 'selected' : ''; ?>>Agency</option>
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
                                        <input class="form-control" type="text" id="Cemail" placeholder="123@gmail.com" name="Cemail" value="<?php echo isset($customer4['C_email']) ? $customer4['C_email'] : ''; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cphone">
                                            <strong>Customer phone</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cphone" placeholder="0123456789" name="Cphone" value="<?php echo isset($cPhone) ? $cPhone : ''; ?>"  readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cstreet">
                                            <strong>Street</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cstreet" placeholder="Street Details" name="Cstreet" value="<?php echo isset($customer4['C_street']) ? $customer4['C_street'] : ''; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Ccity">
                                            <strong>City</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Ccity" placeholder="City Details" name="Ccity" value="<?php echo isset($customer4['C_city']) ? $customer4['C_city'] : ''; ?>"  readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cpostcode">
                                            <strong>Postcode</strong>
                                        </label>
                                        <input class="form-control" type="number" id="Cpostcode" placeholder="Postcode Details" name="Cpostcode" value="<?php echo isset($customer4['C_postcode']) ? $customer4['C_postcode'] : ''; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cstate">
                                            <strong>State</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cstate" placeholder="State Details" name="Cstate" value="<?php echo isset($customer4['C_state']) ? $customer4['C_state'] : ''; ?>"  readonly>
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
                                            <input class="form-control" type="text" id="governmentName" placeholder="Government Name" name="governmentName" value="<?php echo isset($Gname) ? $Gname : ''; ?>"  readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="governmentPhone">
                                                <strong>Government Phone</strong>
                                            </label>
                                            <input class="form-control" type="text" id="governmentPhone" placeholder="Government Phone" name="governmentPhone" value="<?php echo isset($Gphone) ? $Gphone : ''; ?>"  readonly>
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
                                            <input class="form-control" type="text" id="Aname" placeholder="Agency Name" name="Aname" value="<?php echo isset($Aname) ? $Aname : ''; ?>"  readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Aphone">
                                                <strong>Agency Phone</strong>
                                            </label>
                                            <input class="form-control" type="Phone" id="Aphone" placeholder="Agency Phone" name="Aphone" value="<?php echo isset($Aphone) ? $Aphone : ''; ?>"  readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save</button></div>
                        </div>
                    </div>
                    </form>  
                    </div>
                    <div class="card shadow mb-3">
                        <?php
                        echo "<form method='post' action='update_Aorder_details.php?id=".$rows['U_id']."&o_id=".$row6['O_id']."'>"
                        ?> 
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse1" aria-expanded="false" aria-controls="orderSummaryCollapse1">
                            <p class="text-primary m-0 fw-bold">Order Details</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse1">
                        <div class="card-body">
                            <div class="row justify-content-end mb-3">
                                <!-- Move the button to the right -->
                                <button type="button" class="btn btn-primary" id="editButton1" style="width:70px;margin-right: 20px;">Edit</button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="AOdate"><strong>Order Date</strong></label>
                                        <input class="form-control" type="date" id="AOdate" placeholder="date" name="AOdate" value="<?php echo isset($order5['O_date']) ? $order5['O_date'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="AOremark"><strong>Order Remark</strong></label>
                                        <input class="form-control" type="text" id="AOremark" placeholder="Sign Board to AKMaju" name="AOremark" value="<?php echo isset($order5['O_remark']) ? $order5['O_remark'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label" for="TOP"><strong>Term of Payment</strong></label>
                                        <?php
                                        $queryMT1 = "SELECT * FROM tb_terms_of_payment"; 
                                        $resultMT1 = $con->query($queryMT1);

                                        $sqlAtop = "SELECT TOP_name FROM tb_terms_of_payment WHERE TOP_id = (SELECT O_TOP FROM tb_advertisement_order WHERE O_id = '$ao_id')";
                                        $resultAtop = mysqli_query($con, $sqlAtop);

                                        $selectedTOP = ""; // Initialize variable to store selected TOP_name

                                        if ($resultAtop && $rowAtop = mysqli_fetch_assoc($resultAtop)) {
                                            $selectedTOP = $rowAtop['TOP_name']; // Get the TOP_name from the second query
                                        }

                                        if ($resultMT1 && $resultMT1->num_rows > 0) {
                                            echo '<select class="form-select" id="TOP" name="TOP" disabled>';
                                            while ($rowMT1 = $resultMT1->fetch_assoc()) {
                                                $MTDesc1 = $rowMT1['TOP_name'];
                                                $MTvalue1 = $rowMT1['TOP_desc'];

                                                // Check if the current option's TOP_name matches the selected TOP_name
                                                $selectedAttribute1 = ($MTDesc1 === $selectedTOP1) ? 'selected' : '';

                                                echo "<option value='$MTDesc1' $selectedAttribute1>$MTvalue1</option>";
                                            }
                                            echo '</select>';
                                        } else {
                                            echo '<select class="form-select" id="TOP" name="TOP" disabled>';
                                            echo '<option value="">No options available</option>';
                                            echo '</select>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save</button></div>
                        </div>
                    </div>
                    </form>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse4" aria-expanded="false" aria-controls="orderSummaryCollapse4">
                            <p class="text-primary m-0 fw-bold">Material Selected</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse4">
                        <div class="card-body">
                            <div class="row justify-content-end mb-3">
                                <button class='btn btn-primary btn-sm addMaterial m-1' type='button' style="margin-left: 470px; margin-top: 19px; width:76px;">
                                    <i class="fa fa-plus"></i>&nbsp; New
                                </button>
                            </div>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
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
                                        <?php 
                                        $sql6 = "SELECT *
                                                FROM tb_ao_material AS ao
                                                INNER JOIN tb_advertisement_material AS ad ON ao.AM_id = ad.AM_id
                                                INNER JOIN tb_am_type AS amt ON ad.AM_type = amt.AM_type
                                                WHERE ao.O_id = '$ao_id'";
                                        $result6 = $con->query($sql6);

                                        // Check if there's any data
                                        if ($result6->num_rows > 0) {
                                            // Output data of each row
                                            while ($row6 = $result6->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row6["T_Desc"] . "</td>"; 
                                                echo "<td>" . $row6["AM_name"] . "</td>"; 
                                                echo "<td>" . $row6["AM_variation"] . "</td>"; 
                                                echo "<td>" . $row6["AM_dimension"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_unit"] . $row6["AM_unit"] . "</td>";
                                                echo "<td>" . $row6["AOM_adjustprice"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_origincost"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_qty"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_discPct"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_discAmt"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_taxcode"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_taxAmt"] . "</td>"; 
                                                echo "<td><button class='btn btn-primary btn-sm editMaterial m-1' type='button' data-materialid='" . $row6["AM_id"] . "' data-aoid='" . $ao_id . "'><i class='fas fa-pen'></i></button></td>";
                                                echo "<td><button class='btn btn-danger btn-sm deleteMaterial m-1' type='button' data-materialid='" . $row6["AM_id"] . "' data-aoid='" . $ao_id . "'><i class='fas fa-trash-alt'></i></button></td>";
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
                <div class="card shadow mb-3">
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse6" aria-expanded="false" aria-controls="orderSummaryCollapse6">
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Quotation</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse6">
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
                </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse7" aria-expanded="false" aria-controls="orderSummaryCollapse7">
                            <div>
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Invoice</p>
                            </div>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse7">
                        <div class="card-body">
                            <button id="generateIButton"class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#generateIModal">Generate</button>
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

                                            echo "<button type='button' class='btn btn-success m-1'id='modalTrigger2-" . $currentiId . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                          <i class='fa fa-send' style='color: white;'></i>
                                                      </button>
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
                                                                        <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent' required></textarea><br>    
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
                </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse8" aria-expanded="false" aria-controls="orderSummaryCollapse8">
                            <div>
                                <p class="text-primary m-0 fw-bold" style="width: 555px;">Delivery Order</p>
                            </div>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse8">
                        <div class="card-body">
                           <button id="generateDOButton" class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#generateDOModal">Generate</button>
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
                                            echo"<button type='button' class='btn btn-success m-1' id='modalTrigger3-" . $currentdoId . "' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                    <i class='fa fa-send' style='color: white;'></i>
                                                </button>
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
                                                                        <textarea placeholder='Type your Message Details Here...' tabindex='5' class='form-control' id='emailContent' name='emailContent' required></textarea><br>    
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
                </div>

<div class="modal fade" role="dialog" tabindex="-1" id="generateDOModal" style="margin: 0px; margin-top: 0px; text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0, 0, 0);">Generate Delivery Order</h4>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="DOForm" method="post">
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
                                <label class="dueDate">Delivery Date</label><br>
                                <input class="form-control" type="date" id="deliveryDate" name="deliveryDate" required
                                    min="<?php echo date('Y-m-d'); ?>" max="2030-12-31"><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="O_id" value="<?php echo $ao_id; ?>">
                            <input type="hidden" name="U_id" value="<?php echo $fid; ?>">
                            <button class="btn btn-primary" type="button" id="GenerateDO">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
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
                            <button class="btn btn-primary" type="button" id="GenerateAQ">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="generateIModal" style="margin: 0px;margin-top: 0px;text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0,0,0);">Generate Invoice</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="IForm" method="post">
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
                                <label class="dueDate">Expiry Date</label><br>
                                <input class="form-control" type="date" id="expiryDate" name="expiryDate" required
                                    min="<?php echo date('Y-m-d'); ?>" max="2030-12-31"><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="O_id" value="<?php echo $ao_id; ?>">
                            <input type="hidden" name="U_id" value="<?php echo $fid; ?>">
                            <button class="btn btn-primary" type="button" id="GenerateI">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                    <div class="card shadow mb-3">
                        <?php
                        echo "<form method='post' action='update_Aorder_status.php?id=".$fid."&ao_id=".$ao_id."'>"
                        ?> 
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse2" aria-expanded="false" aria-controls="orderSummaryCollapse2">
                            <p class="text-primary m-0 fw-bold">Order Status</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse2">
                        <div class="card-body">
                            <div class="row justify-content-end mb-3">
                                <!-- Move the button to the right -->
                                <button type="button" class="btn btn-primary" id="editButton2" style="width:70px;margin-right: 20px;">Edit</button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="dataTable_quotation" class="dataTables_length" aria-controls="dataTable">
                                        <label class="form-label">
                                            <strong>Quotation Status&nbsp;</strong>
                                            <select class="d-inline-block form-select form-select-sm" id="Qstatus" name="Qstatus" disabled>
                                                <option value="0" <?php echo ($order5['O_quotationStatus'] == 0) ? 'selected' : ''; ?>>Pending</option>
                                                <option value="4" <?php echo ($order5['O_quotationStatus'] == 4) ? 'selected' : ''; ?>>Accepted by customer</option>
                                                <option value="5" <?php echo ($order5['O_quotationStatus'] == 5) ? 'selected' : ''; ?>>Rejected by customer</option>
                                                <option value="9" <?php echo ($order5['O_quotationStatus'] == 9) ? 'selected' : ''; ?>>Approved by admin</option>
                                            </select>&nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div id="dataTable_invoice" class="dataTables_length" aria-controls="dataTable">
                                        <label class="form-label">
                                            <strong>Invoice Status&nbsp;</strong>
                                            <select class="d-inline-block form-select form-select-sm" id="Istatus" name="Istatus" disabled>
                                                <option value="0" <?php echo ($order5['AO_invoiceStatus'] == 0) ? 'selected' : ''; ?>>Pending</option>
                                                <option value="9" <?php echo ($order5['AO_invoiceStatus'] == 9) ? 'selected' : ''; ?>>Approved by admin</option>
                                            </select>&nbsp;
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="dataTable_payment" class="dataTables_length" aria-controls="dataTable">
                                        <label class="form-label">
                                            <strong>Payment Status&nbsp;</strong>
                                            <select class="d-inline-block form-select form-select-sm" id="Pstatus" name="Pstatus" disabled>
                                                <option value="0" <?php echo ($order5['AO_paymentStatus'] == 0) ? 'selected' : ''; ?>>Not Paid Yet</option>
                                                <option value="6" <?php echo ($order5['AO_paymentStatus'] == 6) ? 'selected' : ''; ?>>Pending Payment</option>
                                                <option value="7" <?php echo ($order5['AO_paymentStatus'] == 7) ? 'selected' : ''; ?>>Deposit Paid</option>
                                                <option value="8" <?php echo ($order5['AO_paymentStatus'] == 8) ? 'selected' : ''; ?>>Fully Paid</option>
                                            </select>&nbsp;
                                        </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div id="dataTable_delivery" class="dataTables_length" aria-controls="dataTable">
                                        <label class="form-label">
                                            <strong>Delivery Status&nbsp;</strong>
                                            <select class="d-inline-block form-select form-select-sm" id="Dstatus" name="Dstatus" disabled>
                                                <option value="0" <?php echo ($order5['AO_deliveryStatus'] == 0) ? 'selected' : ''; ?>>Pending</option>
                                                <option value="9" <?php echo ($order5['AO_deliveryStatus'] == 9) ? 'selected' : ''; ?>>Approved by admin</option>
                                                <option value="10" <?php echo ($order5['AO_deliveryStatus'] == 10) ? 'selected' : ''; ?>>Delivered</option>
                                            </select>&nbsp;
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save</button></div>
                        </div>
                        </div>
                    </form>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse5" aria-expanded="false" aria-controls="orderSummaryCollapse5">
                            <p class="text-primary m-0 fw-bold">Order Summary</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse5">
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
                                                      WHERE
                                                        tb_advertisement_order.O_id = ?"; // Assuming newOrderId corresponds to AO_id

                                            $stmt = $con->prepare($query);
                                            $stmt->bind_param("s", $ao_id);

                                            $stmt->execute();
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
                </div>
                <div class="card shadow mb-3">
                        <?php
                        echo "<form method='post' action='update_Aorder_payment.php?id=".$fid."&o_id=".$ao_id."'>"
                        ?> 
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse3" aria-expanded="false" aria-controls="orderSummaryCollapse3">
                            <p class="text-primary m-0 fw-bold">Order Payment</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse3">
                        <div class="card-body">
                            <div class="row justify-content-end mb-3">
                                <!-- Move the button to the right -->
                                <button type="button" class="btn btn-primary" id="editButton3" style="width:70px;margin-right: 20px;">Edit</button>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="deposit">
                                            <strong>Deposit Amount (RM)</strong>
                                        </label>
                                        <input class="form-control" type="text" id="deposit" placeholder="RM300" name="deposit" value="<?php echo isset($order5['AO_deposit']) ? $order5['AO_deposit'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="pmethod">
                                            <strong>Payment Method</strong>
                                        </label>
                                        <select class="d-inline-block form-select form-select-sm" id="pmethod" name="pmethod" disabled>
                                                <option value="0" <?php echo ($order5['AO_payMethod'] == 0) ? 'selected' : ''; ?>>Haven't Paid</option>
                                                <option value="1" <?php echo ($order5['AO_payMethod'] == 1) ? 'selected' : ''; ?>>Visa Card</option>
                                                <option value="2" <?php echo ($order5['AO_payMethod'] == 2) ? 'selected' : ''; ?>>Cash</option>
                                        </select>&nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="pdate">
                                            <strong>Payment Date</strong>
                                        </label>
                                        <input class="form-control" type="date" id="pdate" name="pdate" value="<?php echo isset($order5['AO_payDate']) ? $order5['AO_payDate'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save</button></div>
                        </div>
                    </div>
                    </form>
                    </div>
                    <div class="card shadow mb-3">
                    <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse9" aria-expanded="false" aria-controls="orderSummaryCollapse9">
                        <p class="text-primary m-0 fw-bold">Payment Reference</p>
                    </div>
                    <div class="collapse" id="orderSummaryCollapse9">
                    <div class="card-body">
                        <button type='button' class='btn btn-success m-1' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;' data-bs-toggle='modal' data-bs-target='#uploadModal'>
                        <i class='fas fa-upload' style='color: white;'></i>
                        </button>
                        <div class="table-responsive table mt-2" id="dataTable-3" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTablepay">
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
                                            $rowsArray = [];
                                            while ($rowsig = mysqli_fetch_array($resultsig)) {
                                                $rowsArray[] = $rowsig;

                                                $status = $rowsig['P_status'];
                                                $statusdesc = ($status == '1') ? 'inactive' : 'active';

                                                echo "<tr>
                                                        <td style='padding-left: 25px;'>{$rowsig['U_id']}</td>
                                                        <td class='text-center'>{$rowsig['P_uploadDate']}</td>
                                                        <td class='text-center'>$statusdesc</td>";

                                                // Check the status before rendering the action column
                                                if ($status != '1') {
                                                    echo "<td class='text-center'>
                                                            <div style='display: flex; align-items: center; justify-content: center;'>
                                                                <a href='openpaymentRef.php?id={$fid}&aoid={$ao_id}&pid=" . $rowsig['P_id'] . "' class='btn btn-primary m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'>
                                                                    <i class='fas fa-book-open'></i>
                                                                </a>
                                                                <button class='btn btn-danger m-1 delete-btn' type='button' data-bs-toggle='modal' data-bs-target='#modal-1-{$rowsig['P_id']}' data-co-id='".$rowsig['P_id']."'><i class='fas fa-trash'></i></button>
                                                            </div>
                                                        </td>";
                                                } else {
                                                    echo "<td class='text-center'>
                                                            <div style='display: flex; align-items: center; justify-content: center;'>
                                                                <a class='btn btn-primary m-1' type='button' id='restoreTrigger-" . $rowsig['P_id'] . "'>
                                                                    <i class='fas fa-pen'></i>
                                                                </a>
                                                            </div>
                                                        </td>";
                                                }

                                                echo "</tr>";
                                                echo"<div class='modal fade' role='dialog' tabindex='-1' id='restoreModal-" . $rowsig['P_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                        <div class='modal-dialog modal-dialog-centered' role='document'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header' style='margin: 0px;'>
                                                                    <h4 class='modal-title' style='color: rgb(0,0,0);'>".$rowsig['P_id'].":".$rowsig['O_id']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <p style='color: rgb(0,0,0);'>Do you want to restore this payment Reference?</p>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                    <a href='restorePaymentRef.php?id=" . $fid . "&pid=" . $rowsig['P_id'] . "&oid=" . $rowsig['O_id'] . "' class='btn btn-danger'  style='background: rgb(205,10,10);' type='button'>Restore</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>";
                                                echo"<div class='modal fade' role='dialog' tabindex='-1' id='modal-1-{$rowsig['P_id']}' style='margin: 0px; margin-top: 0px; text-align: left;'>
                                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header' style='margin: 0px;'>
                                                                <h4 class='modal-title' style='color: rgb(0,0,0);'>" . htmlspecialchars($rowsig['P_id']) . " Delete Payment Ref</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p style='color: rgb(0,0,0);'>Do you sure you want to delete this payment reference?</p>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                <a href='deletePaymentRef.php?id=" . $rowsig['U_id'] . "&pid=" . $rowsig['P_id'] . "&oid=" . $ao_id . "' class='btn btn-danger' style='background: rgb(205,10,10);'>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                            }
                                        ?>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                <?php
                                                    foreach ($rowsArray as $rowsig) {
                                                        echo "var restoreModal" . $rowsig['P_id'] . " = new bootstrap.Modal(document.getElementById('restoreModal-" . $rowsig['P_id'] . "'));
                                                              var restoreTrigger" . $rowsig['P_id'] . " = document.getElementById('restoreTrigger-" . $rowsig['P_id'] . "');

                                                              restoreTrigger" . $rowsig['P_id'] . ".addEventListener('click', function(event) {
                                                                  event.preventDefault();
                                                                  console.log('Restore button clicked');
                                                                  restoreModal" . $rowsig['P_id'] . ".show();
                                                              });";
                                                    }
                                                ?>
                                            });
                                        </script>
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
                    <div class="modal fade" role="dialog" tabindex="-1" id="addMaterialModal" style="margin: 0px; margin-top: 0px; text-align: left;">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="margin: 0px;">
                            <h4 class="modal-title" style="color: rgb(0, 0, 0);">Add Order Material</h4>
                            <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Mtype"><strong>Material Type</strong></label>
                                        <?php
                                            if($resultMT && $resultMT->num_rows > 0) {
                                                echo '<select class="form-select" id="Mtype" name="Mtype">';
                                                while($rowMT = $resultMT->fetch_assoc()) {
                                                    $MTDesc = $rowMT['T_Desc'];
                                                    echo "<option value='$MTDesc'>$MTDesc</option>";
                                                }
                                                echo '</select>';
                                            } else {
                                                echo '<select class="form-select" id="Mtype" name="Mtype">';
                                                echo '<option value="">No options available</option>';
                                                echo '</select>';
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3"><label class="form-label" for="Mname"><strong>Material Name</strong></label><input class="form-control" type="text" id="Mname" placeholder="Material Name" name="Mname"></div><input type='hidden' name='ao_id' value='<?php echo $ao_id; ?>'><input type='hidden' name='id' value='<?php echo $fid; ?>'>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Mvariation"><strong>Material Variation</strong></label>
                                        <select class="form-select" id="Mvariation" name="Mvariation"></select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Mdimension"><strong>Material Dimension</strong></label>
                                        <select class="form-select" id="Mdimension" name="Mdimension"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Munit"><strong>Material Unit</strong></label>
                                        <span id="materialUnitLabel"></span>
                                        <input class="form-control" type="text" id="Munit" placeholder="Material Unit" name="Munit">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Mcost"><strong>Material Cost</strong></label><input class="form-control" type="text" id="Mcost" placeholder="Material Cost" name="Mcost">
                                    </div>
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
                            <div class="modal-footer">
                                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="button" id="saveAddMaterial">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" role="dialog" tabindex="-1" id="editMaterialModal" style="margin: 0px; margin-top: 0px; text-align: left;">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="margin: 0px;">
                            <h4 class="modal-title" style="color: rgb(0, 0, 0);">Edit Material</h4>
                            <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Material Type</label>
                                        <input class="form-control" type="text" id="edit_Mtype"  disabled required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Material Name</label>
                                        <input class="form-control" type="text" id="edit_Mname"  disabled required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Material Variation</label>
                                        <input class="form-control" type="text" id="edit_Mvariation"  disabled required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Material Dimension</label>
                                        <input class="form-control" type="text" id="edit_Mdimension"  disabled>
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
                                        <input class="form-control" type="text" id="edit_Mcost"  disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Quantity</label>
                                        <input class="form-control" type="text" id="edit_Mquantity">
                                        <input type="hidden" id="edit_material_id" value="">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" role="dialog" tabindex="-1" id="uploadModal" style="margin: 0px; margin-top: 0px; text-align: left;">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="margin: 0px;">
                            <h4 class="modal-title" style="color: rgb(0, 0, 0);">Upload Payment Reference</h4>
                            <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id='upload' action='uploadPaymentRef.php?id=<?php echo $fid; ?>&aoid=<?php echo $ao_id; ?>' method='post' enctype='multipart/form-data'>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="paymentRef">Select Payment References</label><br>
                                            <input type="file" name="paymentRef" id="paymentRef" accept=".png, .jpg, .jpeg" required>
                                            <input type="hidden" name="userid" value="<?php echo $fid; ?>">
                                            <input type="hidden" name="aoid" value="<?php echo $aoid; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="paymentRef-upload">Upload</button>
                                </div>
                            </form>
                            <div id="successMessage" style="display: none;">
                                <div style="border-radius: 200px; height: 200px; width: 200px; background: #F8FAF5; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="checkmark" style="color: #9ABC66; font-size: 100px; line-height: 200px;">✓</i>
                                </div>
                                <h1 style="text-align: center; color: #88B04B; font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif; font-weight: 900;">Success</h1>
                                <p style="text-align: center; color: #404F5E; font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif; font-size:20px;">Your signature has been saved successfully!</p>
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
        </div><a class="d-inline border rounded scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/editorder.js"></script>
    <script>
        
$('#Qstatus').change(function () {
    var selectedStatus = $(this).val();
    if (selectedStatus == '4' || selectedStatus == '5' || selectedStatus == '9') {
        $('option[value="0"]').hide();
    } else {
        $('option[value="0"]').show();
    }

    // Hide "Approved by admin" if "Pending" is selected
    if (selectedStatus == '0') {
        $('option[value="9"]').hide();
    } else {
        $('option[value="9"]').show();
    }
});
// Trigger change event on page load
        $('#Qstatus').trigger('change');

$('#Istatus').change(function () {
    var selectedStatus1 = $(this).val();
    if (selectedStatus1 == '0') {
        $('option[value="9"]').hide();
    } else {
        $('option[value="9"]').show();
    }

    // Hide "Approved by admin" if "Pending" is selected
    if (selectedStatus1 == '9') {
        $('option[value="0"]').hide();
    } else {
        $('option[value="0"]').show();
    }
});
// Trigger change event on page load
$('#Istatus').trigger('change');

$('#Dstatus').change(function () {
    var selectedStatus2 = $(this).val();
    if (selectedStatus2 == '0' || selectedStatus2 == '10') {
        $('option[value="9"]').hide();
    } else {
        $('option[value="9"]').show();
    }

    // Hide "Approved by admin" if "Pending" is selected
    if (selectedStatus2 == '9') {
        $('option[value="0"]').hide();
    } else {
        $('option[value="0"]').show();
    }
});
// Trigger change event on page load
$('#Dstatus').trigger('change');
    </script>
<script>
function validateForm2(event) {
    const inputFields = document.querySelectorAll('#Cname, #Ctype, #Cemail, #Cphone, #Cstreet, #Ccity, #Cpostcode, #Cstate, #governmentName, #governmentPhone, #Aname, #Aphone');
    let isValid = true;
    let unfilledFields = [];

    const customerType = document.getElementById('Ctype').value;
    const fieldsToExclude = {
        '1': ['governmentName', 'governmentPhone', 'Aname', 'Aphone'],
        '2': ['Aname', 'Aphone'],
        '3': ['governmentName', 'governmentPhone']
    };

    inputFields.forEach(field => {
        const fieldId = field.getAttribute('id');
        const fieldValue = field.value.trim();

        // Check for required fields based on customer type, excluding certain fields
        if (fieldValue === '' && !fieldsToExclude[customerType].includes(fieldId)) {
            isValid = false;
            field.style.border = '1px solid red';
            unfilledFields.push(fieldId);
        }
    });

    // Validate numerical values for specific fields
    const numericalFields = ['Cphone', 'governmentPhone', 'Aphone'];

    numericalFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        const fieldValue = field.value.trim();

        // Check if the field is not empty and is not a valid number
        if (fieldValue && isNaN(fieldValue)) {
            isValid = false;
            field.style.border = '1px solid red';
            alert(`Please enter a valid number for ${fieldName}`);
        }

        // Check if the field is a phone number and has a minimum length of 8 digits
        if (fieldName === 'Cphone' && fieldValue.length < 8) {
            isValid = false;
            field.style.border = '1px solid red';
            alert('Please enter a valid phone number with a minimum of 8 digits for Cphone');
        }

        if (customerType === '2' && fieldName === 'governmentPhone' && fieldValue.length < 8) {
            isValid = false;
            field.style.border = '1px solid red';
            alert('Please enter a valid phone number with a minimum of 8 digits for governmentPhone');
        }

        if (customerType === '3' && fieldName === 'Aphone' && fieldValue.length < 8) {
            isValid = false;
            field.style.border = '1px solid red';
            alert('Please enter a valid phone number with a minimum of 8 digits for Aphone');
        }
    });

    // Alert for unfilled required fields
    if (!isValid) {
        if (unfilledFields.length > 0) {
            const unfilledFieldsMsg = `Please fill in the following required fields: ${unfilledFields.join(', ')}`;
            alert(`${unfilledFieldsMsg}\nPlease fill in all the required fields and enter valid numbers.`);
        } else {
            alert('Please fill in all the required fields and enter valid numbers.');
        }
        event.preventDefault(); // Prevent form submission if validation fails
    }
}

    document.addEventListener('DOMContentLoaded', function() {
    const ctypeDropdown = document.getElementById('Ctype');
    const governmentFields = document.getElementById('governmentFields');
    const agencyFields = document.getElementById('agencyFields');

    // Function to handle showing/hiding fields based on selected value
    function showHideFields() {
        if (ctypeDropdown.value === '1') {
            governmentFields.style.display = 'none';
            agencyFields.style.display = 'none';
        } else if (ctypeDropdown.value === '3') {
            governmentFields.style.display = 'none';
            agencyFields.style.display = 'block';
        } else {
            governmentFields.style.display = 'block';
            agencyFields.style.display = 'none';
        }
    }

    // Add event listener to the dropdown
    ctypeDropdown.addEventListener('change', showHideFields);

    // Execute the function to show/hide fields based on the initially selected value
    showHideFields();
});

$(document).ready(function() {
    $('.addMaterial').on('click', function() {
        console.log('Button Clicked');
        // Show the modal for editing
        $('#addMaterialModal').modal('show');
    });

    $('#addMaterialModal').on('shown.bs.modal', function () {
        // Initialize autocomplete after the modal is shown
        $("#Mname").autocomplete({
            source: function (request, response) {
                var searchTerm = request.term;
                var materialType = $("#Mtype").val();
                $.ajax({
                    url: "autocomplete.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        term: searchTerm,
                        materialType: materialType
                    },
                    success: function (data) {
                        response(data);
                        console.log("success");
                        console.log("Received data:", data); // Log the received data
                    },
                    error: function (xhr, status, error) {
                        console.log("error");
                    }
                });
            },
            minLength: 1,
            open: function(event, ui) {
                // Adjust the z-index of the autocomplete dropdown
                $(".ui-autocomplete").css("z-index", 9999);
            },
            select: function (event, ui) {
                var selectedTerm = ui.item.value;
                $.ajax({
                    url: 'fetch_material_options.php',
                    method: 'POST',
                    dataType: 'json',
                    data: { searchTerm: selectedTerm },
                    success: function (data) {
                        // Empty the select dropdowns
                        $('#Mvariation, #Mdimension').empty();
                        // Populate Material Variation dropdown
                        data.variation.forEach(function (variation) {
                            $('#Mvariation').append($('<option>').text(variation).attr('value', variation));
                        });
                        // Populate Material Dimension dropdown
                        data.dimension.forEach(function (dimension) {
                            $('#Mdimension').append($('<option>').text(dimension).attr('value', dimension));
                        });
                        // Set Material Unit label text
                        $('#materialUnitLabel').text('(' + data.unit[0] + ')');
                        // Enable the Save Material button if needed
                        $('#saveMaterial').prop('disabled', false);
                        fetchMaterialPrice();
                    },
                    error: function (xhr, status, error) {
                        // Handle the error within JavaScript
                        // For example, display an error message on the UI
                        $('#errorDisplay').text('Error: No material name found');
                        // You can also perform other actions or UI updates based on the error
                        // For instance, disable the Save Material button or clear certain fields
                        $('#saveMaterial').prop('disabled', true);
                        $('#Mvariation, #Mdimension').empty();
                    }
                });
            }
        });
    });
});

function fetchMaterialPrice() {
    // Fetch the selected values
    const materialName = document.getElementById('Mname').value;
    const materialVariation = document.getElementById('Mvariation').value;
    const materialDimension = document.getElementById('Mdimension').value;

    // Send these values to the server (PHP) using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_material_price.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = xhr.responseText;
                // Split response into cost and price
                const [cost, price] = response.split(',');

                // Update Material Cost and Price input fields with the fetched values
                document.getElementById('Mcost').value = cost;
                document.getElementById('Mcost').readOnly = true; // Set Cost field as read-only
                document.getElementById('Mprice').value = price;
            } else {
                // Handle error
                console.error('No this material in database');
            }
        }
    };

    const data = {
        Mname: materialName,
        Mvariation: materialVariation,
        Mdimension: materialDimension,
    };

    xhr.send(JSON.stringify(data));
}

// Function to handle the change event
function handleChange() {
    fetchMaterialPrice(); // Call the function to fetch material price
}

// Get references to the elements by their IDs
const mVariation = document.getElementById('Mvariation');
const mDimension = document.getElementById('Mdimension');

// Attach the event listener to each element
mVariation.addEventListener('change', handleChange);
mDimension.addEventListener('change', handleChange);

document.getElementById('Dtype').addEventListener('change', function() {
    var percentageFields = document.getElementById('percentageFields');
    var amountFields = document.getElementById('amountFields');

    if (this.value === '1') {
        percentageFields.style.display = 'block';
        amountFields.style.display = 'none';
        clearInputFields('MdiscountAmt'); // Clear amountFields input
    } else if (this.value === '2') {
        percentageFields.style.display = 'none';
        amountFields.style.display = 'block';
        clearInputFields('MdiscountPerc'); // Clear percentageFields input
    }
});

function clearInputFields(inputId) {
    var inputField = document.getElementById(inputId);
    if (inputField) {
        inputField.value = '';
    }
}

$('.deleteMaterial').on('click', function() {
    var materialID = $(this).data('materialid');
    var aoid = $(this).data('aoid'); // Get the material ID from the button
    $('#aoid').val(aoid);

    // AJAX call to delete the material
    $.ajax({
        type: 'POST',
        url: 'delete_material.php', // Change to your PHP file handling deletion
        data: { material_id: materialID, ao_id: aoid },
        success: function(response) {
            // Handle success - maybe refresh the table or show a success message
            console.log('Material deleted successfully');
            location.reload(); // Refresh the page
        },
        error: function(xhr, status, error) {
            // Handle error - show an error message or log the error
            console.error(error);
        }
    });
});

$('.editMaterial').on('click', function() {
    var materialID = $(this).data('materialid'); // Get the material ID from the button
    console.log('Material ID:', materialID); // Log the material ID to the console
    var aoid = $(this).data('aoid'); // Get the material ID from the button
    $('#edit_material_id').val(materialID);
    $('#aoid').val(aoid);
    console.log('AOrder id:', aoid); // Log the material ID to the console

    // AJAX call to fetch material details for editing
    $.ajax({
        type: 'POST',
        url: 'get_material_details.php', // Change to your PHP file to retrieve material details
        data: { material_id: materialID, ao_id: aoid },
        success: function(response) {
            // Populate the modal with the retrieved material details
            var material = JSON.parse(response); // Parse the JSON response
            $('#edit_Mtype').val(material.T_Desc);
            $('#edit_Mname').val(material.AM_name);
            $('#edit_Mvariation').val(material.AM_variation);
            $('#edit_Mdimension').val(material.AM_dimension);
            $('#edit_Munit').val(material.AOM_unit);
            $('#edit_Mprice').val(material.AOM_adjustprice);
            $('#edit_Mcost').val(material.AOM_origincost);
            $('#edit_Mquantity').val(material.AOM_qty);
            $('#edit_MdiscountPerc').val(material.AOM_discPct);
            $('#edit_MdiscountAmt').val(material.AOM_discAmt);
            $('#edit_taxcode').val(material.AOM_taxcode);
            $('#edit_taxamount').val(material.AOM_taxAmt);

            // Show the modal for editing
            $('#editMaterialModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle error - show an error message or log the error
            console.error(error);
        }
    });
});

document.getElementById('Dtype1').addEventListener('change', function() {
        var percentageFields = document.getElementById('percentageFields1');
        var amountFields = document.getElementById('amountFields1');

        if (this.value === '1') {
            percentageFields.style.display = 'block';
            amountFields.style.display = 'none';
            clearInputFields('edit_MdiscountAmt'); // Clear amountFields input
        } else if (this.value === '2') {
            percentageFields.style.display = 'none';
            amountFields.style.display = 'block';
            clearInputFields('edit_MdiscountPerc'); // Clear percentageFields input
        }
    });

function validateEditedMaterial() {
    // Retrieve updated values from modal inputs
        var editedMaterialUnit = document.getElementById('edit_Munit').value;
        var editedMaterialPrice = document.getElementById('edit_Mprice').value;
        var editedQuantity = document.getElementById('edit_Mquantity').value;

        // Retrieve additional values from modal inputs
        var discountType = document.getElementById('Dtype1').value;
        var editedDiscountPerc = document.getElementById('edit_MdiscountPerc').value;
        var editedDiscountAmt = document.getElementById('edit_MdiscountAmt').value;
        var editedTaxCode = document.getElementById('edit_taxcode').value;
        var editedTaxAmount = document.getElementById('edit_taxamount').value;

     // Validation for non-empty fields
            if (
                editedMaterialUnit.trim() === '' ||
                editedMaterialPrice.trim() === '' ||
                editedQuantity.trim() === ''
            ) {
                alert('Please fill in all fields.');
                return; // Prevent further execution if any field is empty
            }
            
        // Additional validation for discount and tax fields based on discount type
        if (discountType === '1' && editedDiscountPerc.trim() === '') {
            alert('Please fill in the Discount Percentage.');
            return;
        } else if (discountType === '2' && editedDiscountAmt.trim() === '') {
            alert('Please fill in the Discount Amount.');
            return;
        }

        // Perform numeric validations for quantity, cost, price, discounts, and tax
        if (
            !validateNumericInput(editedQuantity, 'Quantity') ||
            !validateNumericInput(editedMaterialPrice, 'Price') ||
            (discountType === '1' && !validateNumericInput(editedDiscountPerc, 'Discount Percentage')) ||
            (discountType === '2' && !validateNumericInput(editedDiscountAmt, 'Discount Amount')) ||
            !validateNumericInput(editedTaxAmount, 'Tax Amount')
        ) {
            return;
        }

        // Validation for whole number input (quantity)
        if (
            isNaN(parseFloat(editedQuantity)) || // Check if quantity is not a number
            !Number.isInteger(parseFloat(editedQuantity)) // Check if quantity is not an integer
        ) {
            alert('Quantity should be a whole number.');
            return; // Prevent further execution if quantity is not a whole number
        }

    return true; // All required fields are filled
}

document.getElementById('saveEditedMaterial').addEventListener('click', function() {
    if (validateEditedMaterial()) {
        // Get the edited values from the modal inputs
        var editedMaterial = {
            materialID: $('#edit_material_id').val(),
            Munit: $('#edit_Munit').val(),
            Mcost: $('#edit_Mcost').val(),
            Mprice: $('#edit_Mprice').val(),
            Mquantity: $('#edit_Mquantity').val(),
            MdiscountPerc: $('#edit_MdiscountPerc').val(),
            MdiscountAmt: $('#edit_MdiscountAmt').val(),
            taxcode: $('#edit_taxcode').val(),
            taxamount: $('#edit_taxamount').val(),
            ao_id: '<?php echo"$ao_id"; ?>'
        };
        console.log(editedMaterial);

        // AJAX call to save the edited data
        $.ajax({
            type: 'POST',
            url: 'save_edited_material.php', // Replace with your PHP file to handle saving
            data: editedMaterial,
            success: function(response) {
                // Handle success - maybe show a success message or refresh the table
                console.log('Material edited and saved successfully');
                $('#editMaterialModal').modal('hide'); // Hide the modal after saving
                location.reload(); // Refresh the page
            },
            error: function(xhr, status, error) {
                // Handle error - show an error message or log the error
                console.error(error);
            }
        });
    }
});

document.getElementById('saveAddMaterial').addEventListener('click', function() {
    if (validateForm()) {
        // Get the edited values from the modal inputs
        var addMaterial = {
            o_id: '<?php echo"$ao_id"; ?>',
            Mtype: $('#Mtype').val(),
            Mname: $('#Mname').val(),
            Mvariation: $('#Mvariation').val(),
            Mdimension: $('#Mdimension').val(),
            Mcost: $('#Mcost').val(),
            Mprice: $('#Mprice').val(),
            Munit: $('#Munit').val(),
            Mquantity: $('#Mquantity').val(),
            taxcode: $('#taxcode').val(),
            taxamount: $('#taxamount').val()
        };

        console.log('Data to be sent:', addMaterial);

        // AJAX call to save the edited data
        $.ajax({
            type: 'POST',
            url: 'save_Aaddorder.php', // Replace with your PHP file to handle saving
            data: addMaterial,
            success: function(response) {
                // Handle success - maybe show a success message or refresh the table
                console.log('Material added and saved successfully');
                $('#addMaterialModal').modal('hide'); // Hide the modal after saving
                location.reload(); // Refresh the page
            },
            error: function(xhr, status, error) {
                // Handle error - show an error message or log the error
                console.error(error);
            }
        });
    }
});

function validateForm() {
    // Get values from input fields
    var materialType = document.getElementById('Mtype').value;
    var materialName = document.getElementById('Mname').value;
    var materialVariation = document.getElementById('Mvariation').value;
    var materialDimension = document.getElementById('Mdimension').value;
    var materialUnit = document.getElementById('Munit').value;
    var materialCost = document.getElementById('Mcost').value;
    var materialPrice = document.getElementById('Mprice').value;
    var quantity = document.getElementById('Mquantity').value;
    var discountPct = document.getElementById('MdiscountPerc').value;
    var discountAmt = document.getElementById('MdiscountAmt').value;
    var taxCode = document.getElementById('taxcode').value;
    var taxAmt = document.getElementById('taxamount').value;
    var discountType = document.getElementById('Dtype').value;

    // Use default values (0 in this case) if discountPct or discountAmt is null
    var discountPercentage = discountPct ? parseFloat(discountPct) : 0;
    var discountAmount = discountAmt ? parseFloat(discountAmt) : 0;

    // Validation for numeric input
    if (
        !validateNumericInput(quantity, 'Quantity') ||
        !validateNumericInput(materialCost, 'Cost') ||
        !validateNumericInput(materialUnit, 'Unit') ||
        !validateNumericInput(taxAmt, 'Tax Amount') ||
        !validateNumericInput(materialPrice, 'Price')
    ) {
        return false;
    }

    // Validation for whole number input
    if (
        isNaN(parseFloat(quantity)) || // Check if quantity is not a number
        !Number.isInteger(parseFloat(quantity)) // Check if quantity is not an integer
    ) {
        alert('Quantity should be a whole number.');
        return false; // Prevent further execution if quantity is not a whole number
    }

    if (discountType === '1') {
        // Percentage discount selected
        if (!validateNumericInput(discountPct, 'Discount Percentage')) {
            return false;
        }

        // Check if all required fields are filled
        if (
            !materialType ||
            !materialName ||
            !materialVariation ||
            !materialDimension ||
            !materialUnit ||
            !materialCost ||
            !materialPrice ||
            !quantity ||
            !discountPct || // No comma here
            !taxCode ||
            !taxAmt
        ) {
            alert('Please fill in all required fields.');
            return false; // Prevent further execution if fields are empty
        }

    } else if (discountType === '2') {
        // Amount discount selected
        if (!validateNumericInput(discountAmt, 'Discount Amount')) {
            return false;
        }

        // Check if all required fields are filled
        if (
        !materialType ||
        !materialName ||
        !materialVariation ||
        !materialDimension ||
        !materialUnit ||
        !materialCost ||
        !materialPrice ||
        !quantity ||
        !discountAmt ||
        !taxCode ||
        !taxAmt

        ) {
            alert('Please fill in all required fields.');
            return false; // Prevent further execution if fields are empty
        }
    }

    // If all required fields are filled, allow the form to submit
    return true;
}

function validateNumericInput(value, fieldName) {
    if (value.trim() === '') {
        alert(`${fieldName} should not be empty.`);
        return false;
    }

    if (isNaN(parseFloat(value))) {
        alert(`${fieldName} should be a valid number.`);
        return false;
    }

    if (parseFloat(value) < 0) {
        alert(`${fieldName} should be a non-negative number.`);
        return false;
    }
    
    return true;
}
</script>
<script>
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10 // Initial page length
        });
    });
    </script>
    <?php 


?>

<script>
$(document).ready(function() {
    $("#generateButton").click(function () {
        $("#AquotationForm")[0].reset();
        $("#generateModal").modal("show");
    });

    $('#GenerateAQ').on('click', function () {
        var dueDate = $("#dueDate").val();

    if (!dueDate) {
        alert('Please fill out all required fields.');
        return;
    }
        $.ajax({
            type: "POST",
            url: "generateAQ.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#AquotationForm").serialize(),
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");
                window.location.href = "EditAOrder.php?id=<?php echo urlencode($rows['U_id']); ?>&o_id=<?php echo $ao_id; ?>";

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
        var expiryDate = $("#expiryDate").val();

        if (!expiryDate) {
            alert('Please fill out all required fields.');
            return;
        }
        console.log("Generate I submit button clicked");
        $.ajax({
            type: "POST",
            url: "generateInvoice.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#IForm").serialize(),  // Corrected selector
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");
                window.location.href = "EditAOrder.php?id=<?php echo urlencode($rows['U_id']); ?>&o_id=<?php echo $ao_id; ?>";

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
        var deliveryDate = $("#deliveryDate").val();
    
        if (!deliveryDate) {
            alert('Please fill out all required fields.');
            return;
        }
        console.log("Generate DO submit button clicked");
        $.ajax({
            type: "POST",
            url: "generateDO.php?fid=<?php echo urlencode($rows['U_id']); ?>",
            data: $("#DOForm").serialize(),  // Corrected selector
            success: function(response) {
                console.log(response);
                alert("Document generated successfully");
                window.location.href = "EditAOrder.php?id=<?php echo urlencode($rows['U_id']); ?>&o_id=<?php echo $ao_id; ?>";

                // Close the modal after successful generation
                $("#generateDOModal").modal("hide");
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Error generating document. Please try again.");
            }
        });
    });

});

</script>
<script>
    $(document).ready(function() {
        $('#dataTableNew').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });
    });
</script>
</body>

</html>