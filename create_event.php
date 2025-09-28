<?php
session_start();
if(!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $location = trim($_POST['location']);
  $date = trim($_POST['date']);
  $fee = trim($_POST['fee']);
  $desc = trim($_POST['description']);
  $names = trim($_POST['names']); // comma-separated initial names

  if ($title && $location && $date && $fee) {
    $line = $title."|".$location."|".$date."|".$fee."|".$desc."|".$names."\n";
    file_put_contents('events.txt', $line, FILE_APPEND);
    $success = "Event created!";
  } else {
    $error = "Please fill in all required fields.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Event</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Create Event</h1></header>
<main>
  <?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>
  <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

  <form method="post">
    <input type="text" name="title" placeholder="Event Title" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="date" name="date" required>
    <input type="number" step="0.01" name="fee" placeholder="Fee" required>
    <textarea name="description" placeholder="Event Description"></textarea>
    <input type="text" name="names" placeholder="Enter names separated by commas">
    <button type="submit">Create Event</button>
  </form>
  <a href="index.php">Back</a>
</main>
</body>
</html>
