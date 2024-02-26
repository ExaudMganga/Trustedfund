<?php
// Generate a unique CSRF token
$token = uniqid();

// Store the token in the session to use it for verification later
session_start();
$_SESSION['csrf_token'] = $token;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="login_styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
    <form action="Pages/log_controller.php" method="POST">
        <!-- display login fail message -->
        <?php if(isset($_GET['message'])):?>
            <em style="color: #fff; background-color:red;text-align: center;padding:5px 0;">Invalid login</em>
        <?php endif;?>
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

        <label for="email">email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Signin<i class="uil uil-signout"></i></button> <!--<br><br> -->
        <!-- <a href="Sinup_html.php" style="margin-top: 12px">Signup</a> -->
    </form>
</div>
</body>
</html>