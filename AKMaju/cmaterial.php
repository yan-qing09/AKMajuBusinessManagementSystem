<?php
include ('dbconnect.php');
include ('mysession.php');

$sql3 = "SELECT * FROM tb_cm_type";
$sqld = "SELECT * FROM tb_construction_material 
        WHERE is_archived = 1";
$sql2 = "SELECT CM.*, CT.T_desc 
        FROM tb_construction_material CM 
        LEFT JOIN tb_cm_type CT ON CM.CM_type = CT.CM_type 
        WHERE CM.is_archived = 0";

$sql = "SELECT * FROM tb_construction_material 
        WHERE is_archived = 0";
$result = mysqli_query($con,$sql);
$result2 = mysqli_query($con,$sql2);
$result4 = mysqli_query($con,$sql3);
$result5 = mysqli_query($con,$sqld);
$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);
if (isset($_GET['cmCategory'])) {
    $selectedCategory = $_GET['cmCategory'];
    if ($selectedCategory === '1' || $selectedCategory === '2') {
        // Query construction materials based on the selected category using JOIN
        $sql = "SELECT cm.*
                FROM tb_construction_material cm
                JOIN tb_cm_type ct ON cm.CM_type = ct.CM_type
                WHERE ct.CM_ctgy = '$selectedCategory'";
        $result = mysqli_query($con, $sql);
    }
};
include('datableheader.php');
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Construction Material</title>
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
<script src='https://cdn.tailwindcss.com/3.2.4'></script>

</head>
<body id="page-top">
<div id="wrapper">
<?php include ('navbar.php');?>
<div class="d-flex flex-column" id="content-wrapper">
<div id="content">
<nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
<div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
<h3 class="text-dark mb-0">Construction Material</h3>
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
<h3 class="text-dark mb-4">Construction Material Details</h3>
<p>
        <a href="javascript:void(0);" onclick="showCard('typeCard');" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Material Type</a>
        /
        <a href="javascript:void(0);" onclick="showCard('activeCard');" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Active Material</a>
        /
        <a href="javascript:void(0);" onclick="showCard('inactiveCard');" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Inactive Material</a>
    </p>
</div>
</div>
</div>
 <div class="container-fluid">
                    <div class="card shadow" id="typeCard">
                        <div class="card-header py-3" >
                            <p class="text-primary m-0 fw-bold">Material Type</p>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 3px;">
                            <a class="btn btn-primary float-right " role="button" style="text-align: justify;"data-bs-toggle="modal" data-bs-target="#modal-new-type"><i class="fa fa-plus" style="position: sticky;"></i> New</a>
                            <a style="color:white;"class="btn btn-success float-right me-2" role="button" style="text-align: justify;"data-bs-toggle="modal" data-bs-target="#modal-edit-type">Edit</a>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable25">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Type ID</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row=mysqli_fetch_array($result4)){
                                                   $sql4 = "SELECT C_desc FROM tb_cm_ctgy
                                                 WHERE CM_ctgy = " . $row['CM_ctgy'];
                                                  $resultCDesc = mysqli_query($con, $sql4);
                                                   $rowCDesc = mysqli_fetch_array($resultCDesc);
                                                echo "<tr>";
                                                echo "<td>" . $rowCDesc['C_desc'] . "</td>";
                                                echo "<td>".$row['CM_type']. "</td>";
                                                echo "<td>".$row['T_desc']. "</td>";
                                                echo "</tr>";
                                            
                                            }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
<div class="container-fluid">
<div class="card shadow"id="activeCard">
<div class="card-header py-3" >
<p class="text-primary m-0 fw-bold">Active Material </p>
</div>
 <div class="card-body">
            <div class="row">
                <div class="col">
                    <form method="GET">
                        <input type='hidden' name='id' value='<?php echo $fid; ?>'>
                        <button class="btn  <?php echo ($_GET['cmCategory'] ?? '') === 'All' ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="cmCategory" value="All">All</button>
                        <button class="btn <?php echo ($_GET['cmCategory'] ?? '') === '2' ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="cmCategory" value="2">Kejuruteraan Awam</button>
                        <button class="btn <?php echo ($_GET['cmCategory'] ?? '') === '1' ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="cmCategory" value="1">Elektrik</button>
                    </form>
                </div>
                <div class="col">
                        <a class="btn btn-primary float-right" role="button" data-bs-toggle="modal" data-bs-target="#modal-new"><i class="fa fa-plus" style="position: sticky;"></i>&nbsp;New</a>
                </div>
            </div>
<div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
<table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable23">
<thead>
<tr>
<th>Type</th>
<th >Subtype</th>
<th >ID</th>
<th>Name</th>
<th>Unit</th>
<th>Variation</th>
<th>Price (RM)</th>
<th>Last Modified</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
while ($row = mysqli_fetch_array($result)) {
    $typeSql = "SELECT T_desc FROM tb_cm_type WHERE cm_type = '{$row['CM_type']}'";
    $typeResult = mysqli_query($con, $typeSql);
    $typeRow = mysqli_fetch_assoc($typeResult);
    $typeDescription = isset($typeRow['T_desc']) ? $typeRow['T_desc'] : $row['CM_type'];

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalId = 'modal-edit-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "';
        var modalTrigger = document.getElementById('modalTrigger-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "');
        var myModal = new bootstrap.Modal(document.getElementById(modalId));
        modalTrigger.addEventListener('click', function() {
            myModal.show();
            });
        });
</script>";
echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "'));
            var deleteTrigger= document.getElementById('deleteTrigger-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "');

            deleteTrigger.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent form submission
                deleteModal.show();
            });
        });
    </script>";

            echo "<tr>";
            echo "<td>" . $row['CM_type'] . "</td>";
            echo "<td>" . $row['CM_subtype'] . "</td>";
            echo "<td>" . $row['CM_id'] . "</td>";
            echo "<td>" . $row['CM_name'] . "</td>";
            echo "<td>" . $row['CM_unit'] . "</td>";
            echo "<td>" . $row['CM_variation'] . "</td>";
            echo "<td>" . $row['CM_price'] . "</td>";
            echo "<td>" . $row['CM_lastMod'] . "</td>";
            echo "<td>";
            echo "<span>";
                echo "<div>";
                    echo "<button class='btn btn-primary' type='button' id='modalTrigger-" . $row['CM_id'] . "" . $row['CM_type'] . "" . $row['CM_variation'] . "' >";
                        echo "<i class='fa fa-pencil-square-o'></i>";
                    echo "</button>";
                echo "</div>";
            echo "</span>";
        echo "</td>";
            echo "</tr>";


echo "<div class='modal fade' role='dialog' tabindex='-1' id='modal-edit-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
    <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
        <div class='modal-content'>
            <div class='modal-header' style='margin: 0px;'>
                <h4 class='modal-title' style='color: rgb(0,0,0);'>Material: " . $row['CM_id'] . "</h4>
                <button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
            </div>
            <div class='modal-body'>
                <form method='post' action='editCmaterial.php?id=" . $fid . "&mid=" . $row['CM_id'] . "&mtype=" . $row['CM_type'] . "&mvariation=" . $row['CM_variation'] . "'>
                    <div class='container'>
                        <div class='row' style='margin-top:5px;'>
                            <div class='col-md-12'>
                                <label class='form-label'>Type</label>
                                <input class='form-control' type='text' name='fcmeditype' value='" . $row['CM_type'] . "-" . $typeDescription . "' readonly>
                            </div>
                        </div>
                        <div class='row' style='margin-top:20px;'>
                            <div class='col-md-12'>
                                <label class='form-label'>Subtype</label>
                                <textarea class='form-control' name='fcmeditsub'>" . $row['CM_subtype'] . "</textarea>
                            </div>
                        </div>
                        <div class='row' style='margin-top:20px;'>
                            <div class='col-md-12'>
                                <label class='form-label'>Name</label>
                                <textarea class='form-control' name='fcmeditname'>" . $row['CM_name'] . "</textarea>
                            </div>
                        </div>
                        <div class='row' style='margin-top:20px;'>
                            <div class='col-md-6'>
                                <div></div>
                                <label class='form-label'>Variation</label>
                                <input class='form-control' name='fcmeditvariation' type='text' value='" . $row['CM_variation'] . "'>
                            </div>
                        </div>
                        <div class='row' style='margin-top:20px;'>
                            <div class='col-md-6'>
                                <div></div>
                                <label class='form-label'>Unit</label>
                                <input class='form-control' name='fcmeditunit' type='text' value='" . $row['CM_unit'] . "'>
                            </div>
                            <div class='col-md-6'>
                                <div></div>
                                <label class='form-label'>Price</label>
                                <input class='form-control' name='fcmeditprice' type='text' value='" . $row['CM_price'] . "'><br>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <div class='container'>
                            <div class='row'>
                                <div class='col-sm-5 col-xxl-6 d-inline-flex justify-content-start' style='flex: 0 0 auto !important; width: 255px !important;'>
                                    <button class='btn btn-danger' id='deleteTrigger-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "'>Delete</button>
                                </div>
                                <div class='col-sm-5 col-xxl-6 d-inline-flex justify-content-end'>
                                    <button class='btn btn-light' type='reset' data-bs-dismiss='modal'>Reset</button>
                                    <button class='btn btn-primary' type='submit' data-bs-dismiss='modal'>Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>";


echo "<div class='modal fade' role='dialog' tabindex='-1' id='deleteModal-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <div class='modal-header' style='margin: 0px;'>
                <h4 class='modal-title' style='color: rgb(0,0,0);'>Delete Material</h4>
                <button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
            </div>
            <div class='modal-body'>
                <p style='color: rgb(0,0,0);'>Do you want to delete " . $row['CM_id'] . ":" . $row['CM_name'] . "?</p>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                <a href='deleteCmaterial.php?id=" . $fid . "&mid=" . $row['CM_id'] . "&mtype=" . $row['CM_type'] . "&mvariation=" . $row['CM_variation'] . "' class='btn btn-danger' style='background: rgb(205,10,10);' type='button'>Delete</a>
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
<div class="card-header py-3">
<p class="text-primary m-0 fw-bold">Inactive Material </p>
</div>
<div class="card-body">
<div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
<table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable26">
<thead>
<tr>
<th>Type</th>
<th >Subtype</th>
<th >ID</th>
<th>Name</th>
<th>Unit</th>
<th>Variation</th>
<th>Price (RM)</th>
<th>Last Modified</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
while ($row = mysqli_fetch_array($result5)) {
$typeSql = "SELECT T_desc FROM tb_cm_type WHERE cm_type = '{$row['CM_type']}'";
$typeResult = mysqli_query($con, $typeSql);
$typeRow = mysqli_fetch_assoc($typeResult);
$typeDescription = isset($typeRow['T_desc']) ? $typeRow['T_desc'] : $row['CM_type'];

echo "<script>
document.addEventListener('DOMContentLoaded', function() {
var restoreModal = new bootstrap.Modal(document.getElementById('restoreModal-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "'));
var restoreTrigger= document.getElementById('restoreTrigger-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "');

restoreTrigger.addEventListener('click', function(event) {
event.preventDefault(); // Prevent form submission
restoreModal.show();
});
});
</script>";

echo "<tr>";
echo "<td>" . $row['CM_type'] . "</td>";
echo "<td>" . $row['CM_subtype'] . "</td>";
echo "<td>" . $row['CM_id'] . "</td>";
echo "<td>" . $row['CM_name'] . "</td>";
echo "<td>" . $row['CM_unit'] . "</td>";
echo "<td>" . $row['CM_variation'] . "</td>";
echo "<td>" . $row['CM_price'] . "</td>";
echo "<td>" . $row['CM_lastMod'] . "</td>";
 echo "<td>";                                        
echo "<span>";
    echo "<div>";
        echo "<button class='btn btn-warning' type='button' id='restoreTrigger-" . $row['CM_id'] . "" . $row['CM_type'] . "" . $row['CM_variation'] . "'>";
            echo "<i class='fas fa-trash-restore'></i>";
        echo "</button>";
    echo "</div>";
echo "</span>";
echo "</td>";
echo "</tr>";


echo "<div class='modal fade' role='dialog' tabindex='-1' id='restoreModal-" . $row['CM_id'] . $row['CM_type'] . $row['CM_variation'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
<div class='modal-dialog modal-dialog-centered' role='document'>
<div class='modal-content'>
<div class='modal-header' style='margin: 0px;'>
<h4 class='modal-title' style='color: rgb(0,0,0);'>Restore Material</h4>
<button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
</div>
<div class='modal-body'>
<p style='color: rgb(0,0,0);'>Do you want to restore " . $row['CM_id'] . ":" . $row['CM_name'] . "?</p>
</div>
<div class='modal-footer'>
<button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
<a href='restoreCmaterial.php?id=" . $fid . "&mid=" . $row['CM_id'] . "&mtype=" . $row['CM_type'] . "&mvariation=" . $row['CM_variation'] . "' class='btn btn-warning' type='button'>Restore</a>
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
</div>
</div>
</div>
<footer class="bg-white sticky-footer">
<div class="container my-auto">
<div class="text-center my-auto copyright"><span>Copyright © Brand 2023</span></div>
</div>
</footer>
</div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
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
echo"<form method='post' action='addCmaterial.php?id=".$rows['U_id']."'>";
?>
<div class="container">
<div class="row" style="margin-top:-5px;">
<div class="col-md-5">
<label class="form-label">ID</label>
<input class="form-control" type="text" required="" maxlength="6" name="fcmid" required>
</div>
<div class="col-md-7">
<label class="form-label">Category</label><br>
<select class="form-control" name="category" id="categorySelect" required>
    <option value="1">Elektrik</option>
    <option value="2">Kejuruteraan Awam</option>
</select>
</div>
</div>
<div class="row" style="margin-top:10px;">
<div class="col-md-12">
<label class="form-label">Type</label><br>
<select class="form-control" name="fcmtype" id="typeSelect" required>
</select>
</div>
<div class="row"style="margin-top:10px;">
<div class="col-md-12">
<label class="form-label">Subtype</label>
<input class="form-control" type="text" required="" name="fcmsub" maxlength="150" required>
</div>
</div>
<div class="row"style="margin-top:10px;">
<div class="col-md-12">
<label class="form-label">Name</label>
<input class="form-control" type="text" required="" name="fcmname" required>
</div>
</div>
<div class='row' style='margin-top: 15px;'>
<div class="col-md-12">
<label class="form-label">Variation</label>
<input class="form-control" type="text" required="" maxlength="150" name="fcmvariation" required>
</div>
</div>
<div class='row' style='margin-top: 10px;'>
<div class="col-md-6">
<label class="form-label">Unit</label>
<input class="form-control" type="text" required="" maxlength="5" name="fcmunit" required>
</div>
<div class="col-md-6">
<label class="form-label">Price (RM)</label>
<input class="form-control" type="number" step="0.01" min="0" max="99999.99" name="fcmprice" required>
<br>
</div>
</div>

</div>
<div class="modal-footer">
<button class="btn btn-light" type="reset" data-bs-dismiss="modal">Reset</button>
<button class="btn btn-primary" type="submit" >Create</button>
</div>
</form>
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
echo"<form method='post' action='addCMType.php?id=".$rows['U_id']."'>";
?>
<div class="container">
<div class="row" style="margin-top:-5px;">
<div class="col-md-6">
<label class="form-label">Category</label><br>
<select class="form-control" name="fcmtctgy" id="categorySelect" required>
    <option value="1">Elektrik</option>
    <option value="2">Kejuruteraan Awam</option>
</select>
</div>
<div class="col-md-6">
<label class="form-label">Type ID</label><br>
<input class="form-control" name="fcmtypeid" id="typeSelect" required>
</div>
</div>
<div class="row"style="margin-top:10px;">
<div class="col-md-12">
<label class="form-label">Description</label>
<textarea class="form-control" type="text" required="" name="fcmtdesc" required></textarea>
</div>
</div>
<br>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-light" type="reset" data-bs-dismiss="modal">Reset</button>
<button class="btn btn-primary" type="submit" >Create</button>
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
                <form method='post' action='editCMType.php?id=<?php echo $rows['U_id']; ?>'>
                     <div class='container'>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label class='form-label'>Type ID</label>
                            </div>
                            <div class='col-md-3'>
                                <label class='form-label'>Category</label>
                            </div>
                            <div class='col-md-3'>
                                <label class='form-label'>Description</label>
                            </div>
                        </div>
                    <?php
                    // Reset the pointer of the result set
                    mysqli_data_seek($result4, 0);

                    // Loop through the rows and generate dynamic input fields
                    while ($row4 = mysqli_fetch_assoc($result4)) {
                         $sql5 = "SELECT CM_ctgy, C_desc FROM tb_cm_ctgy";
                        $resultC = mysqli_query($con, $sql5);
                        echo "
                            <div class='row' style='margin-top:-5px;'>
                                <div class='col-md-3'>
                                    <input class='form-control' type='text' name='editcmtype[]' value=" . $row4['CM_type'] . " readonly>
                                </div>
                                <div class='col-md-3'>
                                   <select class='form-control' name='editcmctgy[]' required>";
                
                while ($rowC = mysqli_fetch_assoc($resultC)) {
                    $selected = ($row4['CM_ctgy'] == $rowC['CM_ctgy']) ? 'selected' : '';
                    echo "<option value='" . $rowC['CM_ctgy'] . "' $selected>" . $rowC['C_desc'] . "</option>";
                }

                echo "
                            </select>
                        </div>
                        <div class='col-md-6'>
                            <textarea class='form-control' name='editcmtdesc[]' required>" . $row4['T_desc'] . "</textarea>
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
<script>
   $(document).ready(function() {
    $('#dataTable23').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "order": [[0, "asc"]],
        responsive: true
       });
    });
</script>
<script>
   $(document).ready(function() {
    $('#dataTable25').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "order": [[0, "asc"]],
        responsive: true
       });
    });
</script>
<script>
   $(document).ready(function() {
    $('#dataTable26').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "order": [[0, "asc"]],
        responsive: true
       });
    });
</script>
<script>
    $(document).ready(function() {
        $('#categorySelect').change(function() {
            var categoryId = $(this).val();

            // AJAX call to get types based on the selected category
            $.ajax({
                url: 'getTypes.php',
                method: 'POST',
                data: { categoryId: categoryId },
                dataType: 'json',
                success: function(response) {
                    $('#typeSelect').empty(); // Clear previous options

                    // Append new options based on the fetched data
                    $.each(response, function(index, type) {
                        $('#typeSelect').append('<option value="' + type.CM_type + '">' + type.CM_type +'-'+type.T_desc + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="assets/js/Sidebar-Menu-sidebar.js"></script>
<script src="assets/js/theme.js"></script>
</body>
</html>