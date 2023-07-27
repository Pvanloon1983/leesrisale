<?php
session_start();
include_once('../config/db.php'); // Include the database configuration file

// Handle the AJAX request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the logged-in user ID from the session
  $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

  try {
    // Prepare the SQL statement to get the font sizes from the database for the logged-in user
    $stmt = $conn->prepare("SELECT tag_name, class_names, font_size FROM font_settings WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $font_sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the font sizes to the client-side JavaScript
    echo json_encode($font_sizes);
  } catch (PDOException $e) {
    // Handle database errors
    echo json_encode(["error" => $e->getMessage()]);
  }
}
?>
