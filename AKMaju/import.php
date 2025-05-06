<?php
include ('dbconnect.php');
if(isset($_POST["Import"])) {
    $filename = $_FILES["file"]["tmp_name"];    
    if($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Assuming CSV format is like: user_id,username,email
            $negeri = $getData[0]; // Assuming the first column is user_id
            $daerah = $getData[1]; // Assuming the second column is username
            $harga = $getData[2]; // Assuming the third column is email
            $jarak = $getData[3]; // Assuming the third column is email
            $ctgy = $getData[4];
            // Check if the user exists in the tb_user table based on user_id
            $sql = "SELECT * FROM tb_construction_zone
                    WHERE Z_state = '$negeri'
                    AND Z_region='$daerah'
                    AND Z_distance='$jarak'
                    AND CM_ctgy='$ctgy'";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result) > 0) {
                // User exists, perform UPDATE query
                $updateQuery = "UPDATE tb_construction_zone SET Z_perc='$harga' 
                WHERE Z_state = '$negeri'
                AND Z_region = '$daerah'
                AND Z_distance = '$jarak'
                AND CM_ctgy='$ctgy'";
                $updateResult = mysqli_query($con, $updateQuery);
                if($updateResult) {
                    echo"successful 1";
                } else {
                   echo"failed 1";
                }
            } else {
                // User doesn't exist, perform INSERT query
                $insertQuery = "INSERT INTO tb_construction_zone (Z_state, Z_region, Z_distance, Z_perc,CM_ctgy) VALUES ('$negeri', '$daerah', '$jarak', '$harga','$ctgy')";
                $insertResult = mysqli_query($con, $insertQuery);
                if($insertResult) {
                    echo"successful 2";
                } else {
                     echo"failed 2";
                }
            }
        }
        fclose($file);  
    }
}
?>
