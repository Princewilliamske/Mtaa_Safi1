<?php

    include("../Authentication/connection.php");
    include("../Authentication/functions.php");
    session_start();              // Start/resume THIS session
          // Get the user's ID from this session (if it exists)
                                   // If no session, then false

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 

        // Retrieve form data
        $name = mysqli_real_escape_string($con,$_POST['name']);
        $phone = $_POST['phone-number'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $location = $_POST['location'];
        
        if (!isset($_POST['wasteCat'])) {
          // No checkbox selected
          echo "No category was selected";
          return false;
      } elseif (!is_array($_POST['wasteCat'])) {
          // Ensure $_POST['wasteCat'] is an array
          echo "Invalid input";
          return false;
      } else {
          // Loop through each selected checkbox value
          foreach ($_POST['wasteCat'] as $waste) {
              // Do something with the selected checkbox value
              echo $waste; // For example, echoing the selected value
          }
      }
    if (isset($_POST['Payment'])) {
      //get radio button value
        $pay = $_POST['Payment'];
        return  $pay;
        } else {
          //default to Cash on Delivery
          $pay="Cash On Delivery";
          return  $pay;
        }
    }

         // Basic form validation 
         if (!empty($name) && !empty($phone) && !empty($country) &&!empty($city) && !empty($location) &&is_numeric($phone)) {

                // Prepare the SQL statement with parameter binding
            $stmt = mysqli_prepare($con, "INSERT INTO pickup_data (Name, Number, Country, Town, Location, Waste_Category, Mode_of_Payment) VALUES (?, ?, ?, ?, ?, ?, ?)");
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

        mysqli_close($con);