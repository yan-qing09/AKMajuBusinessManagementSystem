<?php
include ('dbconnect.php');

function generateSId($con) {
    $prefix = 'S';
    $uniqueId = bin2hex(random_bytes(3)); // Generates a random unique identifier

    // Combine the prefix and unique identifier
    $fId = $prefix . $uniqueId;

    // Check if the generated ID already exists in the table
    $query = "SELECT S_id 
              FROM tb_signature 
              WHERE S_id = '$fId'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        // If the generated ID already exists, generate a new one
        return generateSId($con);
    } else {
        return $fId;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['signature'])) {
        // Retrieve userid from the form data
        $uploadid = $_GET['id'];

        // Check if there is already an active signature for the user
        $checkActiveSignatureQuery = "SELECT S_id FROM tb_signature WHERE U_id = '$uploadid' AND S_status = '1'";
        $activeSignatureResult = mysqli_query($con, $checkActiveSignatureQuery);

        if ($activeSignatureResult && mysqli_num_rows($activeSignatureResult) > 0) {
            // If an active signature is found, update its status to inactive
            $activeSignature = mysqli_fetch_assoc($activeSignatureResult);
            $activeSignatureId = $activeSignature['S_id'];

            $updateStatusQuery = "UPDATE tb_signature 
                                  SET S_status = '0' 
                                  WHERE S_id = '$activeSignatureId'";
            mysqli_query($con, $updateStatusQuery);
        }

        // Specify the upload directory
        $uploadDir = 'signatures/';

        $fileName = basename($_FILES['signature']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generate a unique filename based on userid and file type
        $customFileName = $uploadid . '_' . time() . '.' . $fileType;
        $targetFilePath = $uploadDir . $customFileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($_FILES['signature']['tmp_name'], $targetFilePath)) {
            $fId = generateSId($con);

            // Get the current date and time
            $uploadDate = date('Y-m-d H:i:s');

            // Set the status to active for the new signature
            $status = '1';

            $sql = "INSERT INTO tb_signature(S_id,S_path,S_uploadDate,S_status,U_id) 
                    VALUES ('$fId','$targetFilePath','$uploadDate','$status','$uploadid')";
            

            if (mysqli_query($con, $sql)) {
                echo "Upload!";
            } else {
                echo "Failed to upload. Please try again.";
            }

            // Close the database connection
            mysqli_close($con);
        }
        header("Location: signature.php?id=$uploadid");
}
}
?>
