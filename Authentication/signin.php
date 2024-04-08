<?php

    include("connection.php");
    include("functions.php");

     // Check if user has clicked on the POST button
     if($_SERVER['REQUEST_METHOD'] == "POST")
     {
         // something was posted
         $email = $_POST['email'];
         $password = $_POST['password'];
          
         if(!empty($email) && !empty($password))
         {
            
          try {
            $stmt = mysqli_prepare($con, "SELECT * FROM logsvalidate WHERE email=?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          
            $user_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
          
            if (!empty($user_data)) {

              if ($password === $user_data['password']) {

                session_start(); // Start session 
                session_regenerate_id(true);
                // Store user ID securely (consider encryption or a salted hash)
                 $_SESSION['user_id'] = base64_encode($user_data['user_id']);
                 header("Location: ../contentpages/homepage.html");
                 exit();

              } else {
                // Login failed (incorrect password)
                echo "incorrect password";
              }
            } else {
              // Login failed (username not found)
              echo "Username not found!";

            }
          
            mysqli_stmt_close($stmt); // Close the prepared statement
          } catch (mysqli_sql_exception $e) {
            echo "Database error: " . $e->getMessage();
          }
          
        }
      }
      mysqli_close($con);