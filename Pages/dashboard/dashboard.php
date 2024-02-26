<?php
session_start();
 
  include("../../DB-connection/connect_php.php");
  include("../function_log.php");

 $user_data = check_login($conn);


?>


<!DOCTYPE html>
<html>
 <head>
	<title>Dashboard page</title>
  <link rel="stylesheet" href="dashboard.css">
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
      <!---------------- user details ------------------ -->
      <h3>Welcome <b>[ <?php echo $user_data['user_name'];?> ]</b></h3> 
    </div>
    <nav>
      <div class="menu-list">
        <ul>
          <li><a href="#"><i class="uil uil-estate"></i>Home</a></li>
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
      <h1>DASHBOARD</h1>
      </div>
      
    <!------------------------- display message for add edit customer ------------------- -->
    <?php if(isset($_GET['message']) && $_GET["message"] === "0"):?>
            <em style="color: #fff; background-color:red; text-align:center; padding:5px 40%;">Sorry server error contact Admin</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "1"):?>
            <em style="color: #fff; background-color:green; text-align:center; padding:5px 41.1%;">customer added successfully</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "1.1"):?>
            <em style="color: #fff; background-color:green; text-align:center; padding:5px 41.1%;">customer edited successfully</em>
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "2"):?>
            <em style="color: #fff; background-color:red; text-align:center; padding:5px 43.1%;">customer already exist</em>  
            <?php elseif(isset($_GET['message']) && $_GET["message"] === "3"):?>
            <em style="color: #fff; background-color:red; text-align:center; padding:5px 38.8%;">Not successfully, some field not filled </em>            
            <?php endif;?>

      <div class="tables">     
        <!-- ------ search ---------- -->
        <div class="search">
          <form method="POST">
            <input type="text"  name="search" placeholder="Search...">
            <button type="submit" id="search"><i class="uil uil-search-alt"></i></button>
          </form>
        </div>
        <!-- ---- openform --- -->
        <a href="#" class="btn" onclick="open_add_form()"><i class="uil uil-plus-circle"></i>Add Customer</a>

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th class="name">Name</th>
              <th class="amount">Loan Amount</th> 
              <th>Date</th>  
              <th>actions</th>             
            </tr>
          </thead>
          <tbody>
            <?php 
              // Initialize a variable
              $counter = 0;
            while($form_data = mysqli_fetch_assoc($resultsearch)){ 

              // Increment the variable
              $counter++;
              ?>
              <tr>
              <td><?php echo $counter; ?></td>
              <td class="name"><?php echo $form_data['customer_name']; ?></td>
              <td class="amount"><?php echo number_format($form_data['fund_amount']);?>/=</td>
              <td class="date"><?php echo $form_data['customer_date'];?></td>
              <td><b>
                <a href="../view/view.php?viewid=<?php echo$form_data['customer_id']?>" class="view"><i class="uil uil-eye"></i>View</a>
                <a href="edit_customer_dashboard.php?editid=<?php echo$form_data['customer_id']?>" class="edit"><i class="uil uil-edit-alt"></i>Edit</a>
                <a href="dashboard.php?deleteid=<?php echo$form_data['customer_id']?>" class="delete"><i class="uil uil-trash-alt"></i>Delete</a>
               </b></td>
            </tr>
             <?php };?>
          </tbody>
        </table>
       <!-- ------------------ PAGINATION ---------------------- -->
        <div class="pagination">
          <a href="#">&laquo;</a>
          <a class="active" href="dashboard.php">1</a>
          <a href="dashboard.php?page_no=2">2</a>
          <a href="dashboard.php?page_no=3">3</a>
          <a href="dashboard.php?page_no=4">4</a>
          <a href="dashboard.php?page_no=5">5</a>
          <a href="#">&raquo;</a>
        </div>
      </div>
    </div>    
  </div>
  <!-- -------------------------- Add-Customer Form ----------------------- -->
  <div class="add-customer" id="add-customer-form">
    <div class="customer-form">
      <!-- ---------- close form --------- -->
    <h1>New customer</h1><span><i class="uil uil-times-square"onclick=" close_add_form()" id="add-times-square"></i><i class="uil uil-times" id="add-times"></i></span>
    <!-- <i class="uil uil-times-square"></i> -->
      <form action="add_customer_dashboard.php" method="post">
        <label for="name">Customer</label>
        <input type="text" name="name" placeholder="Customer Full name">

        <label for="phone_no">Phone No:</label>
        <input type="text" name="phone_no" placeholder="Customer Phone number">

        <label for="amount">Funded Amount</label>
        <input type="text" name="amount" placeholder="Customer fund amount">

        <label for="date">Dete</label>
        <input type="date" name="date" placeholder="Issued date">

        <label for="returned_amount">Returned Fund</label>
        <input type="text" name="returned_amount" placeholder="customer returned fund">

        <button type="submit" name="add">Save<i class="uil uil-message"></i></button>
      </form>
    </div>
  </div>

    <!-- -------------------------- Edit-Customer Form ----------------------- -->
    <div class="edit-customer" id="edit-customer-form">
    <div class="customer-form">
      <!-- ---------- close form --------- -->
    <h1>Edit customer</h1><span><i class="uil uil-times-square"onclick=" close_edit_form()" id="edit-times-square"></i><i class="uil uil-times" id="edit-times"></i></span>
    <!-- <i class="uil uil-times-square"></i> -->
      <form action="#">
        <label for="name">Customer</label>
        <input type="text" name="name" placeholder="Customer Full name">

        <label for="phone-no">Phone No:</label>
        <input type="text" id="phone-no" placeholder="Customer Phone number">

        <label for="amount">Funded Amount</label>
        <input type="text" id="amount" placeholder="Customer fund amount">

        <label for="date">Dete</label>
        <input type="date" name="date" placeholder="Issued date">

        <label for="returned_amount">Returned Fund</label>
        <input type="text" name="returned_amount" placeholder="customer returned fund">

        <input type="text" name="edit" value= >

        <button type="submit">Save<i class="uil uil-message"></i></button>
      </form>
    </div>
  </div>

   <script src="dashboard.js"></script>
 </body>
</html>
