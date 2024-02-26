<?php
session_start();

 include("../../DB-connection/connect_php.php");
 include("../function_log.php");

 $user_data = check_login($conn);


 $editid = $_GET['editid']; 
 $sql = "SELECT * FROM customer WHERE customer_id = '$editid' limit 1";
 $result = mysqli_query($conn, $sql);
$customer_showdata = mysqli_fetch_assoc($result);


//  echo " bob $data";
//  die(" bob $editid");

// Check if the form is submitted
if (isset($_POST['submit_edit'])) {

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
        $sql = "SELECT * FROM customer WHERE customer_id = '$editid' limit 1";
        $result = mysqli_query($conn,$sql);
      //check if result is true 
        if ($result && mysqli_num_rows($result) > 0 ) {
         $customer_data = mysqli_fetch_assoc($result);
          //check if customer id exist
           if ($customer_data['customer_id'] == $editid)
           {
              // Insert data into the database table
              $converted_date = date("Y-m-d", strtotime($c_date)); // Convert to "yyyy/mm/dd"
              $customer_id = $customer_data['customer_id'];
              $sql = "UPDATE customer
                      SET customer_name = '$cust_name', phone_no = $cust_phone, fund_amount = $fund_amount, customer_date ='$converted_date',return_amount = $return_amount 
                      WHERE customer_id = '$customer_id'";
            //check if the query is true 
              if ($conn->query($sql) === TRUE) {
                // redirect to dashboad page with edit successfully message
                header("Location: dashboard.php?message=1.1");
                exit();
              } 
            // redirect to dashboad page with server error message
            header("Location: dashboard.php?message=0");
            exit;
           } 
        // redirect to dashboad page with server error message
        header("Location: dashboard.php?message=0");
        exit;
        }        
      // redirect to dashboad page with server error message
      header("Location: dashboard.php?message=0");
      exit;
   }
    $conn->close();

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
      <h1>DASHBOARD</h1>
      </div>
      
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
              <th class="amount">Amount</th> 
              <th>status</th>  
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
              <td class="amount"><?php echo number_format($form_data['fund_amount']); ?>/=</td>
              <td>active</td>
              <td><b>
                <a href="../view/view.php" class="view"><i class="uil uil-eye"></i>View</a>
                <a href="#" class="edit"onclick="open_edit_form()"><i class="uil uil-edit-alt"></i>Edit</a>
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
    <div class="edit-customer" id="edit-customer-form" style="z-index: 3;">
    <div class="customer-form">
      <!-- ---------- close form --------- -->
      <h1>Edit customer</h1><span><a href="dashboard.php"><i class="uil uil-times-square"  id="edit-times-square"></i></a><i class="uil uil-times" id="edit-times"></i></span>
    <!-- <i class="uil uil-times-square"></i> -->
      <form action="#" method="POST">
        <label for="name">Customer</label>
        <input type="text" name="name" value="<?php echo $customer_showdata['customer_name'];?>" placeholder="Customer Full name">

        <label for="phone_no">Phone No:</label>
        <input type="text" id="phone_no" name="phone_no" value="<?php echo $customer_showdata['phone_no'];?>" placeholder="Customer Phone number">

        <label for="amount">Funded Amount</label>
        <input type="text" id="amount" name="amount" value="<?php echo $customer_showdata['fund_amount'];?>" placeholder="Customer fund amount">

        <label for="date">Dete</label>
        <input type="date" name="date" value="<?php echo $customer_showdata['customer_date'];?>" placeholder="Issued date">

        <label for="returned_amount">Returned Fund</label>
        <input type="text" name="returned_amount" value="<?php echo $customer_showdata['return_amount'];?>" placeholder="customer returned fund">

        <button type="submit" name="submit_edit" >Save<i class="uil uil-message"></i></button>
      </form>
    </div>
  </div>

   <script>

//open and close form
function open_add_form() {
    document.getElementById("add-customer-form").style.zIndex = "3";
}

function close_add_form() {
    document.getElementById("add-customer-form").style.zIndex = "0";
}

function open_edit_form() {
    document.getElementById("edit-customer-form").style.zIndex = "3";
}

function close_edit_form() {
    window.location.href = "http://127.0.0.1/Login_Page/Pages/dashboard/dashboard.php";
    // document.getElementById("edit-customer-form").style.zIndex = "0";
}
//---------------------mouse effect on form ------------------------------
// Get the button element by its ID
var customeradd_add_tm = document.getElementById("add-times");
var customeradd_add_sqr = document.getElementById("add-times-square");
var customeradd_edit_tm = document.getElementById("edit-times");
var customeradd_edit_sqr = document.getElementById("edit-times-square");
// var customeredit = document.getElementById("edit-customer-form");

// --------------------- for add form -----------------------------------
// Add an event listener to change the cursor style to "pointer" when the mouse enters the button
customeradd_add_tm.addEventListener("mouseenter", function() {
    customeradd_add_tm.style.display = "none";
    customeradd_add_sqr.style.display = "block";
});

// Add an event listener to change the cursor style back to the default when the mouse leaves the button
customeradd_add_tm.addEventListener("mouseleave", function() {
    customeradd_add_tm.style.display = "block";
    customeradd_add_sqr.style.display = "none";
});

/// ---------------------- for edit form --------------------------------
// Add an event listener to change the cursor style to "pointer" when the mouse enters the button
customeradd_edit_tm.addEventListener("mouseenter", function() {
    customeradd_edit_tm.style.display = "none";
    customeradd_edit_sqr.style.display = "block";
});

// Add an event listener to change the cursor style back to the default when the mouse leaves the button
customeradd_edit_tm.addEventListener("mouseleave", function() {
    customeradd_edit_tm.style.display = "block";
    customeradd_edit_sqr.style.display = "none";
});

   </script>
 </body>
</html>