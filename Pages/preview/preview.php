<?php
session_start();
 
  include("../../DB-connection/connect_php.php");
  include("../function_log.php");

 $user_data = check_login($conn);


 $viewid = $_GET['viewid']; 
 $sql = "SELECT * FROM customer WHERE customer_id = '$viewid' limit 1";
 $result = mysqli_query($conn, $sql);
$customer_showdata = mysqli_fetch_assoc($result);

//php pagination and display from database
$customer_id = $customer_showdata['customer_id'];
if(isset($_GET['page_no'])){
      $page_number = $_GET["page_no"];
  }
  else{
      $page_number = 1;
  }

    $limit = 4;
    // get the initial page number
    $initial_page = ($page_number-1) * $limit; 
  $sql1 = "SELECT * FROM customer_amount WHERE `customer_amount`.`customer_id` = $customer_id ORDER BY `customer_amount`.`amount_date` DESC LIMIT $initial_page,$limit";
  $result1 = mysqli_query($conn, $sql1);

//query to give result at the return_amount
$sql_sum = "SELECT SUM(dc_return_amount) AS total_return_amount FROM date_cush 
              WHERE `date_cush`.`customer_id`= $viewid";
 $result_total = mysqli_query($conn, $sql_sum);
 $total_data = mysqli_fetch_assoc($result_total);
?>


<!DOCTYPE html>
<html>
 <head>
	<title>preview page</title>
  <link rel="stylesheet" href="preview.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">
 </head>
 <body>
  <div class="container" id="main-page">
    <div class="menubar">
      
      <!-- ---------------LOGO------------------ -->
      <span class="outer-box">
        <h3 class="trusted">TRUSTED</h3>
        <span class="fund-foundation">
          <h3 class="fund">FUND</h3>
          <h3 class="foundation">FOUNDATION</h3>
        </span></span>
        <h3>Welcome <b>[ <?php echo $user_data['user_name'];?> ]</b></h3> 
    </div>
    <nav>
      <div class="menu-list">
        <ul>
          <li><a href="../dashboard/dashboard.php"><i class="uil uil-estate"></i>Home</a></li>
          <li><a href="../customer/customer.php"><i class="uil uil-users-alt"></i>Customer</a></li>
          <li><a href="../Amount/amount.php"><i class="uil uil-usd-circle"></i>Amount</a></li>
          <li><a href="../report/report.php"><i class="uil uil-file-alt"></i>Report</a></li>
        </ul>
      </div>
      <div class="log-out">
        <a href="../Logout.php">Logout<i class="uil uil-signout"></i></a>
      </div>
    </nav>
    <div class="container_1">
      <div class="disp">
      <h1>AMOUNT / <?php echo$customer_showdata['customer_name'];?></h1>
      </div>

    <!------------------------- display message for add edit customer ------------------- -->
    <?php if(isset($_GET['message']) && $_GET["message"] === "0"):?>
            <em style="color: #fff; background-color:red; text-align:center; padding:5px 40%;">Sorry server error contact Admin</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "1"):?>
            <em style="color: #fff; background-color:green; text-align:center; padding:5px 41.7%;">Record added successfully</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "1.1"):?>
            <em style="color: #fff; background-color:green; text-align:center; padding:5px 41.8%;">Record edited successfully</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "1.2"):?>
            <em style="color: #fff; background-color:green; text-align:center; padding:5px 41.3%;">Record deleted successfully</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "3"):?>
            <em style="color: #fff; background-color:red; text-align:center; padding:5px 38.5%;">Not successfully, some field not filled </em>            
            <?php endif;?>

      <div class="tables">
        <!-- -------------- customer details--------- -->
        <div class="details">
         <!-- ----------------- openform ------------- -->
        <a href="#" class="btn" onclick="open_update_form()"><i class="uil uil-plus-circle"></i></i>Update</a>
          <h3 class="phone">Phone No: 0<?php echo$customer_showdata['phone_no'];?></h3>
          <h3 >Amount: <?php echo number_format($customer_showdata['fund_amount']);?>/=</h3>
          <h3 class="t-amount">Rate in parcentage: 30%</h3>
        </div>

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th class="date">Date</th>
              <th class="amount">Loan amount</th> 
              <th>Added loan</th>  
              <th>Total Returned</th> 
              <th>Rate</th> 
              <th>actions</th>             
            </tr>
          </thead>
          <tbody>
            <?php 
              // Initialize a variable
              $counter = 0;
            while($amount_detail = mysqli_fetch_assoc($result1)){ 

              // Increment the variable
              $counter++;
              ?>
              <tr>
              <td><?php echo $counter; ?></td>
              <td class="date"><?php echo $amount_detail['amount_date']; ?></td>
              <td class="loan_amount"><?php echo number_format($amount_detail['loan_amount']);?>/=</td>
              <td class="added_loan"><?php echo number_format($amount_detail['added_loan']);?>/=</td>
              <td><?php echo number_format($amount_detail['total_interest']);?>/=</td>
              <td><?php echo number_format($amount_detail['rate']);?>/=</td>
              <td><b>   
                <!-- <a href="edit_customer_view.php" class="edit" onclick="open_edit_form()"><i class="uil uil-edit-alt"></i>Edit</a> -->
                <a href="edit_customer_preview.php?ca_editid=<?php echo $amount_detail['amount_id'];?>" class="edit"><i class="uil uil-edit-alt"></i>Edit</a>
                <a href="update_customer_preview.php?dropid=<?php echo $amount_detail['amount_id'];?>" class="delete"><i class="uil uil-trash-alt"></i>Delete</a>
               </b></td>
               </tr>
             <?php };?>
          </tbody>
        </table>
        <!-- ------------------ PAGINATION ---------------------- -->
        <div class="pagination">
          <a href="#">&laquo;</a>
          <a class="active" href="preview.php?viewid=<?php echo $viewid;?>">1</a>
          <a href="preview.php?viewid=<?php echo $viewid;?>&page_no=2">2</a>
          <a href="preview.php?viewid=<?php echo $viewid;?>&page_no=3">3</a>
          <a href="preview.php?viewid=<?php echo $viewid;?>&page_no=4">4</a>
          <a href="preview.php?viewid=<?php echo $viewid;?>&page_no=5">5</a>
          <a href="#">&raquo;</a>
        </div>
      </div>
    </div>    
  </div>

    <!-- -------------------------- update-Customer Form ----------------------- -->
    <div class="update-customer" id="update-customer-form">
    <div class="customer-form">
      <!-- ---------- close form --------- -->
    <h1>Update customer</h1><span><i class="uil uil-times-square" onclick="close_update_form()" id="update-times-square"></i><i class="uil uil-times" id="update-times"></i></span>
    <!-- <i class="uil uil-times-square"></i> -->
      <form action="update_customer_preview.php" method="post">
        <label for="name">Customer</label>
        <input type="text" name="name" value="<?php echo $customer_showdata['customer_name'];?>" placeholder="Customer Full name" >

        <label for="amount_date">Issued date</label>
        <input type="date" name="amount_date" placeholder="Issued date">

        <label for="added_loan">added loan</label>
        <input type="text" name="added_loan" placeholder="added_loan">

        <button type="submit" >Save<i class="uil uil-message"></i></button>
      </form>
    </div>
  </div>

    <!-- -------------------------- edit-Customer Form ----------------------- -->
    <div class="edit-customer" id="edit-customer-form">
    <div class="customer-form">
       <!-- ---------- close form --------- -->
       <h1>Edit customer</h1><span><a href="preview.php?viewid=<?php echo $customer_id?>"><i class="uil uil-times-square" id="edit-times-square"></i></a><i class="uil uil-times" id="edit-times"></i></span>
    <!-- <i class="uil uil-times-square"></i> -->
      <form action="edit_customer_preview.php" method="post">
        <label for="amount_date">Issued date</label>
        <input type="date" name="amount_date" value="<?php echo$customer_dc_detail['amount_date'];?>" placeholder="Issued date">

        <label for="added_loan">Added loan</label>
        <input type="text" name="added_loan" value="<?php echo$customer_dc_detail['added_loan'];?>" placeholder="added loan">
        
        <input type="text" name="edit_ca" value="<?php echo$customer_dc_detail['dc_id'];?>" hidden>
        <button type="submit">Save<i class="uil uil-message"></i></button>
      </form>
    </div>

   <script src="preview.js"></script>
 </body>
</html>
