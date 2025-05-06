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

$co_id = $_GET['co_id']; // Capture the orderid from the URL

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

$sql4 = "SELECT * FROM tb_customer WHERE C_id = (SELECT C_id FROM tb_construction_order WHERE O_id = '$co_id')";
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

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result5 = mysqli_query($con, $sql5);
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);


if ($result5) {
    // Fetch the customer details
    $order5 = mysqli_fetch_assoc($result5);
}

$sqlAtop = "SELECT TOP_name FROM tb_terms_of_payment WHERE TOP_id = (SELECT O_TOP FROM tb_construction_order WHERE O_id = '$co_id')";
$resultAtop = mysqli_query($con, $sqlAtop);

if ($resultAtop) {
    $orderAtop = mysqli_fetch_assoc($resultAtop);
    $Atop = isset($orderAtop['TOP_name']) ? $orderAtop['TOP_name'] : '';
}

// Fetch data from the database to populate the dropdown
$queryMT = "SELECT T_Desc FROM tb_cm_type"; 
$resultMT = $con->query($queryMT);

include ('COrderheader.php');
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en" data-bss-forced-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Construction Order</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
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
                        <h3 class="text-dark mb-0">Construction Order Management</h3>
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
                        <h3 class="text-dark mb-4">Manage Order Details</h3>
                    </div>
                    <?php
                        echo "<div class='mb-3'>
                        <a href='EditCEOrdermaterial.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Electric Order Material</button></a>
                        <a href='EditKABuruh.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Kadar Awam</button></a>
                        <a href='EditKAOrdermaterial.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Kejuteraan Awam Order Material</button></a>
                        <a href='save_CEditorder.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Order Summary</button></a>
                        </div>";
                    ?>
                    <div class="card shadow mb-3">
                        <?php
                        echo "<form method='post' action='update_Ccustomer_details.php?id=".$rows['U_id']."&co_id=".$row6['O_id']."' onsubmit='return validateForm2(event)'>"
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
                                        <input class="form-control" type="text" id="Cemail" placeholder="123@gmail.com" name="Cemail" value="<?php echo isset($customer4['C_email']) ? $customer4['C_email'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cphone">
                                            <strong>Customer phone</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cphone" placeholder="0123456789" name="Cphone" value="<?php echo isset($cPhone) ? $cPhone : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cstreet">
                                            <strong>Street</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cstreet" placeholder="Street Details" name="Cstreet" value="<?php echo isset($customer4['C_street']) ? $customer4['C_street'] : ''; ?>"readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Ccity">
                                            <strong>City</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Ccity" placeholder="City Details" name="Ccity" value="<?php echo isset($customer4['C_city']) ? $customer4['C_city'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cpostcode">
                                            <strong>Postcode</strong>
                                        </label>
                                        <input class="form-control" type="number" id="Cpostcode" placeholder="Postcode Details" name="Cpostcode" value="<?php echo isset($customer4['C_postcode']) ? $customer4['C_postcode'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="Cstate">
                                            <strong>State</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Cstate" placeholder="State Details" name="Cstate" value="<?php echo isset($customer4['C_state']) ? $customer4['C_state'] : ''; ?>" readonly>
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
                                            <input class="form-control" type="text" id="governmentName" placeholder="Government Name" name="governmentName" value="<?php echo isset($Gname) ? $Gname : ''; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="governmentPhone">
                                                <strong>Government Phone</strong>
                                            </label>
                                            <input class="form-control" type="text" id="governmentPhone" placeholder="Government Phone" name="governmentPhone" value="<?php echo isset($Gphone) ? $Gphone : ''; ?>" readonly>
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
                                            <input class="form-control" type="text" id="Aname" placeholder="Agency Name" name="Aname" value="<?php echo isset($Aname) ? $Aname : ''; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Aphone">
                                                <strong>Agency Phone</strong>
                                            </label>
                                            <input class="form-control" type="Phone" id="Aphone" placeholder="Agency Phone" name="Aphone" value="<?php echo isset($Aphone) ? $Aphone : ''; ?>" readonly>
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
                        echo "<form method='post' action='update_Corder_details.php?id=".$rows['U_id']."&co_id=".$row6['O_id']."'>"
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
                                        <label class="form-label" for="COdate"><strong>Order Date</strong></label>
                                        <input class="form-control" type="date" id="COdate" placeholder="date" name="COdate" value="<?php echo isset($order5['O_date']) ? $order5['O_date'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="COremark"><strong>Order Remark</strong></label>
                                        <input class="form-control" type="text" id="COremark" placeholder="Sign Board to AKMaju" name="COremark" value="<?php echo isset($order5['O_remark']) ? $order5['O_remark'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3"><label class="form-label" for="TOP"><strong>Term of Payment</strong></label>
                                        <?php
                                        $queryMT = "SELECT * FROM tb_terms_of_payment"; 
                                        $resultMT = $con->query($queryMT);

                                        $sqlAtop = "SELECT TOP_name FROM tb_terms_of_payment WHERE TOP_id = (SELECT O_TOP FROM tb_construction_order WHERE O_id = '$co_id')";
                                        $resultAtop = mysqli_query($con, $sqlAtop);

                                        $selectedTOP = ""; // Initialize variable to store selected TOP_name

                                        if ($resultAtop && $rowAtop = mysqli_fetch_assoc($resultAtop)) {
                                            $selectedTOP = $rowAtop['TOP_name']; // Get the TOP_name from the second query
                                        }

                                        if ($resultMT && $resultMT->num_rows > 0) {
                                            echo '<select class="form-select" id="TOP" name="TOP" disabled>';
                                            while ($rowMT = $resultMT->fetch_assoc()) {
                                                $MTDesc = $rowMT['TOP_name'];
                                                $MTvalue = $rowMT['TOP_desc'];

                                                // Check if the current option's TOP_name matches the selected TOP_name
                                                $selectedAttribute = ($MTDesc === $selectedTOP) ? 'selected' : '';

                                                echo "<option value='$MTDesc' $selectedAttribute>$MTvalue</option>";
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
                        <?php
                        echo "<form method='post' action='update_Corder_status.php?id=".$fid."&co_id=".$co_id."'>"
                        ?> 
                        <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse3" aria-expanded="false" aria-controls="orderSummaryCollapse3">
                            <p class="text-primary m-0 fw-bold">Order Status</p>
                        </div>
                        <div class="collapse" id="orderSummaryCollapse3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div id="dataTable_quotation" class="dataTables_length" aria-controls="dataTable">
                                        <label class="form-label">
                                            <strong>Quotation Status&nbsp;</strong>
                                            <select class="d-inline-block form-select form-select-sm" id="Qstatus" name="Qstatus">
                                                <option value="1" <?php echo ($order5['O_quotationStatus'] == 0) ? 'selected' : ''; ?>>Not Generated</option>
                                                <option value="9" <?php echo ($order5['O_quotationStatus'] == 4) ? 'selected' : ''; ?>>Accepted by customer</option>
                                                <option value="5" <?php echo ($order5['O_quotationStatus'] == 5) ? 'selected' : ''; ?>>Rejected by customer</option>
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
                        <?php
                        echo "<form method='post' action='update_Einfo.php?id=".$fid."&co_id=".$co_id."'>"
                        ?> 
                            <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse2" aria-expanded="false" aria-controls="orderSummaryCollapse2">
                                <p class="text-primary m-0 fw-bold">Electric Information</p>
                            </div>
                            <div class="collapse" id="orderSummaryCollapse2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="EKnegeri">
                                                <strong>Negeri</strong>
                                            </label>
                                            <?php
                                            $queryNegeri = "SELECT DISTINCT Z_state FROM tb_zone WHERE CM_ctgy = 1";
                                            $resultNegeri = $con->query($queryNegeri);

                                            $querySNegeri = "SELECT DISTINCT Z_state FROM tb_order_zone WHERE O_id = '$co_id' AND CM_ctgy = 1";
                                            $resultSNegeri = $con->query($querySNegeri);
                                            $rowSNegeri = $resultSNegeri->fetch_assoc();

                                            if ($resultNegeri && $resultNegeri->num_rows > 0) {
                                                echo '<select class="form-select" id="EKnegeri" name="EKnegeri">';
                                                while ($rowNegeri = $resultNegeri->fetch_assoc()) {
                                                    $NegeriDesc = $rowNegeri['Z_state'];
                                                    echo "<option value='$NegeriDesc' " . (($NegeriDesc == $rowSNegeri['Z_state']) ? 'selected' : '') . ">$NegeriDesc</option>";
                                                }
                                                echo '</select>';
                                            } else {
                                                echo '<select class="form-select" id="EKnegeri" name="EKnegeri">';
                                                echo '<option value="">No options available</option>';
                                                echo '</select>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="EKdaerah">
                                                <strong>Daerah</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="EKdaerah" name="EKdaerah">
                                            <?php
                                            $queryDaerah = "SELECT DISTINCT Z_region FROM tb_order_zone WHERE O_id = '$co_id' AND CM_ctgy = 1";
                                            $resultDaerah = $con->query($queryDaerah);
                                            $rowDaerah = $resultDaerah->fetch_assoc();

                                            echo "<option value='" . $rowDaerah['Z_region'] . "' " . (($rowDaerah['Z_region']) ? 'selected' : '') . ">" . $rowDaerah['Z_region'] . "</option>";
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="EKkawasan">
                                                <strong>Kawasan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="EKkawasan" name="EKkawasan">
                                                <?php
                                                $queryJarak = "SELECT DISTINCT Z_distance FROM tb_order_zone WHERE O_id = '$co_id' AND CM_ctgy = 1";
                                                $resultJarak = $con->query($queryJarak);
                                                $rowJarak = $resultJarak->fetch_assoc();
                                                ?>
                                                <option value="A" <?php echo ($rowJarak['Z_distance'] == 'A') ? 'selected' : ''; ?>>A: kurang dari 16km</option>
                                                <option value="B" <?php echo ($rowJarak['Z_distance'] == 'B') ? 'selected' : ''; ?>>B: 16-32km</option>
                                                <option value="C" <?php echo ($rowJarak['Z_distance'] == 'C') ? 'selected' : ''; ?>>C: 32-48km</option>
                                                <option value="D" <?php echo ($rowJarak['Z_distance'] == 'D') ? 'selected' : ''; ?>>D: lebih dari 48km</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="EKtambahan">
                                                <strong>Tambahan Peratusan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="EKtambahan" name="EKtambahan">
                                                <?php
                                                $queryTambahan = "SELECT DISTINCT EK_addon FROM tb_construction_order WHERE O_id = '$co_id'";
                                                $resultTambahan = $con->query($queryTambahan);
                                                $rowTambahan = $resultTambahan->fetch_assoc();
                                                ?>
                                                <option value="1" <?php echo ($rowTambahan['EK_addon'] == '1') ? 'selected' : ''; ?>>Tiada</option>
                                                <option value="2" <?php echo ($rowTambahan['EK_addon'] == '2') ? 'selected' : ''; ?>>Jalan ke tempat kerja hanya boleh dilalui oleh kenderaan darat berjentera beroda dua atau kenderaan berjentera yang mempunyai pacuan empat roda</option>
                                                <option value="3" <?php echo ($rowTambahan['EK_addon'] == '3') ? 'selected' : ''; ?>>Jalan ke tempat kerja hanya boleh dilalui menggunakan kenderaan air dengan mengharungi sungai, tasik atau laut, tanpa jambatan</option>
                                            </select>
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
                        echo "<form method='post' action='update_AKinfo.php?id=".$fid."&co_id=".$co_id."'>"
                        ?> 
                            <div class="card-header py-3" data-bs-toggle="collapse" data-bs-target="#orderSummaryCollapse4" aria-expanded="false" aria-controls="orderSummaryCollapse4">
                                <p class="text-primary m-0 fw-bold">Kejuteraan Awam Information</p>
                            </div>
                            <div class="collapse" id="orderSummaryCollapse4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="AKnegeri">
                                                <strong>Negeri</strong>
                                            </label>
                                            <?php
                                            $queryAKNegeri = "SELECT DISTINCT Z_state FROM tb_zone WHERE CM_ctgy = 2";
                                            $resultAKNegeri = $con->query($queryAKNegeri);

                                            $querySAKNegeri = "SELECT DISTINCT Z_state FROM tb_order_zone WHERE O_id = '$co_id' AND CM_ctgy = 2";
                                            $resultSAKNegeri = $con->query($querySAKNegeri);
                                            $rowSAKNegeri = $resultSAKNegeri->fetch_assoc();

                                            if ($resultAKNegeri && $resultAKNegeri->num_rows > 0) {
                                                echo '<select class="form-select" id="AKnegeri" name="AKnegeri">';
                                                while ($rowAKNegeri = $resultAKNegeri->fetch_assoc()) {
                                                    $NegeriAKDesc = $rowAKNegeri['Z_state'];
                                                    echo "<option value='$NegeriAKDesc' " . (($NegeriAKDesc == $rowSAKNegeri['Z_state']) ? 'selected' : '') . ">$NegeriAKDesc</option>";
                                                }
                                                echo '</select>';
                                            } else {
                                                echo '<select class="form-select" id="AKnegeri" name="AKnegeri">';
                                                echo '<option value="">No options available</option>';
                                                echo '</select>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="AKdaerah">
                                                <strong>Daerah</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="AKdaerah" name="AKdaerah">
                                                <?php
                                            $queryAKDaerah = "SELECT DISTINCT Z_region FROM tb_order_zone WHERE O_id = '$co_id' AND CM_ctgy = 2";
                                            $resultAKDaerah = $con->query($queryAKDaerah);
                                            $rowAKDaerah = $resultAKDaerah->fetch_assoc();

                                            echo "<option value='" . $rowAKDaerah['Z_region'] . "' " . (($rowAKDaerah['Z_region']) ? 'selected' : '') . ">" . $rowAKDaerah['Z_region'] . "</option>";
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="AKkawasan">
                                                <strong>Kawasan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="AKkawasan" name="AKkawasan">
                                                <?php
                                                $queryAKJarak = "SELECT DISTINCT Z_distance FROM tb_order_zone WHERE O_id = '$co_id' AND CM_ctgy = 2";
                                                $resultAKJarak = $con->query($queryAKJarak);
                                                $rowAKJarak = $resultAKJarak->fetch_assoc();
                                                ?>
                                                <option value="A" <?php echo ($rowAKJarak['Z_distance'] == 'A') ? 'selected' : ''; ?>>A: kurang dari 16km</option>
                                                <option value="B" <?php echo ($rowAKJarak['Z_distance'] == 'B') ? 'selected' : ''; ?>>B: 16-32km</option>
                                                <option value="C" <?php echo ($rowAKJarak['Z_distance'] == 'C') ? 'selected' : ''; ?>>C: 32-48km</option>
                                                <option value="D" <?php echo ($rowAKJarak['Z_distance'] == 'D') ? 'selected' : ''; ?>>D: lebih dari 48km</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="AKtambahan">
                                                <strong>Tambahan Peratusan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="AKtambahan" name="AKtambahan">
                                                <?php
                                                $queryAKTambahan = "SELECT DISTINCT AK_addon FROM tb_construction_order WHERE O_id = '$co_id'";
                                                $resultAKTambahan = $con->query($queryAKTambahan);
                                                $rowAKTambahan = $resultAKTambahan->fetch_assoc();
                                                ?>
                                                <option value="1" <?php echo ($rowAKTambahan['AK_addon'] == '1') ? 'selected' : ''; ?>>Tiada</option>
                                                <option value="2" <?php echo ($rowAKTambahan['AK_addon'] == '2') ? 'selected' : ''; ?>>Jalan ke tempat kerja hanya boleh dilalui oleh kenderaan darat berjentera beroda dua atau kenderaan berjentera yang mempunyai pacuan empat roda</option>
                                                <option value="3" <?php echo ($rowAKTambahan['AK_addon'] == '3') ? 'selected' : ''; ?>>Jalan ke tempat kerja tidak boleh dilalui oleh kenderaan berjentera</option>
                                                <option value="4" <?php echo ($rowAKTambahan['AK_addon'] == '4') ? 'selected' : ''; ?>>Jalan ke tempat kerja tidak boleh dihalang oleh sungai tanpa jambatan ataupun laut</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save</button></div>
                            </div>
                            </div>
                            </form>
                        </div>
                        <?php
                        echo "<div class='mb-3'>
                        <a href='EditCEOrdermaterial.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Electric Order Material ></button></a>
                        </div>";
                    ?>
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

document.getElementById('EKnegeri').addEventListener('change', function() {
    var selectedValue = this.value;
    var selectdaerah = document.getElementById('EKdaerah');

    // Clear existing options
    selectdaerah.innerHTML = '';

    if (selectedValue !== '') {
        // Use fetch to retrieve data based on selected Mtype
        fetch('get_ekdaerah.php?mt=' + selectedValue)
            .then(response => response.json())
            .then(data => {
                // Populate Mname select with retrieved options
                data.forEach(function(option) {
                    var optionElement = document.createElement('option');
                    optionElement.value = option.value;
                    optionElement.textContent = option.text;
                    selectdaerah.appendChild(optionElement);
                });
            })
            .catch(error => {
                console.error('Error fetching EKdaerah:', error);
            });
    }
});

document.getElementById('AKnegeri').addEventListener('change', function() {
    var selectedValue = this.value;
    var selectdaerah = document.getElementById('AKdaerah');

    // Clear existing options
    selectdaerah.innerHTML = '';

    if (selectedValue !== '') {
        // Use fetch to retrieve data based on selected Mtype
        fetch('get_akdaerah.php?mt=' + selectedValue)
            .then(response => response.json())
            .then(data => {
                // Populate Mname select with retrieved options
                data.forEach(function(option) {
                    var optionElement = document.createElement('option');
                    optionElement.value = option.value;
                    optionElement.textContent = option.text;
                    selectdaerah.appendChild(optionElement);
                });
            })
            .catch(error => {
                console.error('Error fetching EKdaerah:', error);
            });
    }
});

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

function validateForm(event) {
const inputFields = document.querySelectorAll('#Cname, #Ctype, #Cemail, #Cphone, #Cstreet, #Ccity, #Cpostcode, #Cstate, #governmentName, #governmentPhone, #Aname, #Aphone, #COdate, #COremark, #addonprice, #TOP');
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
const numericalFields = ['addonprice'];

numericalFields.forEach(fieldName => {
    const field = document.getElementById(fieldName);
    const fieldValue = field.value.trim();

    // Check if the field is not empty and is not a valid number
    if (fieldValue && isNaN(fieldValue)) {
        isValid = false;
        field.style.border = '1px solid red';
        alert(`Please enter a valid number for ${fieldName}`);
    }
});

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails

        // Alert for unfilled required fields
        if (unfilledFields.length > 0) {
            const unfilledFieldsMsg = `Please fill in the following required fields: ${unfilledFields.join(', ')}`;
            alert(`${unfilledFieldsMsg}\nPlease fill in all the required fields and enter valid numbers.`);
        } else {
            alert('Please fill in all the required fields and enter valid numbers.');
        }
    }
} 
</script>

</body>

</html>