<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$o_id = $_GET['o_id'];

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
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-4">Add Order</h3>
                    </div> 
                    <div id="addOrderMaterialCard" class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Add Order Material</p>
                        </div>
                        <div class="card-body">
                            <?php
                                echo "<form method='post' onsubmit='return validateForm()' action='save_Aaddorder.php?id=".$rows['U_id']."&o_id=$o_id'>";
                            ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Mtype"><strong>Material Type</strong></label>
                                            <?php
                                            // Fetch data from the database to populate the dropdown
                                                $query4 = "SELECT T_Desc FROM tb_am_type"; 
                                                $result4 = $con->query($query4);

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
                                        <div class="mb-3"><label class="form-label" for="Mprice"><strong>Material Price</strong></label><input class="form-control" type="text" id="Mprice" placeholder="Material Price" name="Mprice"></div><input type='hidden' name='id' value='<?php echo $fid; ?>'>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="Mquantity"><strong>Quantity</strong></label><input class="form-control" type="text" id="Mquantity" placeholder="Quantity" name="Mquantity"></div><input type='hidden' name='o_id' value='<?php echo $o_id; ?>'>
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
                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Save Order Material</button></div>
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
                                            <th>Tax Amount</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql6 = "SELECT ao.*, ad.*, amt.*
                                                 FROM tb_ao_material AS ao
                                                 INNER JOIN tb_advertisement_material AS ad 
                                                 ON ao.AM_id = ad.AM_id
                                                 INNER JOIN tb_am_type AS amt 
                                                 ON ad.AM_type = amt.AM_type
                                                 WHERE ao.O_id = '$o_id'";
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
                                                echo "<td>" . $row6["AOM_unit"] . " (" . $row6["AM_unit"] . ")</td>";
                                                echo "<td>RM" . $row6["AOM_adjustprice"] . "</td>"; 
                                                echo "<td>RM" . $row6["AOM_origincost"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_qty"] . "</td>"; 
                                                echo "<td>" . $row6["AOM_discPct"] . "%</td>"; 
                                                echo "<td>RM" . $row6["AOM_discAmt"] . "</td>"; 
                                                echo "<td>RM" . $row6["AOM_taxAmt"] . "</td>"; 
                                                echo "<td><button class='btn btn-primary btn-sm editMaterial m-1' type='button' data-materialid='" . $row6["AM_id"] . "'><i class='fas fa-pen'></i></button></td>";
                                                echo "<td><button class='btn btn-danger btn-sm deleteMaterial m-1' type='button' data-materialid='" . $row6["AM_id"] . "'><i class='fas fa-trash-alt'></i></button></td>";
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
                        <a href='save_order.php?id=" . $rows['U_id'] . "&o_id=" . $o_id . "'><button class='btn btn-primary btn-sm'>Order Summary ></button></a>
                        </div>";
                    ?>
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
                                        <div class="col-md-12">
                                            <label class="form-label">Material Name</label>
                                            <input class="form-control" type="text" id="edit_Mname"  disabled required style="height:100px;word-wrap: break-word;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Material Variation</label>
                                            <input class="form-control" type="text" id="edit_Mvariation"  disabled required>
                                            <input type="hidden" id="edit_material_id" value="">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Material Dimension</label>
                                            <input class="form-control" type="text" id="edit_Mdimension"  disabled required>
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
                                            <input class="form-control" type="text" id="edit_Mcost" disabled>
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
                                            <input type='hidden' name='o_id' value='<?php echo $o_id; ?>'>
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
            </div>
        </div>
    </div>
</body>

    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(function () {
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
                }
            });
        },
        minLength: 1,
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
                    $('#materialUnitLabel').text('(' + data.unit[0] + ')'); // Assuming you want to set the first unit from the response

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



$(function () {
    // Use jQuery UI Autocomplete
    $("#Mtype").autocomplete({
        source: function (request, response) {
            // Use an AJAX request to fetch suggestions from the server
            $.ajax({
                url: "autocomplete_type.php", // Replace with the actual PHP script to fetch suggestions for material type
                method: "POST",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 1 // Minimum characters before triggering autocomplete
    });
});

    // Function to fetch material price
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

$(document).ready(function() {
    $('.deleteMaterial').on('click', function() {
        var materialID = $(this).data('materialid');

        // AJAX call to delete the material
        $.ajax({
            type: 'POST',
            url: 'delete_Amaterial.php', // Change to your PHP file handling deletion
            data: {
                    material_id: materialID,
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
        var o_id = '<?php echo $o_id; ?>'; // Add single quotes to treat it as a string
        $('#edit_material_id').val(materialID);
        console.log(materialID);
        console.log(o_id);

        // AJAX call to fetch material details for editing
        $.ajax({
            type: 'POST',
            url: 'get_Amaterial_details.php', // Change to your PHP file to retrieve material details
            data: {
                    material_id: materialID,
                    o_id: o_id
                  },
            success: function(response) {
                // Populate the modal with the retrieved material details
                var material = JSON.parse(response); // Parse the JSON response
                console.log("here?");
                $('#edit_Mtype').val(material.AM_type);
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
    var editedMaterialType = document.getElementById('edit_Mtype').value;
    var editedMaterialName = document.getElementById('edit_Mname').value;
    var editedMaterialVariation = document.getElementById('edit_Mvariation').value;
    var editedMaterialDimension = document.getElementById('edit_Mdimension').value;
    var editedMaterialUnit = document.getElementById('edit_Munit').value;
    var editedMaterialPrice = document.getElementById('edit_Mprice').value;
    var editedMaterialCost = document.getElementById('edit_Mcost').value;
    var editedQuantity = document.getElementById('edit_Mquantity').value;

    // Retrieve additional values from modal inputs
    var discountType = document.getElementById('Dtype1').value;
    var editedDiscountPerc = document.getElementById('edit_MdiscountPerc').value;
    var editedDiscountAmt = document.getElementById('edit_MdiscountAmt').value;
    var editedTaxCode = document.getElementById('edit_taxcode').value;
    var editedTaxAmount = document.getElementById('edit_taxamount').value;

 // Validation for non-empty fields
        if (
            editedMaterialType.trim() === '' ||
            editedMaterialName.trim() === '' ||
            editedMaterialVariation.trim() === '' ||
            editedMaterialDimension.trim() === '' ||
            editedMaterialUnit.trim() === '' ||
            editedMaterialPrice.trim() === '' ||
            editedMaterialCost.trim() === '' ||
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
        !validateNumericInput(editedMaterialCost, 'Cost') ||
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
            o_id: '<?php echo $o_id; ?>', // Add single quotes to treat it as a string
            materialID: $('#edit_material_id').val(),
            Munit: $('#edit_Munit').val(),
            Mprice: $('#edit_Mprice').val(),
            Mcost: $('#edit_Mcost').val(),
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
            url: 'save_Aedited_material.php', // Replace with your PHP file to handle saving
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
        $('#dataTableNew').DataTable({
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 10, // Initial page length
            "order": [[0, 'desc']] // Assuming 'C_id' is the second column (index 1)
        });
    });
</script>

<?php 

// ... Close other statements
$con->close();
?>