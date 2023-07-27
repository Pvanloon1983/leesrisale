<?php
session_start();
include_once('../config/db.php'); // Include the database configuration file

// Handle the AJAX request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the data from the AJAX request
  $user_id = $_SESSION["user_id"];

  try {
    // Clear the font sizes from the database for the user
    $stmt = $conn->prepare("DELETE FROM font_settings WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return a response to the client-side JavaScript (optional)
    echo json_encode(["success" => true]);
  } catch (PDOException $e) {
    // Handle database errors
    echo json_encode(["error" => $e->getMessage()]);
  }
}
?>
