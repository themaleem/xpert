<?php
    require_once './utils/functions.php';
    require_once 'models/packageModel.php';
    require_once 'models/eventModel.php';
    require_once './classes/event.php';
    require_once './utils/db.php';

    if (!isset($_GET['id'])) {
        die("Illegal request");
    }

    $id = $_GET['id'];

    $connection = DB::getConnection();
    $packageModel = new PackageModel($connection);
    $package = $packageModel->getPackageById($id);


    // define variables and initialize with empty values
    $title = $cost = $venue = $description =$date = "";
    $title_err = $cost_err = $venue_err = $description_err = $date_err= "";

    // check if the form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // validate title
        if(empty(trim($_POST["title"]))){
            $title_err = "Please enter your title.";
        } else{
            $title = trim($_POST["title"]);
        }

        // Validate cost
        if(empty(trim($_POST["cost"]))){
            $cost_err = "Please enter your cost.";
        } else{
            $cost = trim($_POST["cost"]);
        }
        
        // validate event type
        if(empty(trim($_POST["venue"]))){
            $venue_err = "Please enter your Event Type.";
        } else{
            $venue = trim($_POST["venue"]);
        }

        // validate description
        if(empty(trim($_POST["description"]))){
            $description_err = "Please enter your description.";
        } else{
            $description = trim($_POST["description"]);
        }
        
        
        // if there are no validation errors, insert the user data into database
        if(empty($title_err) && empty($cost_err) && empty($venue_err) && empty($description_err)){


            $conn = DB::getConnection();
            $eventModel= new EventModel($conn);

            $event = new Event(null, $title, $description, $venue, $date, $id, $cost, $client_id, $staff_id);
            $id = $eventModel->createEvent($event);
            $event->setId($id);
        
            header("Location: ./index.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Packing  - Expert Events</title>
  <link rel="stylesheet" type="text/css" href="package.css">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
  <!-- Navigation bar -->
  <?php include './includes/header.php';?>

  <!-- Packages section -->
  <section class="packages">
  <?php
      // Get the package details
      $id = $package->getId();
      $name = $package->getName();
      $price = $package->getPrice();
      $event_type = $package->getEventType();
      $description = $package->getDescription();

      // Display the package details
      echo "<div class='package'>";
      echo "<img src='https://images.unsplash.com/photo-1602631985686-1bb0e6a8696e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80' alt=$name>";
      echo "<h2>$name</h2>";
      echo "<p>$description</p>";
      echo "<ul>";
      // foreach ($package->getItems() as $item) {
      //   echo "<li>$item</li>";
      // }
      echo "</ul>";
      echo "<p class='price'>Price: $$price</p>";
      echo "</div>";
  ?>
  </section>

  <div class="form-container">
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>Create Event for Package <?php $id ?></h3>


      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required>
      <span><?php echo $title_err; ?></span>
      
      <label for="description">Description:</label>
      <input type="input" name="description" required></input>
      <span><?php echo $description_err; ?></span>
      
      <br>
      <label for="venue">Venue:</label>
      <input type="input" id="venue" name="venue" required>
      <span><?php echo $venue_err; ?></span>
      
      <label for="date">Date:</label>
      <input type="text" id="date" name="date" required>
      <span><?php echo $date_err; ?></span>
      
      <label for="cost">Cost:</label>
      <input type="number" id="cost" name="cost" required>
      <span><?php echo $cost_err; ?></span>
      
      <input type="submit" name="submit" value="Book Package" class="form-btn">
      <p> &nbsp;<a href="/packages.php">back to packages</a></p>
   </form>
   

</div>


  <!-- Footer -->
  <?php include './includes/footer.php'; ?>
</body>
</html>