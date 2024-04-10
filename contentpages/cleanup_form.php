
<?php

// Include connection and functions files
include("../Authentication/connection.php");
include("../Authentication/functions.php");

// Start or resume the session
session_start();

$response = array();


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Retrieve form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = $_POST['phone-number'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $location = $_POST['location'];
    
    // Initialize variables for cleanup_type
    $clean_type = "";

    // Check if cleanup_type radio button is selected
    if (isset($_POST['Clean-Up_Type'])) {
        // Assign selected payment method to the $pay variable
        $clean_type = $_POST['Clean-Up_Type'];
    } else {
        // no cleanup_type  selected
        echo "o cleanup_type chosen!!";
    }
    $area = $_POST['coveredareas'];
    $support = $_POST['support'];

    // Basic form validation 
    if (!empty($name) && !empty($phone) && !empty($country) && !empty($city) && !empty($location) && is_numeric($phone)) {

        //generate cleanup ID
        $cleanid = randomString(10);

        // Prepare the SQL statement with parameter binding
        $stmt = mysqli_prepare($con, "INSERT INTO cleanup_data (cleanupID, Name, Number, Country, Town, Location, Cleanup_type, Areas_covered, Support) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssssss",$cleanid, $name, $phone, $country, $city, $location, $clean_type, $area, $support);


        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success
            $response['message'] = "Pickup Order successful";
            $response['redirect'] = "homepage.html"; // Redirect to homepage

        } else {
            // Error
            $response['message'] = "Pickup Order unsuccessful"+ mysqli_error($con);
              // Display SQL error message
        }
        
        echo json_encode($response); // Return response as JSON
        mysqli_stmt_close($stmt); // Close the prepared statement

    } else {
        // Validation error
        echo "Please enter some valid information!";
    }

   
    mysqli_close($con); // Close the database connection
}