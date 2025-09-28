<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $users = file('users.txt', FILE_IGNORE_NEW_LINES);

  foreach ($users as $user) {
    list($u, $p) = explode(':', $user);
    if ($u === $username && $p === $password) {
      $_SESSION['user'] = $username;
      header('Location: index.php');
      exit;
    }
  }
  $error = "Invalid login.";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h1>Login</h1></header>
  <main>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <a href="index.php">Back</a>
  </main>
</body>
</html>
