<?php
   require '../utils/functions.php';
   require '../classes/client.php';
   is_admin();

   var_dump($_SESSION['role'])
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<div class="container">

   <div class="content">
      <h3>hi, <span><?php echo $_SESSION['role'] ?></span></h3>
      <h1>welcome <span><?php echo $_SESSION['user']->getName() ?></span></h1>
      <p>this is an <?php echo $_SESSION['role'] ?> page</p>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>