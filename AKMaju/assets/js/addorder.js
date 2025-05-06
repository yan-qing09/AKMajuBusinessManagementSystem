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

document.addEventListener('DOMContentLoaded', function() {
    const saveOrderButton = document.querySelector('button[type="submit"]');
    saveOrderButton.addEventListener('click', function(event) {
        validateForm(event);
    });
});

function validateForm(event) {
const inputFields = document.querySelectorAll('#Cname, #Ctype, #Cemail, #Cphone, #Cstreet, #Ccity, #Cpostcode, #Cstate, #governmentName, #governmentPhone, #Aname, #Aphone, #AOdate, #AOremark, #TOP');
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