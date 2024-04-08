<?php
include("connection.php");
include("functions.php");
    // check_login function
    // $con - connection to the database
    // $user_data = check_login($con);  =>Not needed because we don't need to check if a user is logged in the signup page


        // Check if user has clicked on the POST button
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Something was posted
        $username = mysqli_real_escape_string($con, $_POST['name']); // Sanitize username
        $email = mysqli_real_escape_string($con, $_POST['email']); // Sanitize email
        $password = $_POST['password'];

        // Basic validation 
        if (!empty($username) && !empty($password) && !empty($email) && !is_numeric($username)) {

            // Hash the password for security
           // $hashed_password = hash_password($password);

            // Generate a random user ID 
            $user_id = random_num(12); 

            // Prepare the SQL statement with parameter binding
            $stmt = mysqli_prepare($con, "INSERT INTO logsvalidate (user_id, full_name, email, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssss", $user_id, $username, $email, $password);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
            // Success
            header("Location: signin.html"); // Redirect to login page
            die();
            } else {
            // Error
            echo "Registration failed. Please try again.";
            }

    mysqli_stmt_close($stmt); // Close the prepared statement

  } else {
    // Validation error
    echo "Please enter some valid information!";
  }
}
    mysqli_close($con);