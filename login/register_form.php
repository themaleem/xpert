<?php
   require '../utils/functions.php';
   redirect_admin_or_user();

   require_once 'db.php';
   // define variables and initialize with empty values
   $name = $email = $password = $confirm_password = "";
   $name_err = $email_err = $password_err = $confirm_password_err = "";

   // check if the form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){

      // validate name
      if(empty(trim($_POST["username"]))){
         $name_err = "Please enter your name.";
      } else{
         $name = trim($_POST["username"]);
      }

   

      // Validate email
      if (empty(trim($_POST['email']))) {
      $email_err = 'Please enter an email address.';
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
         $email_err = 'Please enter a valid email address.';
      } else {
         // Check if email already exists in the database
         $conn = DB::getConnection();
         $email = trim($_POST['email']);
         $sql = 'SELECT id FROM users WHERE email = ?';
         $stmt = $conn->prepare($sql);
         $stmt->bind_param('s', $email);
         $stmt->execute();
         $result = $stmt->get_result();
         // Check if there is a user with the given email and password
      if ($result->num_rows == 1) {
         $email_err = 'This email is already taken.';
      }
      $stmt->close();
   

      }
      // validate password
      if(empty(trim($_POST["password"]))){
         $password_err = "Please enter a password.";     
      } elseif(strlen(trim($_POST["password"])) < 6){
         $password_err = "Password must have at least 6 characters.";
      } else{
         $password = trim($_POST["password"]);
      }

      // validate confirm password
      if(empty(trim($_POST["confirm_password"]))){
         $confirm_password_err = "Please confirm password.";     
      } else{
         $confirm_password = trim($_POST["confirm_password"]);
         if(empty($password_err) && ($password != $confirm_password)){
               $confirm_password_err = "Password did not match.";
         }
      }
      
      // if there are no validation errors, insert the user data into database
      if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

         // create a database connection
         $conn = DB::getConnection();
         
         // prepare a SQL insert statement to insert the user data into the database
         $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

         // prepare the statement
         $stmt = mysqli_prepare($conn, $sql);

         // bind the parameters to the statement
         mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

         // execute the statement
         mysqli_stmt_execute($stmt);

         // close the statement and connection
         mysqli_stmt_close($stmt);
         mysqli_close($conn);

         // redirect the user to the login page
         header("location: login.php");
         exit();
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>register now</h3>

      <input type="text" name="username" required placeholder="enter your name">
      <span><?php echo $name_err; ?></span>

      <input type="email" name="email" required placeholder="enter your email">
      <span><?php echo $email_err; ?></span>

      <input type="password" name="password" required placeholder="enter your password">
      <span><?php echo $password_err; ?></span>

      <input type="password" name="confirm_password" required placeholder="confirm your password">
      <span><?php echo $confirm_password_err; ?></span>
   
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>

</div>

</body>
</html>