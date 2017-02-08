<?php

/**
 * Sign up a new user
 */

// Initialisation
require_once('includes/init.php');

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user = User::signup($_POST);

  if (empty($user->errors)) {

  // Redirect to signup success page
  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/signup_success.php');
  exit;
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


<form method="post">
  <div>
    <label for="name">Name</label>
    <input id="name" name="name"
    value="<?php echo isset($user) ? htmlspecialchars($user->name) : '';?>"/>
  </div>

  <div>
    <label for="email">email address</label>
    <input id="email" name="email"
    value="<?php echo isset($user) ? htmlspecialchars($user->email) : '';?>"/>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" />
  </div>

  <input type="submit" value="Sign Up" />
</form>

<?php include('includes/footer.php'); ?>
