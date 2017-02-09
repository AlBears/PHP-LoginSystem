<?php

/**
 * Log in a user
 */

// Initialisation
require_once('includes/init.php');

//Require user to NOT be logged in to access this page
Auth::getInstance()->requireGuest();

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = $_POST['email'];

  if (Auth::getInstance()->login($email, $_POST['password'])) {

    // Redirect to home page or intended page, if set
    if (isset($_SESSION['return_to'])) {
      $url = $_SESSION['return_to'];
      unset($_SESSION['return_to']);
    } else {
      $url = '/index.php';
    }

    Util::redirect($url);
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
