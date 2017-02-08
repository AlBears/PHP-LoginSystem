<?php

/**
 * Sign up a new user
 */

// Initialisation
require_once('includes/init.php');

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  User::signup($_POST);

  // Redirect to signup success page
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/signup_success.php');
  exit;
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Sign Up';
include('includes/header.php');

?>

<h1>Sign Up</h1>

<form method="post">
  <div>
    <label for="name">Name</label>
    <input id="name" name="name" />
  </div>

  <div>
    <label for="email">email address</label>
    <input id="email" name="email" />
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" />
  </div>

  <input type="submit" value="Sign Up" />
</form>

<?php include('includes/footer.php'); ?>
