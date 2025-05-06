var materialsArray = []; // Initialize or populate materialsArray with necessary data
var materialsData;

function validateNumericInput(value, fieldName) {
    if (value.trim() === '') {
        alert(`${fieldName} should not be empty.`);
        return false;
    }

    if (isNaN(parseFloat(value))) {
        alert(`${fieldName} should be a valid number.`);
        return false;
    }
    
    return true;
}

    document.getElementById('Ctype').addEventListener('change', function() {
    var governmentFields = document.getElementById('governmentFields');
    var agencyFields = document.getElementById('agencyFields');

    if (this.value === '2') {
        governmentFields.style.display = 'block';
        agencyFields.style.display = 'none';
    } else if (this.value === '3') {
        governmentFields.style.display = 'none';
        agencyFields.style.display = 'block';
    } else {
        governmentFields.style.display = 'none';
        agencyFields.style.display = 'none';
    }
});

    document.getElementById('saveMaterial').addEventListener('click', function() {
        var materialType = document.getElementById('Mtype').value;
        var materialName = document.getElementById('Mname').value;
        var materialVariation = document.getElementById('Mvariation').value;
        var materialDimension = document.getElementById('Mdimension').value;
        var materialUnit = document.getElementById('Munit').value;
        var materialCost = document.getElementById('Mcost').value;
        var materialPrice = document.getElementById('Mprice').value;
        var discountPct = document.getElementById('MdiscountPerc').value;
        var discountAmt = document.getElementById('MdiscountAmt').value;
        var taxCode = document.getElementById('taxcode').value;
        var taxAmt = document.getElementById('taxamount').value;

        // Validation for numeric input
        if (
            !validateNumericInput(quantity, 'Quantity') ||
            !validateNumericInput(materialCost, 'Cost') ||
            !validateNumericInput(materialPrice, 'Price')
        ) {
            return;
        }

        // Validation for whole number input
        if (
            isNaN(parseFloat(quantity)) || // Check if quantity is not a number
            !Number.isInteger(parseFloat(quantity)) // Check if quantity is not an integer
        ) {
            alert('Quantity should be a whole number.');
            return; // Prevent further execution if quantity is not a whole number
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
        !quantity
        ) {
            alert('Please fill in all required fields.');
            return; // Prevent further execution if fields are empty
        }

        // Add the material data to an array or object to store all the materials
            var materialObject = {
                Mtype: materialType,
                Mname: materialName,
                Mvariation: materialVariation,
                Mdimension: materialDimension,
                Munit: materialUnit,
                Mcost: materialCost,
                Mprice: materialPrice,
                Mquantity: quantity
            };

            materialsArray.push(materialObject); // Add this material to the array
            materialsData = JSON.stringify(materialsArray);

            // Set the JSON string as the value of the materialsData input field
            document.getElementById('materialsData').value = materialsData;

        var table = document.getElementById('dataTableNew');
        var newRow = table.insertRow(-1);
        var cells = [];

        for (var i = 0; i < 10; i++) {
            cells[i] = newRow.insertCell(i);
        }

        cells[0].innerHTML = materialType;
        cells[1].innerHTML = materialName;
        cells[2].innerHTML = materialVariation;
        cells[3].innerHTML = materialDimension;
        cells[4].innerHTML = materialUnit;
        cells[5].innerHTML = materialPrice;
        cells[6].innerHTML = materialCost;
        cells[7].innerHTML = quantity;
        cells[8].innerHTML = '<button class="btn btn-primary btn-sm editMaterial m-1" type="button" id="editMaterial"><i class="fas fa-pen"></i></button>';

        document.getElementById('Mtype').value = '';
        document.getElementById('Mname').value = '';
        document.getElementById('Mvariation').value = '';
        document.getElementById('Mdimension').value = '';
        document.getElementById('Munit').value = '';
        document.getElementById('Mcost').value = '';
        document.getElementById('Mprice').value = '';
        document.getElementById('Mquantity').value = '';

        newRow.querySelector('.editMaterial').addEventListener('click', function() {
        // Retrieve material details from the row
        var materialType = cells[0].innerHTML;
        var materialName = cells[1].innerHTML;
        var materialVariation = cells[2].innerHTML;
        var materialDimension = cells[3].innerHTML;
        var materialUnit = cells[4].innerHTML;
        var materialPrice = cells[5].innerHTML;
        var materialCost = cells[6].innerHTML;
        var quantity = cells[7].innerHTML;

        // Fill the modal inputs with retrieved data
        document.getElementById('edit_Mtype').value = materialType;
        document.getElementById('edit_Mname').value = materialName;
        document.getElementById('edit_Mvariation').value = materialVariation;
        document.getElementById('edit_Mdimension').value = materialDimension;
        document.getElementById('edit_Munit').value = materialUnit;
        document.getElementById('edit_Mprice').value = materialPrice;
        document.getElementById('edit_Mcost').value = materialCost;
        document.getElementById('edit_Mquantity').value = quantity;

        // Show the modal
        var editMaterialModal = new bootstrap.Modal(document.getElementById('editMaterialModal'));
        editMaterialModal.show();

        // Add an event listener to handle saving edited material within the modal
        document.getElementById('saveEditedMaterial').addEventListener('click', function() {
            // Retrieve updated values from modal inputs
            var editedMaterialType = document.getElementById('edit_Mtype').value;
            var editedMaterialName = document.getElementById('edit_Mname').value;
            var editedMaterialVariation = document.getElementById('edit_Mvariation').value;
            var editedMaterialDimension = document.getElementById('edit_Mdimension').value;
            var editedMaterialUnit = document.getElementById('edit_Munit').value;
            var editedMaterialPrice = document.getElementById('edit_Mprice').value;
            var editedMaterialCost = document.getElementById('edit_Mcost').value;
            var editedQuantity = document.getElementById('edit_Mquantity').value;

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
                
            // Validation for numeric inputs
            if (
                !validateNumericInput(editedQuantity, 'Quantity') ||
                !validateNumericInput(editedMaterialCost, 'Cost') ||
                !validateNumericInput(editedMaterialPrice, 'Price')
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

            // Update the row with edited details
            cells[0].innerHTML = editedMaterialType;
            cells[1].innerHTML = editedMaterialName;
            cells[2].innerHTML = editedMaterialVariation;
            cells[3].innerHTML = editedMaterialDimension;
            cells[4].innerHTML = editedMaterialUnit;
            cells[5].innerHTML = editedMaterialPrice;
            cells[6].innerHTML = editedMaterialCost;
            cells[7].innerHTML = editedQuantity;

            // Close the modal after saving changes
            editMaterialModal.hide();
            });
        });

        // Create delete button and append icon
        var deleteButton = document.createElement('button');
        deleteButton.className = 'btn btn-danger btn-sm deleteMaterial m-1';
        var deleteIcon = document.createElement('i');
        deleteIcon.className = 'fas fa-trash-alt';
        deleteButton.appendChild(deleteIcon);
        cells[8].appendChild(deleteButton); 

        // Add event listener for delete button
        deleteButton.addEventListener('click', function() {
            var row = this.parentNode.parentNode;
            row.remove();

            // Get the row index
            var rowIndex = Array.from(table.querySelectorAll('tr')).indexOf(row);

            // Remove the corresponding object from the materialsArray
            materialsArray.splice(rowIndex - 1, 1); // Adjust index to account for table header

            // Update materialsData with the modified materialsArray
            materialsData = JSON.stringify(materialsArray);
            document.getElementById('materialsData').value = materialsData;
        });
    });

    document.getElementById('Dtype').addEventListener('change', function() {
        var percentageFields = document.getElementById('percentageFields');
        var amountFields = document.getElementById('amountFields');

        if (this.value === '1') {
            percentageFields.style.display = 'block';
            amountFields.style.display = 'none';
        } else if (this.value === '2') {
            percentageFields.style.display = 'none';
            amountFields.style.display = 'block';
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const saveOrderButton = document.querySelector('button[type="submit"]');
        saveOrderButton.addEventListener('click', function(event) {
            validateForm(event);
        });
    });

    function validateForm(event) {
    const inputFields = document.querySelectorAll('#Cname, #Ctype, #Cemail, #Cphone, #Cstreet, #Ccity, #Cpostcode, #Cstate, #governmentName, #governmentPhone, #Aname, #Aphone, #AOdate, #AOremark, #Dtype, #AOdiscountPerc, #AOdiscountAmt, #addonprice, #taxcode, #taxamount, #TOP');
    let isValid = true;
    let unfilledFields = [];

    const customerType = document.getElementById('Ctype').value;
    const fieldsToExclude = {
        '1': ['governmentName', 'governmentPhone', 'Aname', 'Aphone'],
        '2': ['Aname', 'Aphone'],
        '3': ['governmentName', 'governmentPhone']
    };

    const discountType = document.getElementById('Dtype').value;
    const discountFieldsToExclude = {
        '1': ['AOdiscountAmt'],
        '2': ['AOdiscountPerc']
    };


    inputFields.forEach(field => {
        const fieldId = field.getAttribute('id');
        const fieldValue = field.value.trim();

        // Check for required fields based on customer type, excluding certain fields
        if (fieldValue === '' && !fieldsToExclude[customerType].includes(fieldId) && !discountFieldsToExclude[discountType].includes(fieldId)) {
            isValid = false;
            field.style.border = '1px solid red';
            unfilledFields.push(fieldId);
        }
    });

    // Validate numerical values for specific fields
    const numericalFields = ['MdiscountAmt', 'MdiscountPerc', 'taxamount', 'addonprice'];

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

$(function () {
    $("#Mname").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "autocomplete.php",
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
                    // Handle error
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

$('#Munit').on('input', function() {
    // Allow only numbers and one decimal point
    this.value = this.value.replace(/[^0-9.]/g, '');

    // Ensure there's only one decimal point
    var decimalCount = (this.value.match(/\./g) || []).length;
    if (decimalCount > 1) {
        this.value = this.value.slice(0, -1);
    }

    // Ensure the value is at least 1 if it's a valid number
    var numericValue = parseFloat(this.value);
    if (isNaN(numericValue) || numericValue < 1) {
        this.value = '';
    }
});