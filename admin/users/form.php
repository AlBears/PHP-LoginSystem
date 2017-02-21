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

  <?php $is_same_user = $user->id == Auth::getInstance()->getCurrentUser()->id; ?>

  <div>
    <label for="is_active">
      <?php if ($is_same_user): ?>
        <input type="hidden" name="is_active" value="1" />
        <input type="checkbox" disabled="disabled" checked="checked" /> active

      <?php else: ?>
        <input id="is_active" name="is_active" type="checkbox" value="1"
               <?php if ($user->is_active): ?>checked="checked"<?php endif; ?>/> active

      <?php endif; ?>
    </label>
  </div>

  <div>
    <label for="is_admin">
      <?php if ($is_same_user): ?>
        <input type="hidden" name="is_admin" value="1" />
        <input type="checkbox" disabled="disabled" checked="checked" /> administrator

      <?php else: ?>
        <input id="is_admin" name="is_admin" type="checkbox" value="1"
               <?php if ($user->is_admin): ?>checked="checked"<?php endif; ?>/> administrator

      <?php endif; ?>
    </label>
  </div>

  <input type="submit" value="Save" />
  <a href="/admin/users<?php if (isset($user->id)) { echo '/show.php?id=' . $user->id; } ?>">Cancel</a>
</form>
