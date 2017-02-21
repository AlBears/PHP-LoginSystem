<?php


require_once('../../includes/init.php');

Auth::getInstance()->requireLogin();

Auth::getInstance()->requireAdmin();

$user = User::getByIDor404($_GET);

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

<ul>
  <li><a href="/admin/users/edit.php?id=<?php echo $user->id; ?>">Edit</a></li>
  <li>
    <?php if ($user->id == Auth::getInstance()->getCurrentUser()->id): ?>
      Delete
    <?php else: ?>
      <a href="/admin/users/delete.php?id=<?php echo $user->id; ?>">Delete</a>
    <?php endif; ?>
  </li>
</ul>


<?php include('../../includes/footer.php'); ?>
