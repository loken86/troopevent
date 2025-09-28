<?php
session_start();
if(!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$events = file_exists('events.txt') ? file('events.txt', FILE_IGNORE_NEW_LINES) : [];
$id = $_GET['id'] ?? null;

if($id !== null && isset($events[$id])) {
  unset($events[$id]);
  file_put_contents('events.txt', implode("\n", $events) . (count($events) ? "\n" : ""));
}

header('Location: index.php');
exit;
