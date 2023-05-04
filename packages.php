<?php
  require_once './utils/functions.php';
  require_once 'models/packageModel.php';
  require_once './utils/db.php';

  start_session();
  $connection = DB::getConnection();
  $packageModel = new PackageModel($connection);

  $packages = $packageModel->getPackages();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Packages - Expert Events</title>
  <link rel="stylesheet" type="text/css" href="package.css">
</head>
<body>
  <!-- Navigation bar -->
  <?php include './includes/header.php';?>

  <!-- Hero section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Packages</h1>
      <p>Choose the package that best suits your needs.</p>
    </div>
  </section>

  <?php is_admin() ? '<a href="/create_package.php">create package</a>' : ''; ?>
  

  <!-- Packages section -->
  <section class="packages">
  <?php
    foreach ($packages as $package) {
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
      echo "<p class='price'>Price: $ $price</p>";
      echo "<a href='/package_booking.php?id=$id' class='button'>Book Package</a>";
      echo "</div>";
    }
  ?>
  </section>

  <!-- Footer -->
  <?php include './includes/footer.php'; ?>
</body>
</html>