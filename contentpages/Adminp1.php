<?php
// PHP scripts to interact with the database and perform operations like adding/removing admins, removing users, etc.

// Sample function to connect to the database
function connectToDatabase() {
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Sample function to add an admin
function addAdmin($username) {
    $conn = connectToDatabase();

    // Perform SQL query to add admin
    $sql = "INSERT INTO admins (username) VALUES ('$username')";

    if ($conn->query($sql) === TRUE) {
        echo "Admin added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Sample function to remove an admin
function removeAdmin($username) {
    $conn = connectToDatabase();

    // Perform SQL query to remove admin
    $sql = "DELETE FROM admins WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Admin removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Sample function to remove a user
function removeUser($username) {
    $conn = connectToDatabase();

    // Perform SQL query to remove user
    $sql = "DELETE FROM users WHERE username='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "User removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

// Other functions to perform database operations like fetching pickup orders, cleanup orders, user count, admin count, etc.
