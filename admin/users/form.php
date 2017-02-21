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
    <?php if (isset($user->id)): ?><p>Leave blank to keep current password</p><?php endif; ?>
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
  <a href="/admin/users<?php if (isset($user->id)) { echo '/show.php?id=' . $user->id; } ?>">Cancel</a>
</form>
