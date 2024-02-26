<?php
 include("../DB-connection/connect_php.php");

 
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $user_email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $c_password = $_POST["cpassword"];


    // Perform basic validation (you can add more complex validation here)
    if (empty($username) || empty($password) || empty($user_email) || is_numeric($username)) {
        die("Please fill in all fields and dont use namber in username"); 

    } else {
 
        if($_POST['password'] !== $_POST['cpassword']){
           die("confirm well your password");     
        } 

      // Validate if user has already exist
        $sql = "SELECT * FROM user WHERE user_email = '$user_email' limit 1";
        $result = $conn->query($sql);
      //If the cridential are valid jump to inside page
        if ($result->num_rows > 0) {
         $user_data = $result->fetch_assoc();
           if ($user_data['user_email'] === $user_email)
           {
            die("User has already exist");
           } 
        } 

        //encrypt password
        $confirm_password = password_hash($c_password, PASSWORD_DEFAULT);

        // Insert data into the database table
        $sql_insert = "INSERT INTO user (user_name,user_email,user_password) VALUES (?, ?, ?)";
        //initiate statement
        $stmt = $conn->stmt_init();

        //prepare and chake statement
        if (!$stmt->prepare($sql_insert)) {
          die("SQL error ". $conn->error);   
        } 
        // Bind the user input to the placeholder
        $stmt->bind_param("sss",$username,$user_email,$confirm_password);
        // Execute the statement
        $stmt->execute();
            //echo "User registered successfully.";
            header("Location: ../index.php");        
      } 
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../login_styles.css">
</head>
<body>
    <div class="login-container">
          <!-- ---------------LOGO------------------ -->
      <div class="outer-box">
         <h3 class="trusted">TRUSTED</h3>
        <span class="fund-foundation">
          <h3 class="fund">FUND</h3>
          <h3 class="foundation">FOUNDATION</h3>
        </span>
      </div>
        <form method="POST">

            <label for="email">email</label>
            <input type="email" id="email" name="email" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="password">Confirm Password</label>
            <input type="password" id="cpassword" name="cpassword" required>


            <button type="submit">Signup</button>
        </form>
    </div>
    <!-- <script src="login_js.js"></script> -->
</body>
</html>
