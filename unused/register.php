   <!-- // require_once 'db.php';

   // if(isset($_POST['submit'])){

   //    $conn = DB::getConnection();    

   //    // Get the values from the HTML form
   //    $username = $_POST['username'];
   //    $email = $_POST['email'];
   //    $password = md5($_POST['password']);
   //    $confirm_password = md5($_POST['confirm_password']);
      
   //    // sanitize the text inputs
   //    $username = mysqli_real_escape_string($conn, $username);
   //    $email = mysqli_real_escape_string($conn, $email);
      
      
   //    $select = " SELECT * FROM users WHERE email = '$email' && password = '$password' ";
   
   //    $result = mysqli_query($conn, $select);
   
   //    if(mysqli_num_rows($result) > 0){
   //       $error[] = 'user already exist!';
   //    } else {
   //       if ($password != $confirm_password){
   //          $error[] = 'password not matched!';
   //       } else {
   //          $insert = "INSERT INTO users(username, email, password) VALUES('$username','$email','$password')";
   //          mysqli_query($conn, $insert);
   //          header('location: login_form.php');
   //       }
   //    }
   // }; -->






<?php

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

      // validate email
      if(empty(trim($_POST["email"]))){
         $email_err = "Please enter your email.";
      } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
         $email_err = "Invalid email format.";
      } else{
         $email = trim($_POST["email"]);
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

         // your MySQL database credentials and connection details
         $servername = "localhost";
         $username = "your_username";
         $password = "your_password";
         $dbname = "your_database_name";

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
