<?php
include ('dbconnect.php');
include ('mysession.php');

$sql = "SELECT *
        FROM tb_customer
        LEFT JOIN tb_advertisement_order ON tb_customer.C_id = tb_advertisement_order.C_id
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        WHERE tb_advertisement_order.O_status = 2";


$result = mysqli_query($con,$sql);

$sql5 = "SELECT *
        FROM tb_customer
        LEFT JOIN tb_advertisement_order ON tb_customer.C_id = tb_advertisement_order.C_id
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        WHERE tb_advertisement_order.O_status = 3";


$result5 = mysqli_query($con,$sql5);

$sql6 = "SELECT *
        FROM tb_customer
        LEFT JOIN tb_advertisement_order ON tb_customer.C_id = tb_advertisement_order.C_id
        LEFT JOIN tb_customer_phone ON tb_customer.C_id = tb_customer_phone.C_id
        WHERE tb_advertisement_order.O_status = 1";


$result6 = mysqli_query($con,$sql6);

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);
include('datableheader.php')

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en" data-bss-forced-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Advertisement Order</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="shortcut icon" type="image/jpg" href="assets/img/dogs/akmaju.jpg"/>
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/sidebar-style4.css">

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
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-4">Advertisement Order</h3>
                        <?php 
                            echo"<a href='AddAOrder.php?id=".$rows['U_id']."' class='btn btn-primary' role='button' style='text-align: center;'>";
                            echo"<i class='fa fa-plus' style='position: sticky;'></i>&nbsp; Add Order";
                            echo"</a>";
                        ?>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Order Info</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2" id="dataTable2">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Order Date</th>
                                            <th style="min-width: 300px;">Customer Name</th>
                                            <th>Contact Number</th>
                                            <th>Order Remark</th>
                                            <th>Total Price</th>
                                            <th>Total Cost</th>
                                            <th style="min-width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        while($row = mysqli_fetch_array($result)) {
                                            echo "<tr>";
                                                echo "<td class='o_id'>".$row['O_id']."</td>";
                                                echo "<td>".$row['O_date']."</td>";
                                                echo "<td>".$row['C_name']."</td>";
                                                echo "<td>".$row['C_phone']."</td>";
                                                echo "<td>".$row['O_remark']."</td>";
                                                echo "<td>RM".$row['O_totalPrice']."</td>";
                                                echo "<td>RM".$row['O_totalCost']."</td>";
                                                echo "<td>";
                                                    echo "<span>";
                                                        echo "<div>";
                                                            echo "<a href='EditAOrder.php?id=".$rows['U_id']."&o_id=".$row['O_id']."' class='btn btn-primary m-1' role='button'>";
                                                            echo"<i class='fas fa-book-open'></i>";
                                                            echo"</a>";

                                                            echo "<button class='btn btn-danger m-1 delete-btn' type='button' data-bs-toggle='modal' data-bs-target='#modal-1' data-o-id='".$row['O_id']."'>";
                                                            echo "<i class='fas fa-trash'></i>";
                                                            echo "</button>";

                                                            echo "<button class='btn btn-success m-1' type='button' style='width: 35px; height: 35px; margin-top: -10px; display: flex; justify-content: center; align-items: center;'  data-bs-toggle='modal' data-bs-target='#modal-2-" . $row['O_id'] . "' data-o-id='".$row['O_id']."'>
    <i class='material-icons' style='color: white;font-size:20px'>check</i>
</button>";
                                                        echo "</div>";
                                                    echo "</span>";
                                                echo "</td>";
                                            echo "</tr>";
                                            echo "<div class='modal fade' role='dialog' tabindex='-1' id='modal-1' style='margin: 0px; margin-top: 0px; text-align: left;'>
                                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header' style='margin: 0px;'>
                                                                <h4 class='modal-title' style='color: rgb(0,0,0);'>" . htmlspecialchars($row['O_id']) . " Delete Order</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p style='color: rgb(0,0,0);'>Do you sure you want to delete this order?</p>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                <a href='deleteAorder.php?id=" . $rows['U_id'] . "&o_id=" . $row['O_id'] . "' class='btn btn-danger' style='background: rgb(205,10,10);'>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                            echo "<div class='modal fade' role='dialog' tabindex='-1' id='modal-2-" . $row['O_id'] . "' style='margin: 0px; margin-top: 0px; text-align: left;'>
                                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header' style='margin: 0px;'>
                                                            <h4 class='modal-title' style='color: rgb(0,0,0);'>" . htmlspecialchars($row['O_id']) . " Complete Order</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p style='color: rgb(0,0,0);'>Do you sure this order completed?</p>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                            <button class='btn btn-danger' onclick='confirmCompletion(\"" . sprintf('%03d', $fid) . "\", \"" . $row['O_id'] . "\", " . $row['AO_paymentStatus'] . ")' style='background: rgb(205,10,10);'>Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";

                                            // Add a script section
                                            echo "<script>
                                                function confirmCompletion(userId, orderId, paymentStatus) {
                                                    if (paymentStatus != 8) {
                                                        alert('Cannot confirm completion for user ' + userId + '. orderid ' + orderId + '. payment ' + paymentStatus + '. AO_paymentStatus is not 8.');
                                                    } else {
                                                        // Redirect to the specified link
                                                        window.location.href = 'completeAorder.php?id=' + userId + '&o_id=' + orderId;
                                                    }
                                                }
                                            </script>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Cancelled Order</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2" id="dataTable3">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Order Date</th>
                                            <th style="min-width: 300px;">Customer Name</th>
                                            <th>Contact Number</th>
                                            <th>Order Remark</th>
                                            <th>Total Price</th>
                                            <th>Total Cost</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        while($row5 = mysqli_fetch_array($result5)) {
                                            echo "<tr>";
                                                echo "<td class='o_id'>".$row5['O_id']."</td>";
                                                echo "<td>".$row5['O_date']."</td>";
                                                echo "<td>".$row5['C_name']."</td>";
                                                echo "<td>".$row5['C_phone']."</td>";
                                                echo "<td>".$row5['O_remark']."</td>";
                                                echo "<td>RM".$row5['O_totalPrice']."</td>";
                                                echo "<td>RM".$row5['O_totalCost']."</td>";
                                                echo "<td>";
                                                    echo "<span>";
                                                        echo "<div>";
                                                            echo "<a href='AOrderDetails.php?id=".$rows['U_id']."&o_id=".$row5['O_id']."' class='btn btn-primary m-1' role='button'>";
                                                            echo"<i class='fas fa-book-open'></i>";
                                                            echo"</a>";
                                                        echo "</div>";
                                                    echo "</span>";
                                                echo "</td>";
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
                            <p class="text-primary m-0 fw-bold">Complete Order</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2" id="dataTable4">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Order Date</th>
                                            <th style="min-width: 300px;">Customer Name</th>
                                            <th>Contact Number</th>
                                            <th>Order Remark</th>
                                            <th>Total Price</th>
                                            <th>Total Cost</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        while($row6 = mysqli_fetch_array($result6)) {
                                            echo "<tr>";
                                                echo "<td class='o_id'>".$row6['O_id']."</td>";
                                                echo "<td>".$row6['O_date']."</td>";
                                                echo "<td>".$row6['C_name']."</td>";
                                                echo "<td>".$row6['C_phone']."</td>";
                                                echo "<td>".$row6['O_remark']."</td>";
                                                echo "<td>RM".$row6['O_totalPrice']."</td>";
                                                echo "<td>RM".$row6['O_totalCost']."</td>";
                                                echo "<td>";
                                                    echo "<span>";
                                                        echo "<div>";
                                                            echo "<a href='AOrderDetails.php?id=".$rows['U_id']."&o_id=".$row6['O_id']."' class='btn btn-primary m-1' role='button'>";
                                                            echo"<i class='fas fa-book-open'></i>";
                                                            echo"</a>";
                                                        echo "</div>";
                                                    echo "</span>";
                                                echo "</td>";
                                            echo "</tr>";
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
        <script>
    $(document).ready(function() {
        $('#dataTable2').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });

        $('#dataTable3').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });

        $('#dataTable4').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });
    });
</script>
    <script>
    // Capture the click event on delete buttons and store AO_id in the modal
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const oId = button.getAttribute('data-o-id');
            const modalDeleteButton = document.querySelector('#modal-1 .btn-danger');
            
            // Find the closest row from the clicked delete button
            const row = button.closest('tr');
            
            // Fetch AO_id from the row itself
            const rowOId = row.querySelector('.o_id').innerText.trim();
            
            // Set the correct AO_id for deletion
            modalDeleteButton.setAttribute('href', `deleteAorder.php?id=<?php echo $rows['U_id']; ?>&o_id=${rowOId}`);

            // Update the modal title with the specific AO_id (if necessary)
            const modalTitle = document.querySelector('#modal-1 .modal-title');
            modalTitle.innerHTML = `${rowOId} Delete Order`;
        });
    });
</script>
 <script src='https://cdn.jsdelivr.net/gh/itaypanda/simpletoast@master/SimpleToast.min.js'></script>
<script src='https://cdn.tailwindcss.com/3.2.4'></script>
 <script>
    <?php if (!empty($message)) : ?>
        toastInit();
        toast('Low Stock Alert', '<?php echo $message; ?>', toastStyles.error);
    <?php endif; ?>
</script>
</body>

</html>