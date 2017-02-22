<?php

/**
 * Sign up a new user
 */

// Initialisation
require_once('includes/init.php');

//Require user to NOT be logged in to access this page
Auth::getInstance()->requireGuest();

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user = User::signup($_POST);

  if (empty($user->errors)) {

  // Redirect to signup success page
  Util::redirect('/signup_success.php');
  }
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Sign Up';
include('includes/header.php');

?>

<h1>Sign Up</h1>


<!--If validation errors exist  -->
<?php if (isset($user)): ?>
  <ul>
    <?php foreach($user->errors as $error): ?>
      <li><?php echo $error; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>


<form method="post" id="signupForm">
  <div>
    <label for="name">Name</label>
    <input id="name" name="name" required="required"
    value="<?php echo isset($user) ? htmlspecialchars($user->name) : '';?>"/>
  </div>

  <div>
    <label for="email">email address</label>
    <input id="email" name="email" required="required" type="email"
    value="<?php echo isset($user) ? htmlspecialchars($user->email) : '';?>"/>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required="required" pattern=".{5,}" title="minimum 5 characters"/>
  </div>

  <input type="submit" value="Sign Up" />
</form>

<?php include('includes/footer.php'); ?>
