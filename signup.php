<?php
// Handle signup submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $eventIndex = $_POST['event'];
  $name = trim($_POST['name']);

  $events = file('events.txt', FILE_IGNORE_NEW_LINES);

  if(isset($events[$eventIndex]) && $name) {
    $parts = explode('|', $events[$eventIndex]);
    $currentNames = trim($parts[5]); // names field
    $namesArr = $currentNames ? explode(',', $currentNames) : [];
    $namesArr[] = $name;
    $parts[5] = implode(',', $namesArr);
    $events[$eventIndex] = implode('|', $parts);
    file_put_contents('events.txt', implode("\n", $events) . "\n");
    $success = "You have signed up!";
  }
}

// Load events
$events = file_exists('events.txt') ? file('events.txt', FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Sign Up for Events</h1></header>
<main>
  <?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>

  <?php if(empty($events)): ?>
    <p>No events yet.</p>
  <?php else: ?>
    <?php foreach($events as $index => $event):
      list($title, $location, $date, $fee, $desc, $names) = explode('|', $event);
      $namesArr = $names ? explode(',', $names) : [];
    ?>
      <div class="event-card">
        <h3><?php echo htmlspecialchars($title); ?></h3>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></p>
        <p><strong>Fee:</strong> $<?php echo htmlspecialchars($fee); ?></p>
        <p><?php echo nl2br(htmlspecialchars($desc)); ?></p>

        <form method="post">
          <input type="hidden" name="event" value="<?php echo $index; ?>">
          <input type="text" name="name" placeholder="Your name" required>
          <button type="submit">Sign Up</button>
        </form>

        <?php if(!empty($namesArr)): ?>
          <p><strong>Signed up:</strong> <?php echo htmlspecialchars(implode(', ', $namesArr)); ?></p>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <a href="index.php">Back</a>
</main>
</body>
</html>
