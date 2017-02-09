<?php


require_once('includes/init.php');


Auth::getInstance()->requireLogin();


$page_title = 'Profile';
include('includes/header.php');

?>

<h1>Profile</h1>

<?php $user = Auth::getInstance()->getCurrentUser(); ?>

<dl>
  <dt>Name</dt>
  <dd><?php echo htmlspecialchars($user->name); ?></dd>
  <dt>email address</dt>
  <dd><?php echo htmlspecialchars($user->email); ?></dd>
</dl>

<?php include('includes/footer.php'); ?>
