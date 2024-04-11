
<?php
// Establish database connection 
session_start();
include("../Authentication/connection.php");

// Fetch data from the database
$query = "SELECT Name, orderID, Location, Waste_Category, Mode_of_Payment FROM pickup_data";
$result = mysqli_query($con, $query);

// Check if query was successful
if ($result) {
    $data = array();
    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add each row to the data array
        $data[] = $row;
    }
    // Send the data as JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Handle error
    echo json_encode(array('error' => 'Failed to fetch data'));
}

// Close the database connection
mysqli_close($con);

