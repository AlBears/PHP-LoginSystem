<?php

/**
 * Reset password form
 */

// Initialisation
require_once('includes/init.php');

// Require the user to NOT be logged in before they can see this page.
Auth::getInstance()->requireGuest();


// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user = User::findForPasswordReset($_POST['token']);

  if ($user !== null) {

    $user->password = $_POST['password'];
    $user->password_confirmation = $_POST['password_confirmation'];

    if ($user->resetPassword()) {

      // Redirect to success page
      Util::redirect('/reset_password_success.php');
    }
  }

} else {  // GET

  // Find the user based on the token
  if (isset($_GET['token'])) {
    $user = User::findForPasswordReset($_GET['token']);
  }
}


// Set the title, show the page header, then the rest of the HTML
$page_title = 'Reset password';
include('includes/header.php');

?>

<h1>Reset password</h1>

<?php if (isset($user)): ?>

  <?php if ( ! empty($user->errors)): ?>
    <ul>
      <?php foreach ($user->errors as $error): ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <input type="hidden" id="token" name="token" value="<?php echo $_GET['token']; ?>" />

    <div>
      <label for="password">New password</label>
      <input type="password" id="password" name="password" />
    </div>

    <div>
      <label for="password_confirmation">New password again</label>
      <input type="password" id="password_confirmation" name="password_confirmation" />
    </div>

    <input type="submit" value="Reset password" />
  </form>

<?php else: ?>

  <p>Reset token not found or expired. Please <a href="forgot_password.php">try resetting your password again</a>.</p>

<?php endif; ?>

<?php include('includes/footer.php'); ?>
