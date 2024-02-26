<?php
session_start();
 
  include("../../DB-connection/connect_php.php");
  include("../function_log.php");

 $user_data = check_login($conn);

 // get edit_dc by post methord  
 if(isset($_POST['edit_dc']) && $_SERVER["REQUEST_METHOD"] === "POST"){
  $dc_editid = $_POST['edit_dc'];
  $dc_date = $_POST['date'];
  $dc_return = $_POST['returned_amount'];
 
    //select query and pass viewid 
    $sql_customer = "SELECT * FROM date_cush WHERE  dc_id = $dc_editid limit 1";
    $result = mysqli_query($conn, $sql_customer);
    $customer_detail = mysqli_fetch_assoc($result);
    $viewid = $customer_detail['customer_id'];
    // Perform basic validation (you can add more complex validation here)
      if (empty($dc_date) || empty($dc_return)) {
        // redirect to customer page with server one field not filled and customer id
        header("Location: view.php?viewid=$viewid&message=3");
        exit;
      }
        // Insert data into the database table
          $converted_date = date("Y-m-d", strtotime($dc_date));// Convert from "mm/dd/yyyy" to "yyyy-mm-dd"
          $sql_update = "UPDATE date_cush
                  SET dc_date = '$converted_date',dc_return_amount = $dc_return WHERE dc_id = $dc_editid";
          $result_update = mysqli_query($conn,$sql_update);
            //check if cquery result is true
            if ($result_update === TRUE) {
              // redirect to customer page with edit successfully message
              header("Location: view.php?viewid=$viewid&message=1.1");
              exit();
            }
 }
 
 $dc_editid = $_GET['dc_editid']; 
//  echo "my id $dc_editid";
//  die;
 $sql_customer = "SELECT * FROM date_cush WHERE `date_cush`.`dc_id` = $dc_editid";
 $result = mysqli_query($conn, $sql_customer);
 $customer_dc_detail = mysqli_fetch_assoc($result);
 $customer_id = $customer_dc_detail['customer_id'];

 $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id' limit 1";
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
  $sql_customer = "SELECT * FROM date_cush WHERE `date_cush`.`customer_id` = $customer_id ORDER BY `date_cush`.`dc_date` DESC LIMIT $initial_page,$limit";
  $result_detail = mysqli_query($conn, $sql_customer);

//query to give result at the return_amount
$sql_sum = "SELECT SUM(dc_return_amount) AS total_return_amount FROM date_cush 
              WHERE `date_cush`.`customer_id`= $customer_id";
 $result_total = mysqli_query($conn, $sql_sum);
 $total_data = mysqli_fetch_assoc($result_total);
?>


<!DOCTYPE html>
<html>
 <head>
	<title>Customer page</title>
  <link rel="stylesheet" href="view.css">
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
          <li><a href="#"><i class="uil uil-usd-circle"></i>Amount</a></li>
          <li><a href="#"><i class="uil uil-file-alt"></i>Report</a></li>
        </ul>
      </div>
      <div class="log-out">
        <a href="../Logout.php">Logout<i class="uil uil-signout"></i></a>
      </div>
    </nav>
    <div class="container_1">
      <div class="disp">
      <h1>CUSTOMERS / <?php echo$customer_showdata['customer_name'];?></h1>
      </div>
      
      <div class="tables">
        <!-- -------------- customer details--------- -->
        <div class="details">
                          <!-- -------------- openform ---------- -->
        <a href="#" class="btn" onclick="open_update_form()"><i class="uil uil-plus-circle"></i></i>Update</a>
          <h3 class="phone">Phone No: 0<?php echo$customer_showdata['phone_no'];?></h3>
          <h3 >Amount: <?php echo number_format($customer_showdata['fund_amount']);?>/=</h3>
          <h3 class="t-amount">Total Amount: <?php echo number_format($total_data['total_return_amount']);?>/=</h3>
        </div>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th class="date">Date</th>
              <th class="amount">Amount Returned</th> 
              <th>status</th>  
              <th>actions</th>             
            </tr>
          </thead>
          <tbody>
            <?php 
              // Initialize a variable
              $counter = 0;
            while($customer_detail = mysqli_fetch_assoc($result_detail)){ 

              // Increment the variable
              $counter++;
              ?>
              <tr>
              <td><?php echo $counter; ?></td>
              <td class="date"><?php echo $customer_detail['dc_date']; ?></td>
              <td class="amount"><?php echo number_format($customer_detail['dc_return_amount']);?>/=</td>
              <td>active</td>
              <td><b>
                <a href="#" class="edit" onclick="open_edit_form()"><i class="uil uil-edit-alt"></i>Edit</a>
                <a href="update_customer_view.php?dropid=<?php echo $customer_detail['dc_id'];?>" class="delete"><i class="uil uil-trash-alt"></i>Delete</a>
               </b></td>
               </tr>
             <?php };?>
          </tbody>
        </table>
        <!-- ------------------ PAGINATION ---------------------- -->
        <div class="pagination">
          <a href="#">&laquo;</a>
          <a class="active" href="dashboard.php">1</a>
          <a href="edit_customer_view.php?page_no=2">2</a>
          <a href="edit_customer_view.php?page_no=3">3</a>
          <a href="edit_customer_view.php?page_no=4">4</a>
          <a href="edit_customer_view.php?page_no=5">5</a>
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
      <form action="update_customer_view.php" method="post">
        <label for="name">Customer</label>
        <input type="text" name="name" placeholder="Customer Full name" >

        <label for="date">Dete</label>
        <input type="date" name="date" placeholder="Issued date">

        <label for="returned_amount">Returned Fund</label>
        <input type="text" name="returned_amount" placeholder="customer returned fund">

        <button type="submit" >Save<i class="uil uil-message"></i></button>
      </form>
    </div>
  </div>
      <!-- -------------------------- edit-Customer Form ----------------------- -->
      <div class="edit-customer" id="edit-customer-form" style="z-index: 3;">
    <div class="customer-form">
      <!-- ---------- close form --------- -->
    <h1>Edit customer</h1><span><a href="view.php?viewid=<?php echo $customer_id?>"><i class="uil uil-times-square" id="edit-times-square"></i></a><i class="uil uil-times" id="edit-times"></i></span>
    <!-- <i class="uil uil-times-square"></i> -->
      <form action="edit_customer_view.php" method="post">
        <label for="date">Dete</label>
        <input type="date" name="date" value="<?php echo$customer_dc_detail['dc_date'];?>" placeholder="Issued date">

        <label for="returned_amount">Returned Fund</label>
        <input type="text" name="returned_amount" value="<?php echo$customer_dc_detail['dc_return_amount'];?>" placeholder="customer returned fund">
        
        <input type="text" name="edit_dc" value="<?php echo$customer_dc_detail['dc_id'];?>" hidden>
        <button type="submit">Save<i class="uil uil-message"></i></button>
      </form>
    </div>
  </div>

   <script src="view.js"></script>
 </body>
</html>
