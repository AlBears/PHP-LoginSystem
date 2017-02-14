<?php


require_once('../../includes/init.php');

//users should be logged in before the see this page
Auth::getInstance()->requireLogin();

//and to have admin privilages
Auth::getInstance()->requireAdmin();


$data = User::paginate(isset($_GET['page']) ? $_GET['page'] : 1);


include('../../includes/header.php');

?>

<h1>Users</h1>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>email</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($data['users'] as $user): ?>
      <tr>
        <td><a href="/admin/users/show.php?id=<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></a></td>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<ul>
  <li>
    <?php if ($data['previous'] === null): ?>
      Previous
    <?php else: ?>
      <a href="/admin/users/?page=<?php echo $data['previous']; ?>">Previous</a>
    <?php endif; ?>
  </li>
  <li>
    <?php if ($data['next'] === null): ?>
      Next
    <?php else: ?>
      <a href="/admin/users/?page=<?php echo $data['next']; ?>">Next</a>
    <?php endif; ?>
  </li>
</ul>


<?php include('../../includes/footer.php'); ?>
