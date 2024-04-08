<?php

    include("connection.php");
    include("functions.php");
    $_SESSION();

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 

        // Retrieve form data
        $name = mysqli_real_escape_string($con,$_POST['name']);
        $phone = $_POST['phone-number'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $location = $_POST['location'];
        $Waste = $_POST['wasteCat'];
        $pay = $_POST['payment'];

         // Basic form validation 
         if (!empty($name) && !empty($phone) && !empty($country) &&!empty($city) && !empty($location) &&is_numeric($phone)) {

                // Prepare the SQL statement with parameter binding
            $stmt = mysqli_prepare($con, "INSERT INTO pickup_data (Name, PhoneNumber, Country, City/Town, Location, Waste_Category, Mode_of_Payment) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $phone, $country, $city, $location, $waste, $pay);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            // Success
            die();
            } else {
            // Error
            echo "Pickup Order unsuccessful";
            }

    mysqli_stmt_close($stmt); // Close the prepared statement

  } else {
    // Validation error
    echo "Please enter some valid information!";
  }
}
        mysqli_close($con);