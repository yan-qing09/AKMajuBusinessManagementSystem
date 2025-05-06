<?php 
include('mysession.php');
if(!session_id())
{
    session_start();
}

include ('dbconnect.php');

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);
$sqlb="SELECT *FROM tb_user
        WHERE is_archived=0";
$resultb = mysqli_query($con,$sqlb);
$adminOptions = "";
while ($row = mysqli_fetch_array($resultb)) {
    if ($row['U_type'] === 'Admin') {
        $adminOptions .= '<option value="' . $row['U_id'] . '"' . (($row['U_id'] == $fid) ? ' selected' : '') . '>' . $row['U_id'] . '-' . $row['U_name'] . '</option>';
    }
}
$sqlc="SELECT *FROM tb_supervision";
$resultc = mysqli_query($con,$sqlc);
$rowc=mysqli_fetch_array($resultc);
$sqla="SELECT *FROM tb_user
        WHERE is_archived=1";
 $resulta = mysqli_query($con,$sqla);      
$tableToDisplay = 'All'; // Assuming displaying all users by default

// Check if table selection is made
if (isset($_GET['id'], $_GET['tableSelect'])) {
    $fid = $_GET['id'];
    $selectedTable = $_GET['tableSelect'];
    if ($selectedTable === 'Admin' || $selectedTable === 'Staff') {
        $tableToDisplay = $selectedTable;
    }
}

// Fetch data based on the selected table or all users if no selection made
if ($tableToDisplay === 'All') {
    $sql5 = "SELECT * FROM tb_user WHERE is_archived=0";
} else {
    $sql5 = "SELECT * FROM tb_user WHERE U_type='$tableToDisplay' AND is_archived=0";
}
$result5 = mysqli_query($con, $sql5);
include('datableheader.php');
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Manage User</title>
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
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <h3 class="text-dark mb-0">Manage User</h3>
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
                                <div class="nav-item dropdown no-arrow"><?php echo"<div class='nav-item dropdown no-arrow'><a class='dropdown-toggle nav-link' aria-expanded='false' data-bs-toggle='dropdown' href='#''><span class='d-none d-lg-inline me-2 text-gray-600 small'>".$rows['U_id']."<br>".$rows['U_name']."</span></a>" ?>
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
                            <h3 class="text-dark mb-4">User Details</h3>
                            <p style="color: black; font-size: 16px;">
    <a href="#aUserCard" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Active User</a>
    /
    <a href="#iUserCard" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Inactive User</a>
</p>
                        </div>
                        <div class="col" style="text-align: right;">
                            <button class="btn btn-primary" type="button" style="padding-left: 11px;margin-right: 0px;margin-left: 0px;margin-bottom: 0px;margin-top: 16px;text-align: center;width: 113px;" data-bs-toggle="modal" data-bs-target="#modal-new">
                                <i class="fa fa-plus" style="position: sticky;"></i>&nbsp;New User
                            </button>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="card shadow" id="aUserCard">
                        <div class="card-header py-3" >
                            <p class="text-primary m-0 fw-bold">Active User Info </p>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 3px;">
                            <br>
                            <form method="GET">
    <input type='hidden' name='id' value='<?php echo $fid; ?>'>
    <button class="btn  <?php echo ($_GET['tableSelect'] ?? '') === 'All' ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="tableSelect" value="All">All Users</button>
    <button class="btn <?php echo ($_GET['tableSelect'] ?? '') === 'Admin' ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="tableSelect" value="Admin">Admin</button>
    <button class="btn <?php echo ($_GET['tableSelect'] ?? '') === 'Staff' ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="tableSelect" value="Staff">Staff</button>
</form>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;width: 25.6562px;padding-top: 8px;padding-bottom: 8px;margin-top: 32px;">ID</th>
                                            <th style="width: 96.831px;text-align: center;">Name</th>
                                            <th style="width: 88.194px;text-align: center;">Position</th>
                                            <th style="width: 97.837px;text-align: center;">Email</th>
                                            <th style="width: 97.837px;text-align: center;">Supervisor</th>
                                            <th style="text-align: center;width: 80px;">Last Login</th>
                                            <th style="text-align: center;width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row=mysqli_fetch_array($result5)){
                                                $sqlc = "SELECT * FROM tb_supervision WHERE U_id = '" . $row['U_id'] . "'";

                                                    $resultc = mysqli_query($con, $sqlc);
                                                    $rowc = mysqli_fetch_array($resultc);

                                                echo "
                                                <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    var modalId = 'modal-edit-" . $row['U_id'] . "';
                                                    var modalTrigger = document.getElementById('modalTrigger-" . $row['U_id'] . "');
                                                    var myModal = new bootstrap.Modal(document.getElementById(modalId));

                                                    modalTrigger.addEventListener('click', function() {
                                                        myModal.show();
                                                    });
                                                });
                                            </script>
                                            <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var deleteModal" . $row['U_id'] . " = new bootstrap.Modal(document.getElementById('deleteModal-" . $row['U_id'] . "'));
                                        var deleteTrigger" . $row['U_id'] . " = document.getElementById('deleteTrigger-" . $row['U_id'] . "');

                                        deleteTrigger" . $row['U_id'] . ".addEventListener('click', function(event) {
                                            event.preventDefault(); // Prevent form submission
                                            deleteModal" . $row['U_id'] . ".show();
                                        });
                                    });
                                </script>";
                                                echo "<tr><td style='width: 30px;text-align: center;'>".$row['U_id']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_name']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_position']. "</td>";
                                                echo "<td style='text-align: center;width: 130px;'>".$row['U_email']. "</td>";
                                                echo "<td style='text-align: center;width: 130px;'>".$rowc['Admin_id']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_lastLogin']. "</td>";;
                                                echo "<td style='text-align: center;'>";
                                                echo "<span>";
                                                    echo "<div>";
                                                        echo "<button class='btn btn-primary' type='button' id='modalTrigger-" . $row['U_id'] . "' >";
                                                            echo "<i class='fa fa-pencil-square-o'></i>";
                                                        echo "</button>";
                                                        echo "<a class='btn btn-danger m-1' type='button' id='deleteTrigger-" . $row['U_id'] . "'>";
                                                                echo "<i class='fas fa-trash'></i>";
                                                            echo "</button>";
                                                    echo "</div>";
                                                echo "</span>";
                                            echo "</td>";
                                                echo "</tr>";
                                                 //Code for modal-edit
                                                $adminSupervisorReadonly = ($row['U_type'] === 'Admin') ? 'readonly' : '';
                                                echo "<div class='modal fade' role='dialog' tabindex='-1' id='modal-edit-" . $row['U_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                <div class='modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down' role='document'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header' style='margin: 0px;'> 
                                                            <h4 class='modal-title' style='color: rgb(0,0,0);'>Edit User: ".$row['U_id']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <form method='post' action='edituser.php?id=" . $fid . "&user=" . $row['U_id'] . "' '>
                                                                <div class='container'>
                                                                    <div class='row' >
                                                                            <div></div><input class='form-control' type='hidden' name='fuid' value='{$row['U_id']}' >
 
                                                                        <div class='col-md-6'>
                                                                         <div></div><label class='form-label'>User Type</label><br>
                                                                       <div class='form-check form-check-inline' style='margin-top:5px;'>
                                                                         <input class='form-check-input' type='radio' id='feditusertype' name='feditusertype' value='Admin' " . (($row['U_type'] === 'Admin') ? 'checked disabled' : 'disabled') . ">
                                                                            <label class='form-check-label' for='usertype_admin'>Admin</label>
                                                                        </div>
                                                                        <div class='form-check form-check-inline' style='margin-left: 55px;'>
                                                                            <input class='form-check-input' type='radio' id='feditusertype' name='feditusertype' value='Staff' " . (($row['U_type'] === 'Staff') ? 'checked disabled' : 'disabled') . ">
                                                                            <label class='form-check-label' for='usertype_staff'>Staff</label>
                                                                    </div>
                                                                    </div>
                                                                    <div class='col-md-6'>
                                                                        <div></div><label class='form-label'>Name</label><input class='form-control' type='text' name='feditname' value='{$row['U_name']}' >
                                                                    </div></div>
                                                    <div class='row' style='margin-top:10px'>
        <div class='col-md-6'>
            <div></div><label class='form-label'>Supervisor</label>";
            
if ($adminSupervisorReadonly) {
    // If the user type is 'Admin', make the supervisor field readonly
    echo "<input class='form-control' type='text' name='feditsupervisor' disabled>";
} else {
    // If the user type is 'Staff', allow the user to select the option
    // Use the $adminOptions variable here
    echo "<select class='form-control' name='feditsupervisor'>"
        . '<option value="" disabled selected>Select Supervisor</option>'
        . $adminOptions
        . '</select>';
}

                                                                            
                                                                        echo "</div>
                                                                        <div class='col-md-6'>
                                                                            <div></div><label class='form-label'>Position</label><input class='form-control' type='text' name='feditposition' value='{$row['U_position']}' >
                                                                        </div></div>
                                                                         <div class='row' style='margin-top:10px'>
                                                                        <div class='col-md-6'>
                                                                            <div></div><label class='form-label'>Email</label><input class='form-control' name='feditemail' type='text' value='{$row['U_email']}'>
                                                                        </div>
                                                                    </div>
                                                                    
   </div>
                                                           
      <div class='modal-footer'><button class='btn btn-light' type='reset' data-bs-dismiss='modal'>Reset</button><button class='btn btn-primary' type='submit' >Save</a></div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>";

                                                // Code for the modal and delete link inside the while loop
                                                echo "<div class='modal fade' role='dialog' tabindex='-1' id='deleteModal-" . $row['U_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                        <div class='modal-dialog modal-dialog-centered' role='document'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header' style='margin: 0px;'>
                                                                    <h4 class='modal-title' style='color: rgb(0,0,0);'>".$row['U_id'].":".$row['U_name']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <p style='color: rgb(0,0,0);'>Do you want to delete this user?</p>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                    <a href='deleteuser.php?id=" . $fid . "&user=" . $row['U_id'] . "' class='btn btn-danger'  style='background: rgb(205,10,10);' type='button'>Delete</a>
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
                    <br>
            <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header py-3" id="iUserCard">
                            <p class="text-primary m-0 fw-bold">Inactive User Info </p>
                        </div>
                        <div class="card-body" style="padding-top: 0px;padding-bottom: 3px;">
                            <br>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable2">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;width: 25.6562px;padding-top: 8px;padding-bottom: 8px;margin-top: 32px;">ID</th>
                                            <th style="width: 96.831px;text-align: center;">Name</th>
                                            <th style="width: 88.194px;text-align: center;">Position</th>
                                            <th style="width: 97.837px;text-align: center;">Email</th>
                                            <th style="text-align: center;width: 80px;">Last Login</th>
                                            <th style="text-align: center;width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                                            while($row=mysqli_fetch_array($resulta)){
                                            echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var restoreModal" . $row['U_id'] . " = new bootstrap.Modal(document.getElementById('restoreModal-" . $row['U_id'] . "'));
                                        var restoreTrigger" . $row['U_id'] . " = document.getElementById('restoreTrigger-" . $row['U_id'] . "');

                                        restoreTrigger" . $row['U_id'] . ".addEventListener('click', function(event) {
                                            event.preventDefault(); // Prevent form submission
                                            restoreModal" . $row['U_id'] . ".show();
                                        });
                                    });
                                    </script>";
                                    echo"<tr><td style='width: 30px;text-align: center;'>".$row['U_id']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_name']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_position']. "</td>";
                                                echo "<td style='text-align: center;width: 130px;'>".$row['U_email']. "</td>";
                                                echo "<td style='text-align: center;'>".$row['U_lastLogin']. "</td>";
                                                echo "<td style='text-align: center;'>";
                                            
                                                    echo "<span>";
                                                        echo "<div>";
                                                            echo "<button class='btn btn-warning' type='button' id='restoreTrigger-" . $row['U_id'] . "'>";
                                                                echo "<i class='fas fa-trash-restore'></i>";
                                                            echo "</button>";
                                                        echo "</div>";
                                                    echo "</span>";
                                                echo "</td>";
                                                echo "</tr>";
                                            
                                                echo "<div class='modal fade' role='dialog' tabindex='-1' id='restoreModal-" . $row['U_id'] . "' style='margin: 0px;margin-top: 0px;text-align: left;'>
                                                        <div class='modal-dialog modal-dialog-centered' role='document'>
                                                            <div class='modal-content'>
                                                                <div class='modal-header' style='margin: 0px;'>
                                                                    <h4 class='modal-title' style='color: rgb(0,0,0);'>".$row['U_id'].":".$row['U_name']."</h4><button class='btn-close' type='button' aria-label='Close' data-bs-dismiss='modal'></button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <p style='color: rgb(0,0,0);'>Do you want to restore this user?</p>
                                                                </div>
                                                                <div class='modal-footer'>
                                                                    <button class='btn btn-light' type='button' data-bs-dismiss='modal'>Cancel</button>
                                                                    <a href='restoreuser.php?id=" . $fid . "&user=" . $row['U_id'] . "' class='btn btn-warning'  type='button'>Restore</a>
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
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
     <div class="modal fade" role="dialog" tabindex="-1" id="modal-new" style="margin: 0px;margin-top: 0px;text-align: left;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
            <div class="modal-content">
                <div class="modal-header" style="margin: 0px;">
                    <h4 class="modal-title" style="color: rgb(0,0,0);">New User</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="adduserprocess.php?id=<?php echo"$fid";?>">
                        <div class="container">
                            <label class="form-label" style="color: rgb(19,71,176,0.5);">Please note that the default password for a new user account is set to 'abc1234'.</label>
                            <div class="row"style="margin-top:10px">
                            <div class="col-md-6">
                                <div>
                                    <label class="form-label">User Type</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="usertypeAdmin" name="fusertype" value="Admin" required="" onclick="toggleSupervisorInput()">
                                    <label class="form-check-label" for="usertypeAdmin">Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="usertypeStaff" name="fusertype" value="Staff" required="" onclick="toggleSupervisorInput()">
                                    <label class="form-check-label" for="usertypeStaff">Staff</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" required="" name="fname">
                                </div>
                            </div>
                        </div>

                                <div class="row" style="margin-top:10px">
                                <div class="col-md-6">
                                    <div></div><label class="form-label">Supervisor</label>
                                    <div id="supervisorInputContainer"></div>
                                </div>
                                <div class="col-md-6">
                                    <div></div><label class="form-label">Position</label><input class="form-control" type="text" required="" name="fposition">
                                </div>
                            </div>
                                <div class="row"style="margin-top:10px">
                                <div class="col-md-6">
                                    <div></div><label class="form-label">Email</label><input class="form-control" type="email" required="" name="femail">
                                    <br>
                                </div>
                        </div>
                            <div class="modal-footer"><button class="btn btn-light" type="reset" data-bs-dismiss="modal">Reset</button><button class="btn btn-primary" type="submit">Create</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
   $(document).ready(function() {
    $('#dataTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        responsive: true
       });
    });
   $(document).ready(function() {
    $('#dataTable2').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        responsive: true
       });
    });

</script>
<script>
function toggleSupervisorInput() {
    var userType = document.querySelector('input[name="fusertype"]:checked').value;
    var supervisorInputContainer = document.getElementById('supervisorInputContainer');

   if (userType === 'Staff') {
    supervisorInputContainer.innerHTML = '<select class="form-select" name="fsupervisor" required>'
                                        + '<option value="" disabled selected>Select Supervisor</option>'
                                         +'<?php echo" $adminOptions "?>'+ '</select>';
}
else {
        supervisorInputContainer.innerHTML = '<input class="form-control" type="text" required="" name="fsupervisor" disabled>';
    }
}
</script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/Sidebar-Menu-sidebar.js"></script>
    <script src="assets/js/theme.js"></script>
    

</body>
