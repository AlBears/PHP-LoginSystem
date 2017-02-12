<!DOCTYPE html>
<html>
<head>
  <title><?php if (isset($page_title)): ?><?php echo $page_title; ?> | <?php endif; ?>Example Site</title>
  <meta charset="utf-8" />
</head>
<body>

  <nav role="navigation">
    <ul>
      <li><a href="/">Home</a></li>

      <?php if (Auth::getInstance()->isLoggedIn()): ?>

        <?php if (Auth::getInstance()->isAdmin()): ?>
          <li>Admin</li>
        <?php endif; ?>
        <li><a href="/profile.php">Profile</a></li>
        <li><a href="/logout.php">Logout</a></li>

      <?php else: ?>

        <li><a href="/login.php">Login</a></li>

      <?php endif; ?>
    </ul>
  </nav>
