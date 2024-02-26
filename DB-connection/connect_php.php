<?php
    // Connect to the database
    $servername = "sql200.ezyro.com"; // Replace with your database server name sql308.infinityfree.com
    $username = "ezyro_35434748"; // Replace with your database username if0_35235168
    $password = "d04b5a8d76d1"; // Replace with your database password
    $dbname = "ezyro_35434748_trusted_fund"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // echo "Please fill in all fields.";
    // die;

    // $conn->close();


