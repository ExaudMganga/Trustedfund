<?php
 include("../../DB-connection/connect_php.php");

 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $cust_name = $_POST["name"];
    $cust_phone = $_POST["phone_no"];
    $fund_amount= $_POST["amount"];
    $c_date = $_POST["date"];
    $return_amount = $_POST["returned_amount"];


    // Perform basic validation (you can add more complex validation here)
    if (empty($cust_name) || empty($fund_amount) || empty($c_date) || empty($return_amount) || is_numeric($cust_name)) {
      // redirect to dashboad page with server one field not filled
      header("Location: dashboard.php?message=3");
      exit;
    }
      // Validate if user has already exist
        $sql = "SELECT * FROM customer WHERE customer_name = '$cust_name'limit 1";
        $result = mysqli_query($conn, $sql);
      //If the cridential are valid jump to inside page
        if ($result->num_rows > 0) {
         $customer_data = $result->fetch_assoc();
         //check if customer exist 
           if ($customer_data['customer_name'] == $cust_name && $customer_data['phone_no'] == $cust_phone)
           {
          // redirect to dashboad page with server error message
            header("Location: dashboard.php?message=2");
            exit;
           } 
        } 
        // Insert data into the database table
        $converted_date = date("Y-m-d", strtotime($c_date)); // Convert to "yyyy/mm/dd"
        $sql = "INSERT INTO customer (customer_name, phone_no, fund_amount, customer_date, return_amount) 
        VALUES ('$cust_name',$cust_phone,$fund_amount,'$converted_date',$return_amount)";
        //check if cquery result is true
        if ($conn->query($sql) === TRUE) {
        // redirect to dashboad page with ssuccessfully message
            header("Location: dashboard.php?message=1");
            exit();
        } 
        // redirect to dashboad page with server error message
        header("Location: dashboard.php?message=0");
        exit;
    $conn->close();
}