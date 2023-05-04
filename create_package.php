<?php
   require_once './utils/db.php';
   require_once './utils/functions.php';
   require_once './classes/package.php';
   require_once './models/packageModel.php';

   redirect_if_not_admin();

   $client_id = $_SESSION['user']->getId();

   // define variables and initialize with empty values
   $name = $price = $event_type = $description = "";
   $name_err = $price_err = $event_type_err = $description_err = "";

   // check if the form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){

      // validate name
      if(empty(trim($_POST["name"]))){
         $name_err = "Please enter your name.";
      } else{
         $name = trim($_POST["name"]);
      }

      // Validate price
      if(empty(trim($_POST["price"]))){
         $price_err = "Please enter your price.";
      } else{
         $price = trim($_POST["price"]);
      }
      
      // validate event type
      if(empty(trim($_POST["event_type"]))){
         $event_type_err = "Please enter your Event Type.";
      } else{
         $event_type = trim($_POST["event_type"]);
      }

      // validate description
      if(empty(trim($_POST["description"]))){
         $description_err = "Please enter your description.";
      } else{
         $description = trim($_POST["description"]);
      }
      
      
      // if there are no validation errors, insert the user data into database
      if(empty($name_err) && empty($price_err) && empty($event_type_err) && empty($description_err)){


         $conn = DB::getConnection();
         $packageModel= new PackageModel($conn);

         $package = new Package(null, $name, $price, $event_type, $description, $client_id);
         $id = $packageModel->createPackage($package);
         $package->setId($id);
      
         header("Location: ../packages.php");
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
      <h3>Create Package</h3>

      <input type="text" name="name"  placeholder="Enter package name">
      <span><?php echo $name_err; ?></span>

      <input type="number" name="price"  placeholder="package price">
      <span><?php echo $price_err; ?></span>

      <input type="text" name="event_type"  placeholder="Event Type eg Wedding, Coperate outing">
      <span><?php echo $event_type_err; ?></span>

      <input type="textarea" name="description"  placeholder="package description">
      <span><?php echo $description_err; ?></span>
   
      <input type="submit" name="submit" value="Create Package" class="form-btn">
      <p> &nbsp;<a href="/packages.php">back to packages</a></p>
   </form>

</div>

</body>
</html>