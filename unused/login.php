<?php


require_once 'DB.php';
// require_once 'utils/functions.php';

// Start the session
session_start();
 echo session_id();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the form data
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    // Connect to the database
    $conn = DB::getConnection();
    

    // // Check for errors
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

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
        echo "Invalid email or password.";
        // header("Location: login_form.php");
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();

}
?>
