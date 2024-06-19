
<?php
// Start or resume the session
session_start();

// Include connection and functions files
include("../Authentication/connection.php");



// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Retrieve form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = $_POST['phone-number'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $location = $_POST['location'];
    
    // Initialize variables for waste category and payment
    $waste = "";
    $pay = "";

    // Check if waste category checkboxes are selected
    if (isset($_POST['wasteCat'])) {
        // Loop through each selected checkbox value
        foreach ($_POST['wasteCat'] as $selectedWaste) {
            // Assign selected waste category to the $waste variable
            $waste .= $selectedWaste . ", "; // You might want to concatenate instead of returning
        }
        // Remove the last comma and space
        $waste = rtrim($waste, ", ");
    } else {
       // No checkbox selected
       echo "No category was selected";
       return false;
    }

    // Check if payment method radio button is selected
    if (isset($_POST['Payment'])) {
        // Assign selected payment method to the $pay variable
        $pay = $_POST['Payment'];
    } else {
        // no payment solution selected
        echo "No payment method chosen!!";
    }

    // Basic form validation 
    if (!empty($name) && !empty($phone) && !empty($country) && !empty($city) && !empty($location) && is_numeric($phone)) {
       
        //generate orderID
        function generateUniqueID() {
            return uniqid(bin2hex(random_bytes(5)), true);
        }
        
        $orderid = generateUniqueID();
        // Insert new order into database
        // Prepare the SQL statement with parameter binding
        $stmt = mysqli_prepare($con, "INSERT INTO pickup_data (orderID, Name, Number, Country, Town, Location, Waste_Category, Mode_of_Payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssssss", $orderid, $name, $phone, $country, $city, $location, $waste, $pay);

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Success
            echo "<script>
        alert('New records created successfully');
        window.location.href = 'homepage.html';
                 </script>";
        } else {
            // Error
            echo "Error: " . $stmt->error;
        }
        
        echo json_encode($response); // Return response as JSON
        mysqli_stmt_close($stmt); // Close the prepared statement

    } else {
        // Validation error
        echo "Please enter some valid information!";
    }

    mysqli_close($con); // Close the database connection
}