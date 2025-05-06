<?php
include ('dbconnect.php');
$fid = $_GET["id"];
if(isset($_POST["Import"])) {
    $filename = $_FILES["file"]["tmp_name"];    
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

            $negeri = $getData[0];
            $daerah = $getData[1];
            $harga = $getData[2]; 
            $jarak = $getData[3]; 
            $ctgy = $getData[4];

            $sql = "SELECT * FROM tb_zone
                    WHERE Z_state = '$negeri'
                    AND Z_region='$daerah'
                    AND Z_distance='$jarak'
                    AND CM_ctgy='$ctgy'";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result) > 0) {
                // User exists, perform UPDATE query
                $updateQuery = "UPDATE tb_zone SET Z_perc='$harga' 
                WHERE Z_state = '$negeri'
                AND Z_region = '$daerah'
                AND Z_distance = '$jarak'
                AND CM_ctgy='$ctgy'";
                $updateResult = mysqli_query($con, $updateQuery);
                if($updateResult) {
                } else {
                   echo "<script>
    var error= 'Your data column is not correct';
    alert(error);
    window.location.href = 'rate.php?id=$fid';
</script>";
                }
            } else {

                $insertQuery = "INSERT INTO tb_zone (Z_state, Z_region, Z_distance, Z_perc,CM_ctgy) VALUES ('$negeri', '$daerah', '$jarak', '$harga','$ctgy')";
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
