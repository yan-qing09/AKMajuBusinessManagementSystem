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

// Fetch data from the database to populate the dropdown
$queryMT = "SELECT T_Desc FROM tb_cm_type WHERE CM_ctgy = '2'"; 
$resultMT = $con->query($queryMT);

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
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-4">Edit Kejuteraan Awam Order</h3>
                    </div>   
                    <?php
                        echo "<div class='mb-3'>
                        <a href='EditCOrder.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Order Details</button></a>
                        <a href='EditCEOrdermaterial.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Electric Order Material</button></a>
                        <a href='EditKABuruh.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Kadar Awam</button></a>
                        <a href='save_CEditorder.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Order Summary</button></a>
                        </div>";
                    ?>
                    <div id="addOrderMaterialCard" class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Add Order Material</p>
                        </div>
                        <div class="card-body">
                            <?php
                                echo "<form method='get' onsubmit='return validateForm()' action='save_AKeditorder.php?id=".$rows['U_id']."&co_id=$co_id'>";
                            ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="AKtype"><strong>Material Type</strong></label>
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
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Mname"><strong>Material Name</strong></label>
                                            <select class="form-select" id="Mname" name="Mname">
                                                <!-- Options will be dynamically populated -->
                                            </select>
                                        </div><input type='hidden' name='co_id' value='<?php echo $co_id; ?>'><input type='hidden' name='id' value='<?php echo $fid; ?>'>
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
                                            <label class="form-label" for="Munit"><strong>Material Unit</strong></label>
                                            <span id="materialUnitLabel"></span>
                                            <input class="form-control" type="text" id="Munit" placeholder="Material Unit" name="Munit">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="Mprice"><strong>Material Price</strong></label><input class="form-control" type="text" id="Mprice" placeholder="Material Price" name="Mprice" disabled></div>
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
                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save Material</button></div>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Material Selected</p>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end align-items-center">
                                <form id="addOrderMaterialForm" action="#addOrderMaterialCard">
                                    <button class="btn btn-primary btn-sm" type="submit">Add Order Material</button>
                                </form>
                                <script>
                                    document.getElementById('addOrderMaterialForm').addEventListener('submit', function (event) {
                                        event.preventDefault();
                                        var addOrderMaterialCard = document.getElementById('addOrderMaterialCard');
                                        addOrderMaterialCard.scrollIntoView({ behavior: 'smooth' });
                                    });
                                </script>
                            </div>
                            <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTableNew">
                                    <thead>
                                        <tr>
                                            <th>Material ID</th>
                                            <th>Material Type</th>
                                            <th style="min-width:200px;">Material Name</th>
                                            <th>Material Variation</th>
                                            <th>Material Unit</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                            <th>Quantity</th>
                                            <th>Discount Percentage</th>
                                            <th>Discount Amount</th>
                                            <th>Tax Amount</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql6 = "SELECT co.*, cd.*, cmt.*
                                                 FROM tb_co_material AS co
                                                 INNER JOIN tb_construction_material AS cd 
                                                 ON co.CM_variation = cd.CM_variation
                                                 AND co.CM_id = cd.CM_id
                                                 AND co.CM_type = cd.CM_type
                                                 INNER JOIN tb_cm_type AS cmt 
                                                 ON co.CM_type = cmt.CM_type
                                                 WHERE co.O_id = '$co_id' AND cmt.CM_ctgy = '2'";
                                        $result6 = $con->query($sql6);

                                        // Check if there's any data
                                        if ($result6->num_rows > 0) {
                                            // Output data of each row
                                            while ($row6 = $result6->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row6["CM_id"] . "</td>"; 
                                                echo "<td>" . $row6["T_desc"] . "</td>"; 
                                                echo "<td>" . $row6["CM_name"] . "</td>"; 
                                                echo "<td>" . $row6["CM_variation"] . "</td>"; 
                                                echo "<td>" . $row6["COM_unit"] . " (" . $row6["CM_unit"] . ")</td>";
                                                echo "<td>RM" . $row6["CM_price"] . "</td>"; 
                                                echo "<td>RM" . $row6["COM_price"] . "</td>"; 
                                                echo "<td>" . $row6["COM_qty"] . "</td>"; 
                                                echo "<td>" . $row6["COM_discPct"] . "%</td>"; 
                                                echo "<td>RM" . $row6["COM_discAmt"] . "</td>"; 
                                                echo "<td>RM" . $row6["COM_taxAmt"] . "</td>"; 
                                                echo "<td><button class='btn btn-primary btn-sm editMaterial m-1' type='button' data-materialid='" . $row6["CM_id"] . "' data-materialvariation='" . $row6["CM_variation"] . "' data-materialtype='" . $row6["CM_type"] . "'><i class='fas fa-pen'></i></button></td>";
                                                echo "<td><button class='btn btn-danger btn-sm deleteMaterial m-1' type='button' data-materialid='" . $row6["CM_id"] . "' data-materialvariation='" . $row6["CM_variation"] . "' data-materialtype='" . $row6["CM_type"] . "'><i class='fas fa-trash-alt'></i></button></td>";
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
                        echo "<div class='mb-3'>
                        <a href='EditKABuruh.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>< Back</button></a>
                        <a href='save_CEditorder.php?id=" . $rows['U_id'] . "&co_id=" . $co_id . "'><button class='btn btn-primary btn-sm'>Order Summary ></button></a>
                        </div>";
                    ?>
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
                                        <label class="form-label">Material Unit</label>
                                        <input class="form-control" type="text" id="edit_Munit">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Material Name</label>
                                        <textarea class="form-control" type="text" id="edit_Mname"  disabled required style="height:100px;word-wrap: break-word;"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label">Material Variation</label>
                                        <input class="form-control" type="text" id="edit_Mvariation"  disabled required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Material Price</label>
                                        <input class="form-control" type="text" id="edit_Mprice" disabled>
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
                                        <input type='hidden' name='co_id' value='<?php echo $co_id; ?>'>
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
        $('#dataTableNew').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });
    });
    </script>
    <script>

document.getElementById('Mtype').addEventListener('change', function() {
    var selectedValue = this.value;
    var selectMname = document.getElementById('Mname');

    // Clear existing options
    selectMname.innerHTML = '';

    if (selectedValue !== '') {
        // Use fetch to retrieve data based on selected Mtype
        fetch('get_AKmnames.php?mt=' + selectedValue)
            .then(response => response.json())
            .then(data => {
                // Populate Mname select with retrieved options
                data.forEach(function(option) {
                    var optionElement = document.createElement('option');
                    optionElement.value = option.value;
                    optionElement.textContent = option.text;
                    selectMname.appendChild(optionElement);
                });
            })
            .catch(error => {
                console.error('Error fetching Mnames:', error);
            });
    }
});


document.getElementById('Mname').addEventListener('change', function() {
    var selectedMtype = document.getElementById('Mtype').value;
    var selectedMname = this.value;
    console.log(selectedMname);
    console.log(selectedMtype);

    fetch('fetch_CEmaterial_options.php?mt=' + selectedMtype + '&mn=' + selectedMname)
        .then(response => response.json())
        .then(data => {
            var selectMvariation = document.getElementById('Mvariation');
            var labelMunit = document.getElementById('MunitLabel');

            // Clear existing options
            selectMvariation.innerHTML = '';

            data.variation.forEach(function (variation) {
            $('#Mvariation').append($('<option>').text(variation).attr('value', variation));
            });

            // Set Material Unit label text
            $('#materialUnitLabel').text('(' + data.unit[0] + ')'); // Assuming you want to set the first unit from the response

            fetchMaterialPrice();
        })
        .catch(error => {
            console.error('Error fetching Mdetails:', error);
        });
});

function fetchMaterialPrice() {
    // Fetch the selected values
    const materialName = document.getElementById('Mname').value;
    const materialType = document.getElementById('Mtype').value;
    const materialVariation = document.getElementById('Mvariation').value;

    // Send these values to the server (PHP) using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_CEmaterial_price.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = xhr.responseText;
                // Split response into cost and price
                const price = response;

                document.getElementById('Mprice').value = price;
            } else {
                // Handle error
                console.error('No this material in database');
            }
        }
    };

    const data = {
        Mtype: materialType,
        Mname: materialName,
        Mvariation: materialVariation,
    };

    xhr.send(JSON.stringify(data));
}

// Function to handle the change event
function handleChange() {
    fetchMaterialPrice(); // Call the function to fetch material price
}

// Get references to the elements by their IDs
const mVariation = document.getElementById('Mvariation');

// Attach the event listener to each element
mVariation.addEventListener('change', handleChange);

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

$(document).ready(function() {
    $('.deleteMaterial').on('click', function() {
        var materialID = $(this).data('materialid');
        var materialVariation = $(this).data('materialvariation');
        var materialType = $(this).data('materialtype'); 

        // AJAX call to delete the material
        $.ajax({
            type: 'POST',
            url: 'delete_CEmaterial.php', // Change to your PHP file handling deletion
            data: {
                    material_id: materialID,
                    material_variation: materialVariation,
                    material_type: materialType
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

// Click event listener for the edit button
$(document).ready(function() {
    $('.editMaterial').on('click', function() {
        var materialID = $(this).data('materialid'); // Get the material ID from the button
        var materialVariation = $(this).data('materialvariation'); // Get the material ID from the button
        var co_id = '<?php echo $co_id; ?>'; // Add single quotes to treat it as a string
        var materialType = $(this).data('materialtype'); // Get the material ID from the button
        console.log('Material ID:', materialID); // Log the material ID to the console
        console.log('Material Variation:', materialVariation); // Log the material ID to the console
        console.log('Material Type:', materialType); // Log the material ID to the console
        console.log('CO ID:', co_id); // Log the material ID to the console
        $('#edit_material_id').val(materialID);
        $('#edit_Mvariation').val(materialVariation);
        $('#edit_Mtype').val(materialType);

        // AJAX call to fetch material details for editing
        $.ajax({
            type: 'POST',
            url: 'get_CEmaterial_details.php', // Change to your PHP file to retrieve material details
            data: {
                    material_id: materialID,
                    material_variation: materialVariation,
                    material_type: materialType,
                    co_id: co_id
                  },
            success: function(response) {
                // Populate the modal with the retrieved material details
                var material = JSON.parse(response); // Parse the JSON response

                $('#edit_Mname').val(material.CM_name);
                $('#edit_Mvariation').val(material.CM_variation);
                $('#edit_Munit').val(material.COM_unit);
                $('#edit_Mprice').val(material.CM_price);
                $('#edit_Mquantity').val(material.COM_qty);
                $('#edit_MdiscountPerc').val(material.COM_discPct);
                $('#edit_MdiscountAmt').val(material.COM_discAmt);
                $('#edit_taxcode').val(material.COM_taxCode);
                $('#edit_taxamount').val(material.COM_taxAmt);

                // Show the modal for editing
                $('#editMaterialModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle error - show an error message or log the error
                console.error(error);
            }
        });
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
            co_id: '<?php echo $co_id; ?>', // Add single quotes to treat it as a string
            materialID: $('#edit_material_id').val(),
            materialVariation: $('#edit_Mvariation').val(),
            materialType: $('#edit_Mtype').val(),
            Munit: $('#edit_Munit').val(),
            Mprice: $('#edit_Mprice').val(),
            Mquantity: $('#edit_Mquantity').val(),
            MdiscountPerc: $('#edit_MdiscountPerc').val(),
            MdiscountAmt: $('#edit_MdiscountAmt').val(),
            taxcode: $('#edit_taxcode').val(),
            taxamount: $('#edit_taxamount').val()
        };

        // Log the editedMaterial object to the console
        console.log('Edited Material:', editedMaterial);

        // AJAX call to save the edited data
        $.ajax({
            type: 'POST',
            url: 'save_CEedited_material.php', // Replace with your PHP file to handle saving
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

function validateForm() {
    // Get values from input fields
    var materialType = document.getElementById('Mtype').value;
    var materialName = document.getElementById('Mname').value;
    var materialVariation = document.getElementById('Mvariation').value;
    var materialUnit = document.getElementById('Munit').value;
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
            !materialUnit ||
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
        !materialUnit ||
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
</body>

</html>