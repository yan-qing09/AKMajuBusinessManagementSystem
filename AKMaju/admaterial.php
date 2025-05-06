<?php
include ('dbconnect.php');
include ('mysession.php');


$sql = "SELECT *FROM tb_advertisement_material
        WHERE is_archived=0";
$sql2 = "SELECT *FROM tb_am_type";
$result2 = mysqli_query($con,$sql2);
$result = mysqli_query($con,$sql);
$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);
$sqlb = "SELECT *FROM tb_advertisement_material
        WHERE is_archived=1";
$resultb = mysqli_query($con,$sqlb);
$sqlm="SELECT U_type FROM tb_user
        WHERE U_id='$fid'";
$result4 = mysqli_query($con,$sqlm);
$rowm=mysqli_fetch_array($result4);
include ('datableheader.php');
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Advertisement Material</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans&amp;display=swap">
<link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
<link rel="stylesheet" href="assets/fonts/material-icons.min.css">
<link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
<link rel="stylesheet" href="assets/css/Filter.css">
<link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
<link rel="stylesheet" href="assets/css/sidebar-style4.css">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set default view to Active Material
        showCard('activeCard');
    });

    function showCard(cardId) {
        // Hide all cards
        document.getElementById('typeCard').style.display = 'none';
        document.getElementById('activeCard').style.display = 'none';
        document.getElementById('inactiveCard').style.display = 'none';

        // Show the selected card
        document.getElementById(cardId).style.display = 'block';
    }
</script>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Advertisement Material</h3>
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

                <div class="container">
                <div class="row">
                <div class="col-md-6">
                        <h3 class="text-dark mb-4">Advertisement Material</h3>
                        <p>
        <a href="javascript:void(0);" onclick="showCard('typeCard');" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Material Type</a>
        /
        <a href="javascript:void(0);" onclick="showCard('activeCard');" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Active Material</a>
        /
        <a href="javascript:void(0);" onclick="showCard('inactiveCard');" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Inactive Material</a>
    </p>
                </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <?php 
                                echo"<a class='btn btn-success' role='button' style='color: white;' href='admaterial-history.php?id=".$rows['U_id']."'><i class='fa fa-history' style='position: sticky;''></i>&nbsp;History</a>";
                                ?>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="card shadow" id="typeCard">
                        <div class="card-header py-3" >
                            <p class="text-primary m-0 fw-bold">Material Type</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                                <!-- Content in the first column, if any -->
                            </div>
                            <div class="col d-flex justify-content-end">
                            
                            <a style="color:white;"class="btn btn-success float-right me-2" role="button" style="text-align: justify;"data-bs-toggle="modal" data-bs-target="#modal-edit-type">Edit</a>
                            <a class="btn btn-primary float-right" role="button" style="text-align: justify;"data-bs-toggle="modal" data-bs-target="#modal-new-type"><i class="fa fa-plus" style="position: sticky;"></i> New</a>
                        </div>
                    </div>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable25">
                                    <thead>
                                        <tr>
                                            <th>Type ID</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row=mysqli_fetch_array($result2)){
                                                echo "<tr>";
                                                echo "<td>".$row['AM_type']. "</td>";
                                                echo "<td>".$row['T_Desc']. "</td>";
                                                echo "</tr>";
                                            
                                            }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                <div class="container-fluid">
                    <div class="card shadow" id="activeCard">
                        <div class="card-header py-3" >
                            <p class="text-primary m-0 fw-bold">Active Material</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                                <!-- Content in the first column, if any -->
                            </div>
                            <div class="col d-flex justify-content-end">
                                <a class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#modal-new">
                                    <i class="fa fa-plus"></i>&nbsp;New
                                </a>
                            </div>
                        </div>
                            <div class="table-responsive table mt-2 " role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable">
                                    <thead>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Variation</th>
                                        <th>Dimension</th>
                                         <?php if ($rowm['U_type'] === 'Admin') {
                                        echo '<th>Cost</th>';
                                        }?>
                                        <th>Price</th>
                                        <th>Markup</th>
                                        <th>Unsold</th>
                                        <th>Selling</th>
                                        <th>Status</th>
                                        <th>Last Modified</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($row=mysqli_fetch_array($result))
                                        {
                                            echo" <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var modalId = 'modal-edit-" . $row['AM_id'] . "';
                                        var modalTrigger = document.getElementById('modalTrigger-" . $row['AM_id'] . "');
                                        var myModal = new bootstrap.Modal(document.getElementById(modalId));

                                        modalTrigger.addEventListener('click', function() {
                                            myModal.show();
                                        });
                                    });
                                </script>
                               <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var deleteModal" . $row['AM_id'] . " = new bootstrap.Modal(document.getElementById('deleteModal-" . $row['AM_id'] . "'));
                                        var deleteTrigger" . $row['AM_id'] . " = document.getElementById('deleteTrigger-" . $row['AM_id'] . "');

                                        deleteTrigger" . $row['AM_id'] . ".addEventListener('click', function(event) {
                                            event.preventDefault(); // Prevent form submission
                                            deleteModal" . $row['AM_id'] . ".show();
                                        });
                                    });
                                </script>
                                  <script>
                function calculateEditMarkup() {
                    var cost = parseFloat(document.getElementsByName('fameditcost')[0].value);
                    var price = parseFloat(document.getElementsByName('fameditprice')[0].value);

                    if (!isNaN(cost) && !isNaN(price)) {
                        var markup = ((price - cost) / cost) * 100;
                        document.getElementsByName('fameditmarkup')[0].value = markup.toFixed(2);
                    }
                }
                                    </script>";
                                            echo "<tr>";
                                            
                                            echo "<td>".$row['AM_id']."</td>";
                                            echo "<td>".$row['AM_name']."</td>";
                                            echo "<td>".$row['AM_type']."</td>";
                                            echo "<td>".$row['AM_variation']."</td>";
                                            echo "<td>".$row['AM_dimension']."</td>";
                                            if ($rowm['U_type'] === 'Admin') {
                                             echo '<td>' . $row['AM_cost'] . '</td>';
                                            }       
                                            echo "<td>".$row['AM_price']."</td>";
                                            echo "<td>".$row['AM_markUp']."</td>";
                                            echo "<td>".$row['AM_unsoldQty']."</td>";
                                            echo "<td>".$row['AM_sellingQty']."</td>";
                                            echo "<td>".$row['LS_status']."</td>";
                                            echo "<td>".$row['AM_lastMod']."</td>";
                                             echo "<td>";
                                                    echo "<span>";
                                                        echo "<div>";
                                                            echo "<button class='btn btn-primary' type='button' id='modalTrigger-" . $row['AM_id'] . "'>";
                                                                echo "<i class='fa fa-pencil-square-o'></i>";
                                                            echo "</button>";
                                                        echo "</div>";
                                                    echo "</span>";
                                                echo "</td>";
                                            echo "</tr>";
                                        echo "<div class='modal fade' role='dialog' tabindex='-1' id='modal-edit-" . $row['AM_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header' style='margin: 0px;'> 
                                                            <h4 class='modal-title' style='color: rgb(0,0,0);'>Material: ".$row['AM_id']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                        <form method='post' action='editAmaterial.php?id=" . $fid . "&material=" . $row['AM_id'] . "'>
                                                            <div class='container'>
                                                                <div class='row' style='margin-top:20px;'>
                                                                <div class='col-md-6'>
                                                                    <label class='form-label'>Name</label><input class='form-control' type='text' name='fameditname' value='{$row['AM_name']}' >
                                                                </div>
                                                                   
                                                                <div class='col-md-6'>
                                                                    <label class='form-label'>Type</label><input class='form-control' type='text' name='fameditype' value='{$row['AM_type']}' >
                                                                </div>
                                                                </div>
                                                                <div class='row' style='margin-top:20px;'>
                                                                <div class='col-md-6'>
                                                                    <div></div><label class='form-label'>Variation</label><input class='form-control' name='fameditvariation' type='text' value='{$row['AM_variation']}'>
                                                            </div>
                                                                <div class='col-md-6'>
                                                                    <div></div><label class='form-label'>Dimension</label><input class='form-control' type='text' name='fameditdimension' value='{$row['AM_dimension']}' >
                                                                </div>
                                                                <div class='row' style='margin-top:20px;'>
                                                                <div class='col-md-6'>
                                                                    <div></div><label class='form-label'>Unit</label><input class='form-control' maxlength='5' name='fameditunit' type='text' value='{$row['AM_unit']}'>
                                                                </div>
                                                                <div class='row' style='margin-top:20px;'>
                                                                <div class='col-md-3'>
                                                                    <div></div><label class='form-label'>Cost</label><input class='form-control' name='fameditcost' type='number' step='0.01' min='0' max='99999.99' required='' value='{$row['AM_cost']}'onchange='calculateEditMarkup()'>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div></div><label class='form-label'>Price</label><input class='form-control' name='fameditprice' type='number' step='0.01' min='0' max='99999.99' required='' value='{$row['AM_price']}'onchange='calculateEditMarkup()'>
                                                                </div>
                                                                <div class='col-md-5'>
                                                                <label class='form-label'>Markup</label>
                                                                    <div></div><input class='form-control' name='fameditmarkup' type='number' min='0' required='' value='{$row['AM_markUp']}' readonly>

                                                                </div>
                                                                <div class='row' style='margin-top:20px;'>
                                                                <div class='col-md-3'>
                                                                    <div></div><label class='form-label'>Unsold</label><input class='form-control' name='fameditunsold' id='fameditunsold'  type='number' min='0' required='' value='{$row['AM_unsoldQty']}'>
                                                                </div>
                                                                 <div class='col-md-3'>
                                                                    <div></div><label class='form-label'>Sold</label><input class='form-control' name='fameditsold' id='fameditsold'  value='{$row['AM_soldQty']}'disabled>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div></div><label class='form-label'>Selling</label><input class='form-control' name='fameditselling' id='fameditselling' type='text' value='{$row['AM_sellingQty']}'disabled>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div></div><label class='form-label'>Total</label><input class='form-control' name='fameditotal' id='fameditotal'  type='number' min='0' required='' value='{$row['AM_totalQty']}'readonly>
                                                                </div>
                                                                <div class='row' style='margin-top:20px;'>
                                                                <div class='col-md-6'>
                                                                    <div></div><label class='form-label'>Stock Status</label><input class='form-control' name='fameditstatus' type='text' value='{$row['LS_status']}'readonly>
                                                            </div>
                                                                <div class='col-md-6'>
                                                                    <div></div><label class='form-label'>Minimum Stock</label><input class='form-control'  type='number' min='0' max='99999'required='' name='fameditmin' value='{$row['LS_qty']}' ><br>
                                                                </div>
                                                            </div>

                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class='modal-footer'>
                                                        <div class='container'>
                                                            <div class='row'>
                                                                <div class='col-sm-5 col-xxl-6 d-inline-flex justify-content-start' style='flex: 0 0 auto !important; width: 255px !important;'>
                                                                <button class='btn btn-danger' id='deleteTrigger-" . $row['AM_id'] . "'>Delete</button>
                                                                </div>
                                                                <div class='col-sm-5 col-xxl-6 d-inline-flex justify-content-end'><button class='btn btn-light' type='reset' data-bs-dismiss='modal'>Reset</button>
                                                                <button class='btn btn-primary' type='submit' data-bs-dismiss='modal'>Save</button></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>";
                                            echo"<div class='modal fade' role='dialog' tabindex='-1' id='deleteModal-" . $row['AM_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                        <div class='modal-dialog modal-dialog-centered' role='document'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header' style='margin: 0px;'>
                                                                    <h4 class='modal-title' style='color: rgb(0,0,0);'>".$row['AM_id'].":".$row['AM_name']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <p style='color: rgb(0,0,0);'>Do you want to delete this user?</p>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                    <a href='deleteAmaterial.php?id=" . $fid . "&material=" . $row['AM_id'] . "' class='btn btn-danger'  style='background: rgb(205,10,10);' type='button'>Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>";
                                        }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
         
            <div class="container-fluid">
                    <div class="card shadow" id="inactiveCard">
                        <div class="card-header py-3" >
                            <p class="text-primary m-0 fw-bold">Inactive Material </p>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 3px;">
                            <br>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable2">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Variation</th>
                                        <th>Dimension</th>
                                        <th>Cost</th>
                                        <th>Price</th>
                                        <th>Markup</th>
                                        <th>Unsold</th>
                                        <th>Selling</th>
                                        <th>Status</th>
                                        <th>Last Modified</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                                            while($row=mysqli_fetch_array($resultb)){
                                            echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var restoreModal" . $row['AM_id'] . " = new bootstrap.Modal(document.getElementById('restoreModal-" . $row['AM_id'] . "'));
                                        var restoreTrigger" . $row['AM_id'] . " = document.getElementById('restoreTrigger-" . $row['AM_id'] . "');

                                        restoreTrigger" . $row['AM_id'] . ".addEventListener('click', function(event) {
                                            event.preventDefault(); // Prevent form submission
                                            restoreModal" . $row['AM_id'] . ".show();
                                        });
                                    });
                                    </script>";
                                     echo "<tr>";
                                            echo "<td>".$row['AM_id']."</td>";
                                            echo "<td>".$row['AM_name']."</td>";
                                            echo "<td>".$row['AM_type']."</td>";
                                            echo "<td>".$row['AM_variation']."</td>";
                                            echo "<td>".$row['AM_dimension']."</td>";
                                            echo "<td>".$row['AM_cost']."</td>";
                                            echo "<td>".$row['AM_price']."</td>";
                                            echo "<td>".$row['AM_markUp']."</td>";
                                            echo "<td>".$row['AM_unsoldQty']."</td>";
                                            echo "<td>".$row['AM_sellingQty']."</td>";
                                            echo "<td>".$row['LS_status']."</td>";
                                            echo "<td>".$row['AM_lastMod']."</td>";
                                            echo "<td>";
                                            
                                                    echo "<span>";
                                                        echo "<div>";
                                                            echo "<button class='btn btn-warning' type='button' id='restoreTrigger-" . $row['AM_id'] . "'>";
                                                                echo "<i class='fas fa-trash-restore'></i>";
                                                            echo "</button>";
                                                        echo "</div>";
                                                    echo "</span>";
                                                echo "</td>";
                                                echo "</tr>";
                                                echo "<div class='modal fade' role='dialog' tabindex='-1' id='restoreModal-" . $row['AM_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                        <div class='modal-dialog modal-dialog-centered' role='document'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header' style='margin: 0px;'>
                                                                    <h4 class='modal-title' style='color: rgb(0,0,0);'>".$row['AM_id'].":".$row['AM_name']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <p style='color: rgb(0,0,0);'>Do you want to restore this material?</p>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                    <a href='restoreAmaterial.php?id=" . $fid . "&material=" . $row['AM_id'] . "' class='btn btn-warning'  type='button'>Restore</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>";}?>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" role="dialog" tabindex="-1" id="modal-new-type" style="margin: 0px; margin-top: 0px; text-align: left;">
<div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
<div class="modal-content">
<div class="modal-header" style="margin: 0px;">
<h4 class="modal-title" style="color: rgb(0,0,0);">New Material Type</h4>
<button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<?php
echo"<form method='post' action='addAMType.php?id=".$rows['U_id']."'>";
?>
<div class="container">
<div class="row" style="margin-top:-5px;">
<div class="col-md-3">
<label class="form-label">Type ID</label><br>
<input class="form-control" name="fcmtypeid" id="typeSelect" required>
</div>
<div class="col-md-9">
<label class="form-label">Description</label>
<textarea class="form-control" type="text" required="" name="fcmtdesc" required></textarea>
</div>
</div>
<br>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-light" type="reset" data-bs-dismiss="modal">Reset</button>
<button class="btn btn-primary" type="submit" >Insert</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="modal fade" role="dialog" tabindex="-1" id="modal-edit-type" style="margin: 0px; margin-top: 0px; text-align: left;">
<div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down modal-dialog-scrollable" role="document">
<div class="modal-content">
<div class="modal-header" style="margin: 0px;">
<h4 class="modal-title" style="color: rgb(0,0,0);">Edit Material Type</h4>
<button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<form method='post' action='editAMType.php?id=<?php echo $rows['U_id']; ?>'>
<div class='container'>
<div class='row'>
<div class='col-md-3'>
<label class='form-label'>Type ID</label>
</div>
<div class='col-md-3'>
<label class='form-label'>Description</label>
</div>
</div>
<?php
// Reset the pointer of the result set
mysqli_data_seek($result2, 0);

// Loop through the rows and generate dynamic input fields
while ($row2 = mysqli_fetch_assoc($result2)) {
echo "
<div class='row' style='margin-top:-5px;'>
<div class='col-md-3'>
<input class='form-control' type='text' name='editamtype[]' value=" . $row2['AM_type'] . " readonly>
</div>
<div class='col-md-6'>
<textarea class='form-control' name='editamtdesc[]' required>" . $row2['T_Desc'] . "</textarea>
</div>
</div><br>";
}
?>
<div class="modal-footer">
<button class="btn btn-light" type="reset" data-bs-dismiss="modal">Reset</button>
<button class="btn btn-primary" type="submit">Save</button>
</div>
</form>
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

  <div class="modal fade" role="dialog" tabindex="-1" id="modal-new" style="margin: 0px; margin-top: 0px; text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0,0,0);">New Material</h4>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php
                echo"<form method='post' action='addAmaterial.php?id=".$rows['U_id']."'>";
                ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Type</label><br>
                                <select class="form-select" required name="famtype">
                                    <option value="" disabled selected>Select Type</option>
                                    <?php
                                    // Assume you have a database connection $con
                                    $sqlType = "SELECT * FROM tb_am_type";
                                    $resultType = mysqli_query($con, $sqlType);

                                    while ($rowType = mysqli_fetch_array($resultType)) {
                                        echo '<option value=' . $rowType['AM_type'] . '>' . $rowType['T_Desc'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input class="form-control" type="text" required="" name="famname">
                            </div>
                        </div>
                        <div class='row' style='margin-top: 15px;'>
                            <div class="col-md-6">
                                <label class="form-label">Variation</label>
                                <input class="form-control" type="text" required="" name="famvariation">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dimension</label>
                                <input class="form-control" type="text" required="" name="famdimension">
                            </div>
                        </div>
                        <div class='row' style='margin-top: 15px;'>
                            <div class="col-md-6">
                                <label class="form-label">Unit</label>
                                <input class="form-control" type="text" maxlength="5" required="" name="famunit">
                            </div>
                        </div>
                        <div class='row' style='margin-top: 15px;'>
                            <div class="col-md-6" style='width:225px;'>
                                <label class="form-label">Cost</label>
                                <input class="form-control" type="number"step="0.01" min="0" max="99999.99" required="" name="famcost">
                            </div>
                            <div class="col-md-6" style='width:225px;'>
                                <label class="form-label">Price</label>
                                <input class="form-control" type="number"step="0.01" min="0" max="99999.99" required="" name="famprice">
                            </div>
                            <div class="col-md-6" style='width:250px;'>
                                <label class="form-label">Markup (%)</label>
                                 <input class="form-control" type="text" min="0"   name="famarkup" id="famarkup" readonly>
                            </div>
                            </div>
                          <div class='row' style='margin-top: 20px;'>
                            <div class="col-md-6">
                                <label class="form-label">Minimum Stock Quantity</label>
                                <input class="form-control" type="number" min="0" max="99999" required="" name="famin"><br>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unsold Quantity</label>
                                <input class="form-control" type="number" min="0" max="99999" required="" name="famunsold">
                            </div>
                        </div>
                         
                       <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var costInput = document.querySelector('input[name="famcost"]');
                                var priceInput = document.querySelector('input[name="famprice"]');
                                var markupInput = document.querySelector('input[name="famarkup"]');

                                costInput.addEventListener('input', calculateMarkup);
                                priceInput.addEventListener('input', calculateMarkup);

                                function calculateMarkup() {
                                    var cost = parseFloat(costInput.value);
                                    var price = parseFloat(priceInput.value);

                                    if (!isNaN(cost) && !isNaN(price)) {
                                        var markup = ((price - cost) / cost) * 100;
                                        markupInput.value = markup.toFixed(2);
                                    } else {
                                        markupInput.value = ''; // Clear markup if cost or price is invalid
                                    }
                                }
                            });
</script>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Reset</button>
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            var costInputs = document.querySelectorAll('input[name="fameditcost"]');
            var priceInputs = document.querySelectorAll('input[name="fameditprice"]');
            var markupInputs = document.querySelectorAll('input[name="fameditmarkup"]');

            for (var i = 0; i < costInputs.length; i++) {
                costInputs[i].addEventListener('input', calculateEditMarkup);
                priceInputs[i].addEventListener('input', calculateEditMarkup);
            }

            function calculateEditMarkup(event) {
                var currentInput = event.target;
                var parentDiv = currentInput.closest('.row'); // Assuming each row is wrapped in a 'row' class

                var costInput = parentDiv.querySelector('input[name="fameditcost"]');
                var priceInput = parentDiv.querySelector('input[name="fameditprice"]');
                var markupInput = parentDiv.querySelector('input[name="fameditmarkup"]');

                var cost = parseFloat(costInput.value);
                var price = parseFloat(priceInput.value);

                if (!isNaN(cost) && !isNaN(price)) {
                    var markup = ((price - cost) / cost) * 100;
                    markupInput.value = markup.toFixed(2);
                } else {
                    markupInput.value = ''; // Clear markup if cost or price is invalid
                }
            }
        });
    </script>
     <script>
        document.addEventListener('input', function (event) {
            var currentInput = event.target;
            var parentDiv = currentInput.closest('.row');

            var unsoldQtyInput = parentDiv.querySelector('input[name="fameditunsold"]');
            var minStockInput = parentDiv.querySelector('input[name="fameditmin"]');
            var statusInput = parentDiv.querySelector('input[name="fameditstatus"]');
            var sellingQtyInput = parentDiv.querySelector('input[name="fameditselling"]');
            var totalQtyInput = parentDiv.querySelector('input[name="fameditotal"]');

            var unsoldQty = parseInt(unsoldQtyInput.value) || 0;
            var sellingQty = parseInt(sellingQtyInput.value) || 0;
            var minStock = parseInt(minStockInput.value) || 0;
            var totalQty = unsoldQty + sellingQty;

            totalQtyInput.value = totalQty;
            statusInput.value = unsoldQty <= minStock ? 'Low' : 'In Stock';
        });
    </script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/Sidebar-Menu-sidebar.js"></script>
    <script src="assets/js/theme.js"></script>

<script>
    $(document).ready(function() {
    $('#dataTable2').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        responsive: true
       });
    });
     $(document).ready(function() {
    $('#dataTable25').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        responsive: true
       });
    });
   $(document).ready(function() {
    $('#dataTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
         "order": [[10, "desc"]],
         responsive: true
       });
    });

</script>

</body>
</html>