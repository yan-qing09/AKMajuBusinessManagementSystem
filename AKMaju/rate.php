<?php
include ('dbconnect.php');
include ('mysession.php');

$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);
$sql = "SELECT Z_state, Z_region,  
               GROUP_CONCAT(CASE WHEN Z_distance = 'A' THEN Z_perc END) AS A,
               GROUP_CONCAT(CASE WHEN Z_distance= 'B' THEN Z_perc END) AS B,
               GROUP_CONCAT(CASE WHEN Z_distance = 'C' THEN Z_perc END) AS C,
               GROUP_CONCAT(CASE WHEN Z_distance = 'D' THEN Z_perc END) AS D,
               GROUP_CONCAT(CASE WHEN Z_distance = 'E' THEN Z_perc END) AS E
        FROM tb_zone ";

if (isset($_GET['showResultEK'])) {
    $sql .= "WHERE CM_ctgy = 1 ";
} elseif (isset($_GET['showResultAK'])) {
    $sql .= "WHERE CM_ctgy = 2 ";
}

$sql .= "GROUP BY Z_state, Z_region";

$result = $con->query($sql);

$sql2 = "SELECT AK_name, 
                   GROUP_CONCAT(CASE WHEN AK_region = 'A' THEN AK_price END) AS A,
                   GROUP_CONCAT(CASE WHEN AK_region = 'B' THEN AK_price END) AS B,
                   GROUP_CONCAT(CASE WHEN AK_region= 'C' THEN AK_price END) AS C,
                   GROUP_CONCAT(CASE WHEN AK_region = 'D' THEN AK_price END) AS D,
                   GROUP_CONCAT(CASE WHEN AK_region = 'E' THEN AK_price END) AS E,
                   GROUP_CONCAT(CASE WHEN AK_region = 'F' THEN AK_price END) AS F,
                   GROUP_CONCAT(CASE WHEN AK_region = 'S' THEN AK_price END) AS S
            FROM tb_rate
            ";

if (isset($_GET['showResultKB'])) {
    $sql2 .= "WHERE AK_ctgy = 'T' ";
} elseif (isset($_GET['showResultSL'])) {
    $sql2 .= "WHERE AK_ctgy = 'L' ";
}

$sql2 .= "GROUP BY AK_name";

$result2 = $con->query($sql2);

include('datableheader.php');
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>Construction Rate</title>
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
<h3 class="text-dark mb-0">Construction Rate</h3>
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
<h3 class="text-dark mb-4">Construction Rate Details</h3>
<p>
        <a href="#zoneCard" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Zone Rate</a>
        /
        <a href="#kadarCard" style="text-decoration: underline; color: #0366d6; font-weight: bold;">Order Rate</a>

    </p>

</div>
</div>
</div>
<div class="container-fluid">
    <div class="mb-3">
    
                </div>
        <div class="card shadow" id="zoneCard">
            <div class="card-header py-3" >
                <p class="text-primary m-0 fw-bold">Zone Rate</p>
            </div>
            <div class="card-body">
                   <div class="row">
        <form method="GET" class="col" onsubmit="clearFragment()">
            <input type='hidden' name='id' value='<?php echo $fid; ?>'>
            <button class="btn <?php echo isset($_GET['showResultAK']) ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="showResultAK">Kejuruteraan Awam</button>
<button class="btn <?php echo isset($_GET['showResultEK']) ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="showResultEK">Elektrik</button>


        </form>
        <div class="col-auto">
            <button class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fa fa-upload"></i>&nbsp;Import
            </button>
        </div>
    </div>
                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable23">
                        <thead>
                            <?php
if ($result->num_rows > 0) {
    echo '<tr><th>Negeri</th><th>Daerah</th><th>Kurang dari 15km</th><th>15 – 30km</th><th>30 - 50km</th><th>50 - 75km</th>';
    if (isset($_GET['showResultAK'])) {
        echo '<th>More than 75km</th>';
    }
    echo '</tr></thead><tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['Z_state'] . '</td>';
        echo '<td>' . $row['Z_region'] . '</td>';
        echo '<td>' . $row['A'] . '</td>';
        echo '<td>' . $row['B'] . '</td>';
        echo '<td>' . $row['C'] . '</td>';
        echo '<td>' . $row['D'] . '</td>';
        if (isset($_GET['showResultAK'])) {
            echo '<td>' . $row['E'] . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    if (isset($_GET['showResultEK'])) {
        echo "No results for Elektrik";
    } elseif (isset($_GET['showResultAK'])) {
        echo "No results for Kejuruteraan Awam";
    }
}
?>

       </div>
        </div>
          </div>
          <br>
          <div class="card shadow" id="kadarCard">
            <div class="card-header py-3" >
                <p class="text-primary m-0 fw-bold">Order Rate</p>
            </div>
            <div class="card-body">
                <div class="row">
        <form method="GET" class="col" onsubmit="clearFragment()">
            <input type='hidden' name='id' value='<?php echo $fid; ?>'>
            <button class="btn <?php echo isset($_GET['showResultKB']) ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="showResultKB"onclick="scrollToCard('card1')">Kadar Buruh</button>
<button class="btn <?php echo isset($_GET['showResultSL']) ? 'btn-success' : 'btn-secondary'; ?>" type="submit" name="showResultSL">Sewa Logi</button>
        </form>
        <div class="col-auto">
            <button class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#importModal2">
                <i class="fa fa-upload"></i>&nbsp;Import
            </button>
        </div>
    </div>
                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0 table-responsive table mt-2 order-column hover" id="dataTable24">
                        <thead>
                            <?php
                            echo '<tr><th>Nama</th>
                            <th style="text-align:center">P.Pinang, Kedah dan Perlis</th>
                            <th>Perak</th>
                            <th style="text-align:center">Selangor, Wilayah Persekutuan, Negeri Sembilan dan Melaka</th>
                            <th>Johor</th>
                            <th>Pahang</th>
                            <th style="text-align:center">Kelantan dan Terengganu</th>
                            <th>Sabah</th></tr></thead><tbody>';
while ($row = $result2->fetch_assoc()) {

echo '<tr>';
echo '<td>' . $row['AK_name'] . '</td>';
echo '<td style="text-align:center">' . $row['A'] . '</td>';
echo '<td>' . $row['B'] . '</td>';
echo '<td style="text-align:center">' . $row['C'] . '</td>';
echo '<td>' . $row['D'] . '</td>';
echo '<td>' . $row['E'] . '</td>';
echo '<td style="text-align:center">' . $row['F'] . '</td>';
echo '<td>' . $row['S'] . '</td>';
echo '</tr>';
}

?>
 </tbody>
</table>
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
<div class="modal fade" role="dialog" tabindex="-1" id="importModal" style="margin: 0px; margin-top: 0px; text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0, 0, 0);">Update Zone Rate</h4>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id='upload'  action='importzone.php?id=<?php echo $fid; ?>' method='post' enctype='multipart/form-data'>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="signature">Upload your file in csv</label><br>
                                <input type="hidden" name="id" value="<?php echo $fid; ?>">
                                <input type="file" name="file" id="file" class="input-large">

                            </div>
                        </div>
                        <br>
                        <p>Example data from JKR documents</p>
                        <img src="assets/img/jkrdata.png" style="width:500px">
                        <br>
                        <p>Data in your csv</p>
                        <img src="assets/img/csvdata.png" style="width:500px">
                        <p>Note: Last column is for category, 1 means Elektrik, 2 means Kejuruteraan Awam</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" tabindex="-1" id="importModal2" style="margin: 0px; margin-top: 0px; text-align: left;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
        <div class="modal-content">
            <div class="modal-header" style="margin: 0px;">
                <h4 class="modal-title" style="color: rgb(0, 0, 0);">Update Order Rate</h4>
                <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id='upload'  action='importrate.php?id=<?php echo $fid; ?>' method='post' enctype='multipart/form-data'>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="signature">Upload your file in csv</label><br>
                                <input type="hidden" name="id" value="<?php echo $fid; ?>">
                                <input type="file" name="file" id="file" class="input-large">
                                
                            </div>
                        </div>
                        <br>
                        <p>Example data from JKR documents</p>
                        <img src="assets/img/kadarburuh.png" style="width:500px">
                        <br>
                        <p>Data in your csv</p>
                        <img src="assets/img/csvdata2.png" style="width:500px">
                        <p>Note: Last column is for category, T means upah buruh, L means sewa logi</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    function clearFragment() {
        history.replaceState({}, document.title, window.location.pathname + window.location.search);
    }
</script>
<script>
   $(document).ready(function() {
    $('#dataTable23').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10
       });
    });
    $(document).ready(function() {
    $('#dataTable24').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10
       });
    });
</script>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="assets/js/Sidebar-Menu-sidebar.js"></script>
<script src="assets/js/theme.js"></script>
</body>
</html>