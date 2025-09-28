<?php
session_start();
if(!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$events = file_exists('events.txt') ? file('events.txt', FILE_IGNORE_NEW_LINES) : [];
$id = $_GET['id'] ?? null;

if($id === null || !isset($events[$id])) {
  die("Event not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $location = trim($_POST['location']);
  $date = trim($_POST['date']);
  $fee = trim($_POST['fee']);
  $desc = trim($_POST['description']);
  $names = trim($_POST['names']); // names separated by commas

  $events[$id] = $title."|".$location."|".$date."|".$fee."|".$desc."|".$names;
  file_put_contents('events.txt', implode("\n", $events) . "\n");
  header('Location: index.php');
  exit;
}

// Load event data
list($title, $location, $date, $fee, $desc, $names) = explode('|', $events[$id]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Event</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Edit Event</h1></header>
<main>
  <form method="post">
    <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
    <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
    <input type="date" name="date" value="<?php echo htmlspecialchars($date); ?>" required>
    <input type="number" step="0.01" name="fee" value="<?php echo htmlspecialchars($fee); ?>" required>
    <textarea name="description"><?php echo htmlspecialchars($desc); ?></textarea>
    <input type="text" name="names" value="<?php echo htmlspecialchars($names); ?>" placeholder="Enter names separated by commas">
    <button type="submit">Save</button>
  </form>
  <a href="index.php">Back</a>
</main>
</body>
</html>
