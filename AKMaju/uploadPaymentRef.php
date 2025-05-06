<?php
include ('dbconnect.php');

function generatePId($con) {
    $prefix = 'P';
    $uniqueId = bin2hex(random_bytes(8)); // Generates a random unique identifier

    // Combine the prefix and unique identifier
    $pId = $prefix . $uniqueId;

    // Check if the generated ID already exists in the table
    $query = "SELECT P_id FROM tb_payment_ref WHERE P_id = '$pId'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        // If the generated ID already exists, generate a new one
        generateFId($con);
    } else {
        return $pId;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['paymentRef'])) {
        // Retrieve userid from the form data
        $uploadid = $_GET['id'];
        $aoid = $_GET['aoid'];


        // Specify the upload directory
        $uploadDir = 'paymentRef/';

        $fileName = basename($_FILES['paymentRef']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generate a unique filename based on userid and file type
        $customFileName = $uploadid . '_' . time() . '.' . $fileType;
        $targetFilePath = $uploadDir . $customFileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($_FILES['paymentRef']['tmp_name'], $targetFilePath)) {
            $pId = generatePId($con);;

            // Get the current date and time
            $uploadDate = date('Y-m-d H:i:s');

            // Set the initial status (you can change this as needed)
            $status = '0';

            $sql = "INSERT INTO tb_payment_ref (P_id,P_path,P_uploadDate,P_status,U_id, O_id) 
                    VALUES ('$pId','$targetFilePath','$uploadDate','$status','$uploadid','$aoid')";
echo $sql;
            if (mysqli_query($con, $sql)) {
                echo "Upload!";
            } else {
                echo "Failed to upload. Please try again.";
            }

            // Close the database connection
            mysqli_close($con);

            // Redirect to a specific URL
            $redirectURL = 'EditAOrder.php?id=' . $uploadid . '&o_id=' . $aoid;
            header('Location: ' . $redirectURL);
            exit();
        } else {
            echo "Failed to upload the file. Please try again.";
        }
    } else {
        echo "No file uploaded.";
    }
} else {
    echo "Invalid request method.";
}


?>
