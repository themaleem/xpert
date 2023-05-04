<?php
   require_once '../../utils/db.php';
   require_once '../../utils/functions.php';
   require_once '../../classes/client.php';
   require_once '../../gateways/clientGateway.php';

redirect_if_logged_in();
   // define variables and initialize with empty values
   $name = $email = $password = $confirm_password = "";
   $name_err = $email_err = $password_err = $confirm_password_err = $phone_number_err= $address_err= "";

   // check if the form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){

      // validate name
      if(empty(trim($_POST["name"]))){
         $name_err = "Please enter your name.";
      } else{
         $name = trim($_POST["name"]);
      }

      // Validate email
      if (empty(trim($_POST['email']))) {
      $email_err = 'Please enter an email address.';
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
         $email_err = 'Please enter a valid email address.';
      } else {
         $email = trim($_POST['email']);
         $conn = DB::getConnection();

         $clientTable= new ClientTable($conn);
         $client = $clientTable->checkEmailExist($email);

         if ($client) {
            $email_err = "Email already registered";}
      }

      if(empty(trim($_POST["phone_number"]))){
         $phone_number_err = "Please enter your phone_number.";
      } else{
         $phone_number = trim($_POST["phone_number"]);
      }

      if(empty(trim($_POST["address"]))){
         $address_err = "Please enter your address.";
      } else{
         $address = trim($_POST["address"]);
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


         $conn = DB::getConnection();
         

         $clientTable= new ClientTable($conn);

         $client = new Client(null, $name, $email, $address, $phone_number, $password);
         $id = $clientTable->insert($client);
         $client->setId($id);

         // set global session user
         $_SESSION['user'] = $client; 
         $_SESSION['role'] = get_class($client); 
      
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
   <link rel="stylesheet" href="../css/../../css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>Client registration</h3>

      <input type="text" name="name"  placeholder="enter your name">
      <span><?php echo $name_err; ?></span>

      <input type="email" name="email"  placeholder="enter your email">
      <span><?php echo $email_err; ?></span>

      
      <input type="text" name="phone_number"  placeholder="phone number">
      <span><?php echo $phone_number_err; ?></span>

      <input type="text" name="address"  placeholder="address">
      <span><?php echo $address_err; ?></span>

      <input type="password" name="password"  placeholder="enter your password">
      <span><?php echo $password_err; ?></span>

      <input type="password" name="confirm_password"  placeholder="confirm your password">
      <span><?php echo $confirm_password_err; ?></span>
   
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login.php">login now</a><br/>&nbsp;<a href="../../index.php">back home</a></p>
   </form>

</div>

</body>
</html>