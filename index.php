<?php session_start();
$events = file_exists('events.txt') ? file('events.txt', FILE_IGNORE_NEW_LINES) : [];

// Sort events by date
usort($events, function($a, $b) {
    $dateA = strtotime(explode('|', $a)[2]);
    $dateB = strtotime(explode('|', $b)[2]);
    return $dateA <=> $dateB;
});
?>
<!DOCTYPE html>
<html>
<head>
  <title>Troop 852</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <h1>Troop Events</h1>
</header>

<nav>
  <a href="signup.php">Sign Up</a>

  <!-- Hamburger Dropdown -->
  <div class="dropdown">
    <button class="dropbtn">&#9776;</button>
    <div class="dropdown-content">
      <a href="login.php">Login</a>
      <a href="create_event.php">Create Event</a>
    </div>
  </div>

  <?php if(isset($_SESSION['user'])): ?>
    <span style="margin-left:15px;">Logged in as <?php echo $_SESSION['user']; ?></span>
    <a href="logout.php">Logout</a>
  <?php endif; ?>
</nav>

<main>
  <h2>Upcoming Events</h2>
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

        <?php if(!empty($namesArr)): ?>
          <p><strong>Signed up:</strong> <?php echo htmlspecialchars(implode(', ', $namesArr)); ?></p>
        <?php endif; ?>

        <?php if(isset($_SESSION['user'])): ?>
          <a href="edit_event.php?id=<?php echo $index; ?>">Edit</a>
          <a href="delete_event.php?id=<?php echo $index; ?>" onclick="return confirm('Delete this event?');">Delete</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropbtn = document.querySelector('.dropbtn');
    const dropdownContent = document.querySelector('.dropdown-content');

    dropbtn.addEventListener('click', function() {
        dropdownContent.classList.toggle('show');
    });

    window.addEventListener('click', function(e) {
        if (!dropbtn.contains(e.target) && !dropdownContent.contains(e.target)) {
            dropdownContent.classList.remove('show');
        }
    });
});
</script>
</body>
</html>
