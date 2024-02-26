<?php

// ---------------- SESSION FUNCTION ----------------------------
function check_login($conn)
{
	$id = $_SESSION['user_id'];

	if(isset($_SESSION['user_id'])){

		$id = $_SESSION['user_id'];

		$query = "SELECT * FROM user WHERE user_id = '$id' limit 1";

		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0)
		{
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}
	//redirect to login page
	header('Location: ../../login.php');
	die;
}


//PHP for search 
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
	$query = "SELECT customer.customer_id, customer.customer_name, customer.phone_no, customer.customer_date, customer.fund_amount, customer.return_amount, SUM(date_cush.dc_return_amount) AS total_return_amount, date_cush.dc_return_amount FROM date_cush RIGHT JOIN customer ON customer.customer_id = date_cush.customer_id WHERE customer.customer_name = '$searchQuery' limit 1;";
    $result = mysqli_query($conn, $query);
	$resultsearch = $result;
	return $resultsearch;
}
else{
	//php pagination and display from database
	if(isset($_GET['page_no'])){
		$page_number = $_GET["page_no"];
	}
	else{
		$page_number = 1;
	}
	$limit = 4;
		// get the initial page number
		$initial_page = ($page_number-1) * $limit; 

		// $query = "SELECT * FROM customer ORDER BY `customer_name` ASC LIMIT $initial_page,$limit";
		$query = "SELECT customer.customer_id, customer.customer_name, customer.phone_no, customer.customer_date, customer.fund_amount, customer.return_amount, SUM(date_cush.dc_return_amount) AS total_return_amount, date_cush.dc_return_amount FROM date_cush RIGHT JOIN customer ON customer.customer_id = date_cush.customer_id GROUP BY customer_id ORDER BY `customer_name` ASC LIMIT $initial_page,$limit";
		$result = mysqli_query($conn, $query);
		$resultsearch = $result;

//PHP for delete
if (isset($_GET['deleteid'])) {
    $deleteQuery = $_GET['deleteid'];

	//query to select data and return customer id
	$query = "SELECT * FROM customer WHERE customer_id = '$deleteQuery' limit 1";
	$result = mysqli_query($conn, $query);
	if($result && mysqli_num_rows($result) > 0)
	{
		$customer_data = mysqli_fetch_assoc($result);
		$customer_id = $customer_data['customer_id'];
		$sql_delete = "DELETE FROM customer WHERE `customer`.`customer_id` = $customer_id";
		if ($conn->query($sql_delete) === TRUE) {
			//to return $resultsearch dashboard page after delete
			$query = "SELECT * FROM customer ORDER BY `customer_name` ASC";
			$result = mysqli_query($conn, $query);
			$resultsearch = $result;
			return $resultsearch;
			die;
          }
		  echo "Error table not droped: " . $conn->error;	
	}
}
// echo "There is no delete ID.";
return $resultsearch;
}
die("No database");
?>