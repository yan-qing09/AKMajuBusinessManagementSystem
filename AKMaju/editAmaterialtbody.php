<?php
include('dbconnect.php'); // Assuming this file contains your database connection logic
include('mysession.php'); // If needed for session management

$ao_id = $_GET['ao_id'];
// Fetch data from your database
$sql = "SELECT *
        FROM tb_ao_material AS ao
        INNER JOIN tb_advertisement_material AS ad ON ao.AO_id = ad.AO_id
        WHERE ao.AO_id = '$ao_id'";
$result = $con->query($sql);

// Check if there's any data
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["AM_type"] . "</td>"; 
        echo "<td>" . $row["AM_name"] . "</td>"; 
        echo "<td>" . $row["AM_variation"] . "</td>"; 
        echo "<td>" . $row["AM_dimension"] . "</td>"; 
        echo "<td>" . $row["AOM_unit"] .. $row["AM_unit"] . "</td>"; 
        echo "<td>" . $row["AOM_adjustprice"] . "</td>"; 
        echo "<td>" . $row["AOM_origincost"] . "</td>"; 
        echo "<td>" . $row["AOM_qty"] . "</td>"; 
        echo "<td>" . $row["AOM_discPct"] . "</td>"; 
        echo "<td>" . $row["AOM_discAmt"] . "</td>"; 
        echo "<td>" . $row["AOM_taxcode"] . "</td>"; 
        echo "<td>" . $row["AOM_taxAmt"] . "</td>"; 
        echo "<td></td>"; 
        echo "<td><button class='btn btn-primary btn-sm editMaterial m-1' type='button'><i class='fas fa-pen'></i></button></td>";
        echo "<td><button class='btn btn-danger btn-sm deleteMaterial m-1' type='button'><i class='fas fa-trash-alt'></i></button></td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
$con->close();

?>