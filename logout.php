<?php
session_start();
include_once('config/db.php');

// Clear the remember me cookie
setcookie('remember_me', '', time() - 3600, '/');

// Clear the remember token in the database if it exists
if (isset($_COOKIE['remember_token']) && !empty($_COOKIE['remember_token'])) {
  $token = $_COOKIE['remember_token'];

  // Delete the remember_token from the database
  $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE remember_token = :token");
  $stmt->bindParam(':token', $token);
  $stmt->execute();
}

// Clear the session and destroy it
$_SESSION = array();
session_destroy();

// Delete the remember_token cookie
setcookie('remember_token', '', time() - 3600, '/');

header("Location: /");
exit();
?>