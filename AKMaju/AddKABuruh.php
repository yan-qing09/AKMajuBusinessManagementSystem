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

$sql5 = "SELECT * FROM tb_construction_order WHERE O_id = '$co_id'";
$result6 = mysqli_query($con, $sql5);
$row6=mysqli_fetch_array($result6);

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
                    <?php
                        echo "<form method='get' onsubmit='return validateForm()' action='save_Buruh.php?id=".$rows['U_id']."&co_id=$co_id'>"
                    ?>
                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-dark mb-4">Add Kadar Awam</h3>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Kadar Upah Buruh</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Tukang">
                                                <strong>Tukang</strong>
                                            </label>
                                            <?php
                                                $queryTukang = "SELECT DISTINCT AK_name FROM tb_rate WHERE AK_ctgy = 'T'"; 
                                                $resultTukang = $con->query($queryTukang);

                                                if($resultTukang && $resultTukang->num_rows > 0) {
                                                    echo '<select class="form-select" id="Tukang" name="Tukang">';
                                                    while($rowTukang = $resultTukang->fetch_assoc()) {
                                                        $TukangDesc = $rowTukang['AK_name'];
                                                        echo "<option value='$TukangDesc'>$TukangDesc</option>";
                                                    }
                                                    echo '</select>';
                                                } else {
                                                    echo '<select class="form-select" id="Tukang" name="Tukang">';
                                                    echo '<option value="">No options available</option>';
                                                    echo '</select>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="BUnit">
                                                <strong>Unit (day)</strong>
                                            </label>
                                            <input class="form-control" type="text" id="BUnit" placeholder="0" name="BUnit">
                                            <input type='hidden' name='co_id' value='<?php echo $co_id; ?>'><input type='hidden' name='id' value='<?php echo $fid; ?>'>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="BKawasan">
                                                <strong>Kawasan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="BKawasan" name="BKawasan">
                                                <option value="A" selected="">A - Pulau Pinang, Kedah dan Perlis</option>
                                                <option value="B">B - Perak</option>
                                                <option value="C">C - Selangor, Wilayah Persekutuan, Negeri Sembilan dan Melaka</option>
                                                <option value="D">D - Johor</option>
                                                <option value="E">E - Pahang</option>
                                                <option value="F">F - Kelantan dan Terengganu</option>
                                                <option value="S">S - Sabah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="BHarga">
                                                <strong>Harga (RM)</strong>
                                            </label>
                                            <input class="form-control" type="text" id="BHarga" placeholder="0" name="BHarga" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" id="saveBuruh" type="submit" onclick="validateForm(event)">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>  
                    <?php
                        echo "<form method='get' onsubmit='return validateForm()' action='save_Logi.php?id=".$rows['U_id']."&co_id=$co_id'>"
                    ?>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Kadar Sewa Logi</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Logi">
                                                <strong>Logi</strong>
                                            </label>
                                            <?php
                                                $queryLogi = "SELECT DISTINCT AK_name FROM tb_rate WHERE AK_ctgy = 'L'"; 
                                                $resultLogi = $con->query($queryLogi);

                                                if($resultLogi && $resultLogi->num_rows > 0) {
                                                    echo '<select class="form-select" id="Logi" name="Logi">';
                                                    while($rowLogi = $resultLogi->fetch_assoc()) {
                                                        $LogiDesc = $rowLogi['AK_name'];
                                                        echo "<option value='$LogiDesc'>$LogiDesc</option>";
                                                    }
                                                    echo '</select>';
                                                } else {
                                                    echo '<select class="form-select" id="Logi" name="Logi">';
                                                    echo '<option value="">No options available</option>';
                                                    echo '</select>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="LUnit">
                                                <strong>Unit (day)</strong>
                                            </label>
                                            <input class="form-control" type="text" id="LUnit" placeholder="0" name="LUnit">
                                            <input type='hidden' name='co_id' value='<?php echo $co_id; ?>'><input type='hidden' name='id' value='<?php echo $fid; ?>'>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="LKawasan">
                                                <strong>Kawasan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="LKawasan" name="LKawasan">
                                                <option value="A" selected="">A - Pulau Pinang, Kedah dan Perlis</option>
                                                <option value="B">B - Perak</option>
                                                <option value="C">C - Selangor, Wilayah Persekutuan, Negeri Sembilan dan Melaka</option>
                                                <option value="D">D - Johor</option>
                                                <option value="E">E - Pahang</option>
                                                <option value="F">F - Kelantan dan Terengganu</option>
                                                <option value="S">S - Sabah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="LHarga">
                                                <strong>Harga (RM)</strong>
                                            </label>
                                            <input class="form-control" type="text" id="LHarga" placeholder="0" name="LHarga" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" id="saveLogi" type="submit" onclick="validateForm(event)">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Upah Buruh / Sewa Logi</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTableNew">
                                    <thead>
                                        <tr>
                                            <th>Tukang / Logi</th>
                                            <th>Unit</th>
                                            <th>Kawasan</th>
                                            <th>Harga</th>
                                            <th>Jumlah Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql6 = "SELECT * FROM tb_order_rate
                                                 JOIN tb_rate ON tb_order_rate.AK_name = tb_rate.AK_name
                                                              AND tb_order_rate.AK_ctgy = tb_rate.AK_ctgy
                                                              AND tb_order_rate.AK_region = tb_rate.AK_region
                                                 WHERE tb_order_rate.O_id = '$co_id'";
                                        $result6 = $con->query($sql6);

                                        // Check if there's any data
                                        if ($result6->num_rows > 0) {
                                            // Output data of each row
                                            while ($row6 = $result6->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row6["AK_name"] . "</td>"; 
                                                echo "<td>" . $row6["AKR_unit"] ." ". $row6["AK_unit"] . "</td>";
                                                echo "<td>" . $row6["AK_region"] . "</td>"; 
                                                echo "<td>RM" . $row6["AK_price"] . "</td>"; 
                                                echo "<td>RM" . $row6["AKR_unit"] * $row6["AK_price"] . "</td>";
                                                echo "<td><button class='btn btn-danger btn-sm deleteMaterial m-1' type='button' data-coid='" . $row6["O_id"] . "' data-akname='" . $row6["AK_name"] . "' data-akregion='" . $row6["AK_region"] . "' data-akctgy='" . $row6["AK_ctgy"] . "'><i class='fas fa-trash-alt'></i></button></td>";
                                                echo "</tr>";

                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                        echo "<div class='mb-3'><a href='AddKAOrdermaterial.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Add Kejuteraan Order Material ></button></a></div>";
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

<script>
function updateHarga() {
    var selectedTukang = $("#Tukang").val();
    var selectedKawasan = $("#BKawasan").val();

    // AJAX request to fetch the harga based on Tukang and Kawasan
    $.ajax({
        type: "POST",
        url: "getHarga.php", // Replace with the actual URL that fetches harga
        data: {
            Tukang: selectedTukang,
            Kawasan: selectedKawasan
        },
        success: function(response) {
            // Update the BHarga input field with the fetched harga
            $("#BHarga").val(response);
        },
        error: function() {
            alert("Error fetching harga.");
        }
    });
}

$(document).ready(function() {
    // When Tukang changes
    $("#Tukang").change(function() {
        updateHarga();
    });

    // When BKawasan changes
    $("#BKawasan").change(function() {
        updateHarga();
    });
});

function updateHarga2() {
    var selectedLogi = $("#Logi").val();
    var selectedKawasan = $("#LKawasan").val();

    // AJAX request to fetch the harga based on Tukang and Kawasan
    $.ajax({
        type: "POST",
        url: "getLHarga.php", // Replace with the actual URL that fetches harga
        data: {
            Logi: selectedLogi,
            Kawasan: selectedKawasan
        },
        success: function(response) {
            // Update the BHarga input field with the fetched harga
            $("#LHarga").val(response);
        },
        error: function() {
            alert("Error fetching harga.");
        }
    });
}

$(document).ready(function() {
    // When Tukang changes
    $("#Logi").change(function() {
        updateHarga2();
    });

    // When BKawasan changes
    $("#LKawasan").change(function() {
        updateHarga2();
    });
});

$(document).ready(function() {
    $('.deleteMaterial').on('click', function() {
        var coid = $(this).data('coid');
        var akname = $(this).data('akname');
        var akregion = $(this).data('akregion');
        var akctgy = $(this).data('akctgy');
        console.log(coid);
        console.log(akname);
        console.log(akregion);
        console.log(akctgy);

        // AJAX call to delete the material
        $.ajax({
            type: 'POST',
            url: 'delete_ABuruh.php', // Change to your PHP file handling deletion
            data: {
                    CO_id: coid,
                    AK_name: akname,
                    AK_region: akregion,
                    AK_ctgy: akctgy
                  },
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