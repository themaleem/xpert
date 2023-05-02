<?php
   require '../utils/functions.php';
   require_once 'DB.php';
   
   redirect_admin_or_user();

   $email = $password = "";
   $email_err = $password_err = $form_err = "";

   // Check if the form was submitted
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // define variables and initialize with empty values
   
      // Get the form data
      // validate email
      if(empty(trim($_POST["email"]))){
         $email_err = "Please enter your email.";
      } else{
         $email = trim($_POST["email"]);
      }
      
      // validate password
      if(empty(trim($_POST["password"]))){
         $password_err = "Please enter a password.";     
      } else{
         $password = md5($_POST["password"]);
      }

      // Connect to the database
      $conn = DB::getConnection();
      

      // Prepare the SQL statement
      $stmt = $conn->prepare("SELECT u.*, r.name as role_name
                              FROM users u
                              JOIN roles r ON u.role_id = r.id
                              WHERE email=? AND password=?");

      // Bind the parameters
      $stmt->bind_param("ss", $email, $password);

      // Execute the query
      $stmt->execute();

      // Get the result
      $result = $stmt->get_result();

      // Check if there is a user with the given email and password
      if ($result->num_rows == 1) {

         // Fetch the user object
         $user = $result->fetch_object();
         $role_name = $user->role_name;

         // Save the user object in the session
         $_SESSION['user'] = $user;
         $_SESSION['role'] = $role_name;
         

         if ($role_name ==='admin' || $role_name ==='account'){    
               header("Location: admin_page.php");
         } else {
               header("Location: user_page.php");
         }

         exit();
      } else {
         // Display an error message
         $form_err = "Invalid email or password.";
      }

      // Close the statement and the connection
      $stmt->close();
      $conn->close();

   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>login now</h3>
    
      <input type="email" name="email" required placeholder="enter your email">
      <span><?php echo $email_err; ?></span>

      <input type="password" name="password" required placeholder="enter your password">
      <span><?php echo $password_err; ?></span>

      <input type="submit" name="submit" value="login now" class="form-btn">
      <span><?php echo $form_err; ?></span>

      <p>don't have an account? <a href="register_form.php">register now</a></p>
   </form>

</div>

</body>
</html>