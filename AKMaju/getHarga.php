<?php
include ('dbconnect.php');
include ('mysession.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedTukang = $_POST['Tukang'];
    $selectedKawasan = $_POST['Kawasan'];

    // Fetch harga from the database based on Tukang and dynamically constructed column
    $query = "SELECT AK_price FROM tb_rate WHERE AK_name = ? AND AK_region = ? AND AK_ctgy = 'T'";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $selectedTukang, $selectedKawasan);
    
    $stmt->execute();
    $stmt->bind_result($harga);
    $stmt->fetch();
    $stmt->close();

    // Return the fetched harga as the response
    echo $harga;
}
?>