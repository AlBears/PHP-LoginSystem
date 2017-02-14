<?php


require_once('../../includes/init.php');

Auth::getInstance()->requireLogin();

Auth::getInstance()->requireAdmin();


if (isset($_GET['id'])) {
  $user = User::findByID($_GET['id']);
}

if (!isset($user)) {
  header('HTTP/1.0 404 Not Found');
  echo '404 Not Found';
  exit;
}

include('../../includes/header.php');

 ?>

 <h1>User</h1>

<p><a href="/admin/users">&laquo; back to list of users</a></p>

<dl>
  <dt>Name</dt>
  <dd><?php echo htmlspecialchars($user->name); ?></dd>
  <dt>email address</dt>
  <dd><?php echo htmlspecialchars($user->email); ?></dd>
  <dt>Active</dt>
  <dd><?php echo $user->is_active ? '&#10004;' : '&#10008;'; ?></dd>
  <dt>Administrator</dt>
  <dd><?php echo $user->is_admin ? '&#10004;' : '&#10008;'; ?></dd>
</dl>

<?php include('../../includes/footer.php'); ?>
