<?php

/**
 * Log in a user
 */

// Initialisation
require_once('includes/init.php');

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = $_POST['email'];

  if (Auth::getInstance()->login($email, $_POST['password'])) {
    // Redirect to home page
    Util::redirect('/index.php');
  }
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Login';
include('includes/header.php');

?>

<h1>Login</h1>

<?php if (isset($email)): ?>
  <p>Invalid login</p>
<?php endif; ?>

<form method="post">
  <div>
    <label for="email">email address</label>
    <input id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" />
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" />
  </div>

  <input type="submit" value="Login" />
</form>

<?php include('includes/footer.php'); ?>
