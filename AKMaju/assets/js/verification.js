$(document).ready(function () {
    // Function to handle approval
    function handleApproval(buttonClass, popupClass, formClass) {
        $(buttonClass).click(function () {
            $(".successMessage").hide(); // Hide the success message
            $(popupClass).modal("show");
        });

        $(formClass + '-submit').on('click', function () {
            // Collect form data
            var formData = {
                userid: $("input[name='userid']").val(),
                form_type: $("input[name='form_type']").val(),
                form_id: $("input[name='form_id']").val(),
                order_id: $("input[name='order_id']").val()
            };

            // Change button text to "Sending" when clicked
            $.ajax({
                type: "POST",
                url: "verification.php",
                data: formData,  // Pass the form data here
                success: function (response) {
                    if ($.trim(response) === "Success") {
                        // Hide the form and display the success message
                        $(popupClass).hide();
                        $(".successMessage").show();
                    } else {
                        // Display an error message to the user
                        alert("Failed to approve. Please try again. Reason: " + response.error);
                    }
                },
                error: function () {
                    alert("Error in AJAX request.");
                }
            });
        });
    }

    // Call the function for each type of approval
    handleApproval(".approveCQbutton", ".approveCQPopup", ".approveCQ");
    handleApproval(".approveAQbutton", ".approveAQPopup", ".approveAQ");
    
    handleApproval(".approveIbutton", ".approveIPopup", ".approveI");
    handleApproval(".approveDObutton", ".approveDOPopup", ".approveDO");
});