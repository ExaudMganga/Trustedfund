<?php
 include("../../DB-connection/connect_php.php");

//PHP for delete in view page
if (isset($_GET['dropid'])) {
    $deleteview = $_GET['dropid'];

    //query to select data and return customer id
    $sql_select = "SELECT * FROM date_cush WHERE `date_cush`.`dc_id` = $deleteview";
    $result = mysqli_query($conn, $sql_select);
    $dc_showdata = mysqli_fetch_assoc($result);
    $viewid = $dc_showdata['customer_id'];

    $sql_delete = "DELETE FROM date_cush WHERE dc_id = $deleteview";
    if (mysqli_query($conn, $sql_delete) === TRUE) {
            // redirect to view page with ssuccessfully message and customer id
            header("Location: view.php?viewid=$viewid&message=1.2");
            exit();
          }
         // redirect to dashboad page with server error message and customer id
         header("Location: view.php?viewid=$viewid&message=0");
         exit;	
  }

    // Check if the form is submitted
    if (isset($_POST['name']) && $_SERVER["REQUEST_METHOD"] === "POST") {
       // Get form data
        $cust_name = $_POST['name'];
        $c_date = $_POST['date'];
        $return_amount = $_POST['returned_amount'];
       //select query and pass viewid 
        $sql_customer = "SELECT * FROM customer WHERE  customer_name = '$cust_name' limit 1";
        $result = mysqli_query($conn, $sql_customer);
        $customer_detail = mysqli_fetch_assoc($result);
        $viewid = $customer_detail['customer_id'];
       // Perform basic validation (you can add more complex validation here)
      if (empty($cust_name) || empty($c_date) || empty($return_amount)) {
        // redirect to dashboad page with server one field not filled and customer id
        header("Location: view.php?viewid=$viewid&message=3");
        exit;
      } 
       // Insert data into the database table
         $converted_date = date("Y-m-d", strtotime($c_date)); // Convert from "mm/dd/yyyy" to "yyyy-mm-dd"
         $sql_insert = "INSERT INTO date_cush (dc_date, dc_return_amount, customer_id) 
         VALUES ('$converted_date',$return_amount,$viewid)";// Insert data into the database query
       //check if cquery result is true
         if (mysqli_query($conn, $sql_insert) === TRUE) {
            // redirect to view page with ssuccessfully message and customer id
            header("Location: view.php?viewid=$viewid&message=1");
            exit();
         } 
            // redirect to dashboad page with server error message and customer id
            header("Location: view.php?viewid=$viewid&message=0");
            exit;
        $conn->close();
    }