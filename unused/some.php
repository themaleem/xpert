<?php
require_once 'config.php';
require_once 'functions.php';

// Initialize variables with empty values
$username = $email = $password = $confirm_password = '';
$username_err = $email_err = $password_err = $confirm_password_err = '';

// Process form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter a username.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
        $username_err = 'Username can only contain letters, numbers, and underscores.';
    } else {
        $username = trim($_POST['username']);
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter an email address.';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Please enter a valid email address.';
    } else {
        // Check if email already exists in the database
        $email = trim($_POST['email']);
        $sql = 'SELECT id FROM users WHERE email = ?';
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('s', $email_param);
            $email_param = $email;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $email_err = 'This email is already taken.';
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }
            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter a password.';
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = 'Password must have at least 6 characters.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = 'Please confirm password.';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Hash the password with md5
        $hashed_password = md5($password);

        // Prepare an insert statement
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sss', $username_param, $email_param, $hashed_password_param);
            $username_param = $username;
            $email_param = $email;
            $hashed_password_param = $hashed_password;
            if ($stmt->execute()) {
                // Redirect to login page
                header('location: login.php');
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }
            $stmt->close();
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>
