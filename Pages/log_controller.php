<?php
session_start();

include("../DB-connection/connect_php.php");

$tokene = $_SESSION['csrf_token'];
$my_token = $_POST['password'];
// echo "$tokene . ";
// echo "  $my_token";
// die;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    // Get form data
    $user_email = $_POST["email"];
    $password = $_POST["password"];
    

    // Perform basic validation (you can add more complex validation here)
    if (empty($user_email) || empty($password) || is_numeric($user_email)) {
        header("Location: ../index.php?message=1");
        exit;
    } else {
 
         // Validate user credentials (and avoid SQL injection by prepare statement)
        $sql = sprintf("SELECT * FROM user WHERE user_email = '%s'",$conn->real_escape_string($user_email));
        $result = mysqli_query($conn, $sql);
        $user_data = mysqli_fetch_assoc($result);

      if ($user_data){
            if (password_verify($password,$user_data['user_password'])) {
            
           // redirect to dashboad page with user_id as session id
            $_SESSION['user_id'] = $user_data['user_id'];
            header("Location: dashboard/dashboard.php");
            exit;
            }
            header("Location: ../index.php?message=1");
            exit;
          } 
            header("Location: ../index.php?message=1");
            exit;
        }
        header("Location: ../index.php?message=1");
        exit;
}
header("Location: ../index.php?message=1");
exit;
$conn->close();