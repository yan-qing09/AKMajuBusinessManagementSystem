<?php
include ('dbconnect.php');
$fid = $_GET["id"];

if(isset($_POST["Import"])) {
    $filename = $_FILES["file"]["tmp_name"];
    
    // Check if the file is empty
    if(filesize($filename) == 0) {
        echo "<script>
                var error = 'The uploaded file is empty';
                alert(error);
                window.location.href = 'rate.php?id=$fid';
              </script>";
        exit(); // Stop further execution
    }

    if($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Assuming CSV format is like: user_id,username,email
            $name = $getData[0]; // Assuming the first column is user_id
            $unit = $getData[1]; // Assuming the second column is username
            $price = $getData[2]; // Assuming the third column is email
            $distance = $getData[3]; // Assuming the third column is email
            $ctgy = $getData[4];
            
            // Check if the user exists in the tb_user table based on user_id
            $sql = "SELECT * FROM tb_rate
                    WHERE AK_name = '$name'
                    AND AK_ctgy='$ctgy'
                    AND AK_region='$distance'";
            $result = mysqli_query($con, $sql);

            if(mysqli_num_rows($result) > 0) {
                // User exists, perform UPDATE query
                $updateQuery = "UPDATE tb_rate SET AK_price='$price',
                AK_unit='$unit' 
                WHERE AK_name = '$name'
                    AND AK_ctgy='$ctgy'
                    AND AK_region='$distance'";
                $updateResult = mysqli_query($con, $updateQuery);

                if($updateResult) {
                    // Updated successfully
                } else {
                    echo "<script>
                            var error= 'Your data column is not correct';
                            alert(error);
                            window.location.href = 'rate.php?id=$fid';
                          </script>";
                }
            } else {
                // User doesn't exist, perform INSERT query
                $insertQuery = "INSERT INTO tb_rate (AK_name, AK_unit, AK_price,AK_region,AK_ctgy) VALUES ('$name', '$unit', '$price', '$distance','$ctgy')";
                $insertResult = mysqli_query($con, $insertQuery);

                if($insertResult) {
                    echo "<script>
                            var error= 'Your data has been updated';
                            alert(error);
                            window.location.href = 'rate.php?id=$fid';
                          </script>";
                } else {
                    echo "<script>
                            var error= 'Your data column is not correct';
                            alert(error);
                            window.location.href = 'rate.php?id=$fid';
                          </script>";
                }
            }
        }
        fclose($file);  
    }
}
?>
