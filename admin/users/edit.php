<?php

/**
 * User admin - edit a user
 */

// Initialisation
require_once('../../includes/init.php');

// Require the user to be logged in before they can see this page.
Auth::getInstance()->requireLogin();

// Require the user to be an administrator before they can see this page.
Auth::getInstance()->requireAdmin();

// Find the user or show a 404 page.
$user = User::getByIDor404($_GET);


// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($user->save($_POST)) {

    // Redirect to show page
    Util::redirect('/admin/users/show.php?id=' . $user->id);
  }
}


// Show the page header, then the rest of the HTML
include('../../includes/header.php');

?>

<h1>Edit User</h1>

<?php if ( ! empty($user->errors)): ?>
  <ul>
    <?php foreach ($user->errors as $error): ?>
      <li><?php echo $error; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="post">
  <div>
    <label for="name">Name</label>
    <input id="name" name="name" value="<?php echo htmlspecialchars($user->name); ?>" />
  </div>

  <div>
    <label for="email">email address</label>
    <input id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" />
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" />
    <p>Leave blank to keep current password</p>
  </div>

  <div>
    <label for="is_active">
      <input id="is_active" name="is_active" type="checkbox" value="1"
             <?php if ($user->is_active): ?>checked="checked"<?php endif; ?>/> active
    </label>
  </div>

  <div>
    <label for="is_admin">
      <input id="is_admin" name="is_admin" type="checkbox" value="1"
             <?php if ($user->is_admin): ?>checked="checked"<?php endif; ?>/> administrator
    </label>
  </div>

  <input type="submit" value="Save" />
  <a href="/admin/users/show.php?id=<?php echo $user->id; ?>">Cancel</a>
</form>


<?php include('../../includes/footer.php'); ?>
