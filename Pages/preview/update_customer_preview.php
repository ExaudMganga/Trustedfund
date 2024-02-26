<?php
 include("../../DB-connection/connect_php.php");

//PHP for delete in view page
if (isset($_GET['dropid'])) {
    $deletepreview = $_GET['dropid'];

    //query to select data and return customer id
    $sql_select = "SELECT * FROM customer_amount WHERE `customer_amount`.`amount_id` = $deletepreview";
    $result = mysqli_query($conn, $sql_select);
    $dc_showdata = mysqli_fetch_assoc($result);
    $viewid = $dc_showdata['customer_id'];

    $sql_delete = "DELETE FROM customer_amount WHERE amount_id = $deletepreview";
    if (mysqli_query($conn, $sql_delete) === TRUE) {
            // redirect to preview page with ssuccessfully message and customer id
            header("Location: preview.php?viewid=$viewid&message=1.2");
            exit();
          }
         // redirect to preview page with server error message and customer id
         header("Location: preview.php?viewid=$viewid&message=0");
         exit;	
  }

    // Check if the form is submitted
    if (isset($_POST['name']) && $_SERVER["REQUEST_METHOD"] === "POST") {
       // Get form data
        $cust_name = $_POST['name'];
        $ca_date = $_POST['amount_date'];
        $ca_added_loan = $_POST['added_loan'];
       //select query and pass viewid 
        $sql_customer = "SELECT * FROM customer WHERE  customer_name = '$cust_name' limit 1";
        $result = mysqli_query($conn, $sql_customer);
        $customer_detail = mysqli_fetch_assoc($result);
        $viewid = $customer_detail['customer_id'];
        $fund_amount =$customer_detail['fund_amount'];
       // Perform basic validation (you can add more complex validation here)

      if (empty($cust_name) || empty($ca_date) || empty($ca_added_loan)) {
        // redirect to dashboad page with server one field not filled and customer id
        header("Location: preview.php?viewid=$viewid&message=3");
        exit;
      } 
       // Insert data into the database table
         $converted_date = date("Y-m-d", strtotime($ca_date)); // Convert from "mm/dd/yyyy" to "yyyy-mm-dd"
         //calculation of loan amount
         $loan_amount = $fund_amount + $ca_added_loan;
         // calculation of total interesst
         $sql2 = "SELECT SUM(date_cush.dc_return_amount) AS total_interest FROM date_cush WHERE date_cush.customer_id = '$viewid' limit 1 ";
          $result2 = mysqli_query($conn, $sql2);
          $amount_return = mysqli_fetch_assoc($result2);
         $total_interest = $amount_return['total_interest'];
         //calcuation of rate
         $rate = $loan_amount * 0.3;   
       // Insert data into the customer_amount table using prepared statement
       $sql_insert = "INSERT INTO customer_amount (customer_id, amount_date, loan_amount, added_loan, total_interest, rate) 
               VALUES (?, ?, ?, ?, ?, ?)";
       $stmt_insert = mysqli_prepare($conn, $sql_insert);//prepare statement
       // Bind parameters
       mysqli_stmt_bind_param($stmt_insert, "isdddi", $viewid, $converted_date, $loan_amount, $ca_added_loan, $total_interest, $rate);
       //check if cquery result is true
         if (mysqli_stmt_execute($stmt_insert)) {
       //update table customer in fund amount
        $sql3 = "UPDATE customer SET fund_amount = ? WHERE customer_id = ? ";
        $stmt3 = mysqli_prepare($conn, $sql3);//prepare statement
        // Bind parameters
        mysqli_stmt_bind_param($stmt3, "ii", $loan_amount, $viewid);
        
        // check Execute the statement
         if (mysqli_stmt_execute($stmt3)) {
          header("Location: preview.php?viewid=$viewid&message=1");
          exit();
         }
         }          
            // redirect to preview page with server error message and customer id
            header("Location: preview.php?viewid=$viewid&message=0");
            exit;
        $conn->close();
    }