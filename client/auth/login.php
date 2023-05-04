<?php
   require_once('../../utils/functions.php');
   require_once ('../../utils/db.php');
   require_once ('../../models/clientModel.php');
   
   redirect_if_logged_in();

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
         // $password = md5($_POST["password"]);
         $password = $_POST["password"];
      }

      // Connect to the database
      $conn = DB::getConnection();

      $clientModel = new ClientModel($conn);
      $client =  $clientModel->getClientByEmailAndPassword($email, $password); 
      

   

      // Check if there is a user with the given email and password
      if ($client) {
      
         $class_name = get_class($client);
         // Save the user object in the session
         $_SESSION['user'] = $client;
         $_SESSION['role'] = $class_name;

         header("Location: ../index.php");

         exit();
      } else {
         // Display an error message
         $form_err = "Invalid email or password.";
      }

      // Close the statement and the connection
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
   <link rel="stylesheet" href="../css/../../css/style.css">

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

      <p>don't have an account? <a href="register.php">register now</a> <br><a href="../../index.php">back home</p>
   </form>

</div>

</body>
</html>