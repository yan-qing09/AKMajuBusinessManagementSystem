<?php
include ('dbconnect.php');
include ('mysession.php');

// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($con, $_POST['term']);

// Perform a query to fetch suggestions
$query = "SELECT DISTINCT T_Desc FROM tb_am_type WHERE T_Desc LIKE '%" . $searchTerm . "%'";
$result = mysqli_query($con, $query);

// Collect the suggestions into an array
$suggestions = array();
while ($row = mysqli_fetch_assoc($result)) {
    $suggestions[] = $row['T_Desc'];
}

// Return the suggestions as JSON
echo json_encode($suggestions);

// Close the database connection
mysqli_close($con);
?>