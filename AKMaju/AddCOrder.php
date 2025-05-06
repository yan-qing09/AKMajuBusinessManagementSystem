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


$fid = $_GET['id'];
$sqls="SELECT *FROM tb_user
        WHERE U_id='$fid'";
$result3 = mysqli_query($con,$sqls);
$rows=mysqli_fetch_array($result3);

?>

<body id="page-top">
    <div id="wrapper">
        <?php include ('navbar.php');?>
         <?php include ('COrderheader.php');?>
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
                        echo "<form method='post' action='save_Corder.php?id=".$rows['U_id']."'>"
                    ?>
                        <div class="d-sm-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-dark mb-4">Add Order</h3>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Customer Information</p>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-end mb-3">
                                <!-- Move the button to the right -->
                                    <button type="button" class="btn btn-primary choosecust" style="width:200px;margin-right: 20px;">Choose exist customer</button>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cname">
                                                <strong>Customer Name</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cname" placeholder="Name" name="Cname"><input type="hidden" id="Cid" name="Cid">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Ctype">
                                                <strong>Customer Type</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="Ctype" name="Ctype">
                                                <option value="1" selected="">Personnel</option>
                                                <option value="2">Government</option>
                                                <option value="3">Agency</option>
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
                                            <input class="form-control" type="text" id="Cemail" placeholder="123@gmail.com" name="Cemail">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cphone">
                                                <strong>Customer phone</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cphone" placeholder="0123456789" name="Cphone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cstreet">
                                                <strong>Street</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cstreet" placeholder="Street Details" name="Cstreet">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Ccity">
                                                <strong>City</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Ccity" placeholder="City Details" name="Ccity">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cpostcode">
                                                <strong>Postcode</strong>
                                            </label>
                                            <input class="form-control" type="number" id="Cpostcode" placeholder="Postcode Details" name="Cpostcode">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="Cstate">
                                                <strong>State</strong>
                                            </label>
                                            <input class="form-control" type="text" id="Cstate" placeholder="State Details" name="Cstate">
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
                                                <input class="form-control" type="text" id="governmentName" placeholder="Government Name" name="governmentName">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="governmentPhone">
                                                    <strong>Government Phone</strong>
                                                </label>
                                                <input class="form-control" type="text" id="governmentPhone" placeholder="Government Phone" name="governmentPhone">
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
                                                <input class="form-control" type="text" id="Aname" placeholder="Agency Name" name="Aname">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="Aphone">
                                                    <strong>Agency Phone</strong>
                                                </label>
                                                <input class="form-control" type="Phone" id="Aphone" placeholder="Agency Phone" name="Aphone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="modal fade" role="dialog" tabindex="-1" id="choosecustModal" style="margin: 0px; margin-top: 0px; text-align: left;">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-lg-down" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="margin: 0px;">
                            <h4 class="modal-title" style="color: rgb(0, 0, 0);">Choose which customer</h4>
                            <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="tableCust">
                                <thead>
                                    <tr>
                                        <th>Customer id</th>
                                        <th>Customer name</th>
                                        <th>Customer type</th>
                                        <th>Agency/Government name</th>
                                        <th>Agency/Government phone</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <?php
                                // Assuming you have a database connection established already

                                // Query to retrieve data from tb_customer and tb_agency_government
                                $query = "SELECT c.C_id, c.C_name, c.C_type, a.AG_name, ag.AG_phone
                                          FROM tb_customer c
                                          LEFT JOIN tb_agency_government a ON c.C_id = a.C_id
                                          LEFT JOIN tb_ag_phone ag ON c.C_id = ag.C_id
                                          ORDER BY c.C_id DESC";

                                $result = $con->query($query);

                                if ($result && $result->num_rows > 0) {
                                    echo '<tbody>';
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row['C_id'] . '</td>';
                                        echo '<td>' . $row['C_name'] . '</td>';
                                        echo '<td>';
                                        switch ($row['C_type']) {
                                            case 1:
                                                echo 'Personnel';
                                                break;
                                            case 2:
                                                echo 'Government';
                                                break;
                                            case 3:
                                                echo 'Agency';
                                                break;
                                            default:
                                                echo 'Unknown';
                                        }
                                        echo '</td>';
                                        echo '<td>' . $row['AG_name'] . '</td>';
                                        echo '<td>' . $row['AG_phone'] . '</td>';
                                        echo '<td><input type="radio" name="selectedCustomer" value="' . $row['C_id'] . '"></td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                } else {
                                    echo '<tbody>';
                                    echo '<tr>';
                                    echo '<td colspan="6">No data available</td>';
                                    echo '</tr>';
                                    echo '</tbody>';
                                }
                                ?>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="button" id="savecust">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Order Details</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="COdate"><strong>Order Date</strong></label><input class="form-control" type="date" id="COdate" placeholder="date" name="COdate"></div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="COremark"><strong>Order Remark</strong></label><input class="form-control" type="text" id="COremark" placeholder="Sign Board to AKMaju" name="COremark"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3"><label class="form-label" for="TOP"><strong>Term of Payment</strong></label>
                                            <?php
                                                $queryMT = "SELECT * FROM tb_terms_of_payment"; 
                                                $resultMT = $con->query($queryMT);

                                                if($resultMT && $resultMT->num_rows > 0) {
                                                    echo '<select class="form-select" id="TOP" name="TOP">';
                                                    while($rowMT = $resultMT->fetch_assoc()) {
                                                        $MTDesc = $rowMT['TOP_name'];
                                                        $MTvalue = $rowMT['TOP_desc'];
                                                        echo "<option value='$MTDesc'>$MTvalue</option>";
                                                    }
                                                    echo '</select>';
                                                } else {
                                                    echo '<select class="form-select" id="TOP" name="TOP">';
                                                    echo '<option value="">No options available</option>';
                                                    echo '</select>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Electric Information</p>
                            </div>
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

                                                if($resultNegeri && $resultNegeri->num_rows > 0) {
                                                    echo '<select class="form-select" id="EKnegeri" name="EKnegeri">';
                                                    while($rowNegeri = $resultNegeri->fetch_assoc()) {
                                                        $NegeriDesc = $rowNegeri['Z_state'];
                                                        echo "<option value='$NegeriDesc'>$NegeriDesc</option>";
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
                                                <option value="A" selected>A: kurang dari 16km</option>
                                                <option value="B">B: 16-32km</option>
                                                <option value="C">C: 32-48km</option>
                                                <option value="D">D: lebih dari 48km</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="EKtambahan">
                                                <strong>Tambahan Peratusan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="EKtambahan" name="EKtambahan">
                                                <option value="1">Tiada</option>
                                                <option value="2">Jalan ke tempat kerja hanya boleh dilalui oleh kenderaan darat berjentera beroda dua atau kenderaan berjentera yang mempunyai pacuan empat roda</option>
                                                <option value="3">Jalan ke tempat kerja hanya boleh dilalui menggunakan kenderaan air dengan mengharungi sungai, tasik atau laut, tanpa jambatan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">Kejuteraan Awam Information</p>
                            </div>
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

                                                if($resultAKNegeri && $resultAKNegeri->num_rows > 0) {
                                                    echo '<select class="form-select" id="AKnegeri" name="AKnegeri">';
                                                    while($rowAKNegeri = $resultAKNegeri->fetch_assoc()) {
                                                        $NegeriAKDesc = $rowAKNegeri['Z_state'];
                                                        echo "<option value='$NegeriAKDesc'>$NegeriAKDesc</option>";
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
                                                <option value="A" selected>A: kurang dari 16km</option>
                                                <option value="B">B: 16-32km</option>
                                                <option value="C">C: 32-48km</option>
                                                <option value="D">D: lebih dari 48km</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="AKtambahan">
                                                <strong>Tambahan Peratusan</strong>
                                            </label>
                                            <select class="d-inline-block form-select form-select-sm" id="AKtambahan" name="AKtambahan">
                                                <option value="1">Tiada</option>
                                                <option value="2">Jalan ke tempat kerja hanya boleh dilalui oleh kenderaan darat berjentera beroda dua atau kenderaan berjentera yang mempunyai pacuan empat roda</option>
                                                <option value="3">Jalan ke tempat kerja tidak boleh dilalui oleh kenderaan berjentera</option>
                                                <option value="4">Jalan ke tempat kerja tidak boleh dihalang oleh sungai tanpa jambatan ataupun laut</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" id="saveOrder" type="submit" onclick="validateForm(event)">Add Electric Order Material ></button>
                        </div>
                    </form>
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
    $('.choosecust').on('click', function() {
        // Show the modal for choosing a customer
        $('#choosecustModal').modal('show');
    });

    // Handle "Save Changes" button click in the modal
    $('#savecust').on('click', function() {
        // Get the selected customer's ID
        var selectedCid = $('input[name="selectedCustomer"]:checked').val();
        console.log(selectedCid);

        // AJAX request to fetch customer details using the selectedCid
        $.ajax({
            url: 'get_customer_details.php', // Replace with the actual PHP file to handle AJAX request
            type: 'POST',
            data: {cid: selectedCid},
            success: function(response) {
                // Parse the JSON response
                console.log("success?");
                console.log(response);
                var customerDetails = JSON.parse(response);

                // Update the input fields in the "Add Customer" card with the fetched details
                $('#Cid').val(customerDetails.C_id);
                $('#Cname').val(customerDetails.C_name);
                $('#Ctype').val(customerDetails.C_type);
                $('#Cemail').val(customerDetails.C_email);
                $('#Cphone').val(customerDetails.C_phone);
                $('#Cstreet').val(customerDetails.C_street);
                $('#Ccity').val(customerDetails.C_city);
                $('#Cpostcode').val(customerDetails.C_postcode);
                $('#Cstate').val(customerDetails.C_state);

                // Display/hide additional fields based on the customer type
                if (customerDetails.C_type == 2) {
                    $('#governmentFields').show();
                    $('#governmentName').val(customerDetails.AG_name);
                    $('#governmentPhone').val(customerDetails.AG_phone);
                    $('#agencyFields').hide();
                } else if (customerDetails.C_type == 3) {
                    $('#agencyFields').show();
                    $('#Aname').val(customerDetails.AG_name);
                    $('#Aphone').val(customerDetails.AG_phone);
                    $('#governmentFields').hide();
                } else {
                    $('#governmentFields').hide();
                    $('#agencyFields').hide();
                }

                // Hide the modal after updating the fields
                $('#choosecustModal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error fetching customer details:', status, error);
            }
        });
    });
});
</script>

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
const inputFields = document.querySelectorAll('#Cname, #Ctype, #Cemail, #Cphone, #Cstreet, #Ccity, #Cpostcode, #Cstate, #governmentName, #governmentPhone, #Aname, #Aphone, #COdate, #COremark, #TOP, #AKdaerah, #EKdaerah');
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
const numericalFields = ['Cphone','governmentPhone','Aphone'];

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