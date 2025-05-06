var materialsArray = []; // Initialize or populate materialsArray with necessary data
var materialsData;

function editMaterial(rowIndex, cells) {
    var materialData = materialsArray[rowIndex]; // Retrieve material data from materialsArray
    var modalCells = cells.slice(); // Create a local copy of the cells for this specific row

    // Populate modal inputs with retrieved data from materialObject or materialData
    document.getElementById('edit_Mtype').value = materialData.Mtype;
    document.getElementById('edit_Mname').value = materialData.Mname;
    document.getElementById('edit_Mvariation').value = materialData.Mvariation;
    document.getElementById('edit_Mdimension').value = materialData.Mdimension;
    document.getElementById('edit_Munit').value = materialData.Munit;
    document.getElementById('edit_Mprice').value = materialData.Mprice;
    document.getElementById('edit_Mcost').value = materialData.Mcost;
    document.getElementById('edit_Mquantity').value = materialData.Mquantity;
    
    // Assuming the discount type is stored as Dtype in materialData
    document.getElementById('Dtype1').value = materialData.Dtype || ''; 

    // Check the discount type and populate the respective discount fields
    if (materialData.Dtype === '1') {
        // Percentage discount selected
        document.getElementById('edit_MdiscountPerc').value = materialData.MdiscountPerc || '';
        document.getElementById('edit_MdiscountAmt').value = ''; // Clear amount discount field
    } else if (materialData.Dtype === '2') {
        // Amount discount selected
        document.getElementById('edit_MdiscountAmt').value = materialData.MdiscountAmt || '';
        document.getElementById('edit_MdiscountPerc').value = ''; // Clear percentage discount field
    }

    document.getElementById('edit_taxcode').value = materialData.MtaxCode || '';
    document.getElementById('edit_taxamount').value = materialData.MtaxAmt || '';

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

        // Update the row with edited details
        modalCells[0].innerHTML = editedMaterialType;
        modalCells[1].innerHTML = editedMaterialName;
        modalCells[2].innerHTML = editedMaterialVariation;
        modalCells[3].innerHTML = editedMaterialDimension;
        modalCells[4].innerHTML = editedMaterialUnit;
        modalCells[5].innerHTML = editedMaterialPrice;
        modalCells[6].innerHTML = editedMaterialCost;
        modalCells[7].innerHTML = editedQuantity;

        // Update additional fields in the table if they exist
        modalCells[8].innerHTML = editedDiscountPerc;
        modalCells[9].innerHTML = editedDiscountAmt;
        

        modalCells[10].innerHTML = editedTaxCode;
        modalCells[11].innerHTML = editedTaxAmount;
        modalCells[14].innerHTML = discountType;

        // Identify the index of the edited material object in the materialsArray
        var indexOfEditedMaterial = rowIndex;/* replace this with the index or ID of the edited material */;

        // Update the material object in materialsArray with the new values from the table cells
        materialsArray[indexOfEditedMaterial].Mtype = editedMaterialType;
        materialsArray[indexOfEditedMaterial].Mname = editedMaterialName;
        materialsArray[indexOfEditedMaterial].Mvariation = editedMaterialVariation;
        materialsArray[indexOfEditedMaterial].Mdimension = editedMaterialDimension;
        materialsArray[indexOfEditedMaterial].Munit = editedMaterialUnit;
        materialsArray[indexOfEditedMaterial].Mprice = editedMaterialPrice;
        materialsArray[indexOfEditedMaterial].Mcost = editedMaterialCost;
        materialsArray[indexOfEditedMaterial].Mquantity = editedQuantity;

        // Update discount and tax fields based on the discount type
        materialsArray[indexOfEditedMaterial].Dtype = discountType;
        if (discountType === '1') {
            materialsArray[indexOfEditedMaterial].MdiscountPerc = editedDiscountPerc;
            delete materialsArray[indexOfEditedMaterial].MdiscountAmt; // Clear amount discount field
        } else if (discountType === '2') {
            materialsArray[indexOfEditedMaterial].MdiscountAmt = editedDiscountAmt;
            delete materialsArray[indexOfEditedMaterial].MdiscountPerc; // Clear percentage discount field
        }

        materialsArray[indexOfEditedMaterial].MtaxCode = editedTaxCode;
        materialsArray[indexOfEditedMaterial].MtaxAmt = editedTaxAmount;

        // Convert the materialsArray to JSON to pass to the next page
        materialsData = JSON.stringify(materialsArray);


        // Close the modal after saving changes
        editMaterialModal.hide();
        });
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

    if (discountType === '1') {
        // Percentage discount selected
        if (!validateNumericInput(discountPct, 'Discount Percentage')) {
            return;
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
            return; // Prevent further execution if fields are empty
        }

    } else if (discountType === '2') {
        // Amount discount selected
        if (!validateNumericInput(discountAmt, 'Discount Amount')) {
            return;
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
            return; // Prevent further execution if fields are empty
        }
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
            Mquantity: quantity,
            Dtype: discountType
        };

        if (discountType === '1') {
            // Percentage discount selected
            materialObject.MdiscountPerc = discountPct;
        } else if (discountType === '2') {
            // Amount discount selected
            materialObject.MdiscountAmt = discountAmt;
        }

        // Assuming taxCode and taxAmt need to be included as well
        materialObject.MtaxCode = taxCode;
        materialObject.MtaxAmt = taxAmt;

        materialsArray.push(materialObject); // Add this material to the array
        materialsData = JSON.stringify(materialsArray);

        // Set the JSON string as the value of the materialsData input field
        document.getElementById('materialsData').value = materialsData;

    var table = document.getElementById('dataTableNew');
    var newRow = table.insertRow(-1);
    var cells = [];

    for (var i = 0; i < 15; i++) {
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
    cells[8].innerHTML = materialObject.MdiscountPerc || ''; // Add percentage discount if it exists
    cells[9].innerHTML = materialObject.MdiscountAmt || ''; // Add amount discount if it exists
    cells[14].innerHTML = discountType;
    cells[10].innerHTML = materialObject.MtaxCode || ''; // Add tax code if it exists
    cells[11].innerHTML = materialObject.MtaxAmt || ''; // Add tax amount if it exists
    cells[12].innerHTML = '<button class="btn btn-primary btn-sm editMaterial m-1" type="button" id="editMaterial"><i class="fas fa-pen"></i></button>';

    document.getElementById('Mtype').value = '';
    document.getElementById('Mname').value = '';
    document.getElementById('Mvariation').value = '';
    document.getElementById('Mdimension').value = '';
    document.getElementById('Munit').value = '';
    document.getElementById('Mcost').value = '';
    document.getElementById('Mprice').value = '';
    document.getElementById('Mquantity').value = '';
    document.getElementById('MdiscountPerc').value = ''; // Clear discount percentage
    document.getElementById('MdiscountAmt').value = ''; // Clear discount amount
    document.getElementById('taxcode').value = ''; // Clear tax code
    document.getElementById('taxamount').value = ''; // Clear tax amount

    // Event delegation for edit buttons
    document.getElementById('dataTableNew').addEventListener('click', function(event) {
        if (event.target.classList.contains('editMaterial')) {
            var row = event.target.closest('tr');
            var cells = row.cells; // Get the cells of the specific row
            var rowIndex = row.rowIndex - 1; // Adjust index to account for table header row
            editMaterial(rowIndex, cells); // Call editMaterial function with the index and cells of the row
        }
    });

    // Create delete button and append icon
    var deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-danger btn-sm deleteMaterial m-1';
    var deleteIcon = document.createElement('i');
    deleteIcon.className = 'fas fa-trash-alt';
    deleteButton.appendChild(deleteIcon);
    cells[13].appendChild(deleteButton); 

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
    // Your code here
    document.getElementById('Dtype1').addEventListener('change', function() {
        var percentageFields = document.getElementById('percentageFields1');
        var amountFields = document.getElementById('amountFields1');

        if (this.value === '1') {
            percentageFields.style.display = 'block';
            amountFields.style.display = 'none';
        } else if (this.value === '2') {
            percentageFields.style.display = 'none';
            amountFields.style.display = 'block';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const saveOrderButton = document.querySelector('button[type="submit"]');
    saveOrderButton.addEventListener('click', function(event) {
        validateForm(event);
    });
});

function validateForm(event) {
const inputFields = document.querySelectorAll('#Cname, #Ctype, #Cemail, #Cphone, #Cstreet, #Ccity, #Cpostcode, #Cstate, #governmentName, #governmentPhone, #Aname, #Aphone, #AOdate, #AOremark, #addonprice, #TOP');
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
const numericalFields = ['addonprice'];

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