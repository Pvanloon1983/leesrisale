<?php
session_start();
include_once('../config/db.php'); // Include the database configuration file

// Handle the AJAX request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the data from the AJAX request
  $user_id = $_POST["user_id"];
  $font_sizes_data = json_decode($_POST["font_sizes_data"], true);

  try {
    $conn->beginTransaction();

    // Loop through the font sizes data and save/update the font sizes in the database
    foreach ($font_sizes_data as $font_data) {
      $tag_name = $font_data["tag_name"];
      $class_names = $font_data["class_names"];
      $font_size = $font_data["font_size"];

      // Check if the combination already exists for the user_id
      $stmt = $conn->prepare("SELECT COUNT(*) FROM font_settings WHERE user_id = :user_id AND tag_name = :tag_name AND class_names = :class_names");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":tag_name", $tag_name, PDO::PARAM_STR);
      $stmt->bindParam(":class_names", $class_names, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->fetchColumn();

      if ($count == 0) {
        // Combination doesn't exist, so insert into the database
        $stmt = $conn->prepare("INSERT INTO font_settings (user_id, tag_name, class_names, font_size) VALUES (:user_id, :tag_name, :class_names, :font_size)");
      } else {
        // Combination already exists, update the font size
        $stmt = $conn->prepare("UPDATE font_settings SET font_size = :font_size WHERE user_id = :user_id AND tag_name = :tag_name AND class_names = :class_names");
      }

      // Bind the parameters to the placeholders
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":tag_name", $tag_name, PDO::PARAM_STR);
      $stmt->bindParam(":class_names", $class_names, PDO::PARAM_STR);
      $stmt->bindParam(":font_size", $font_size, PDO::PARAM_STR);

      // Execute the prepared statement
      $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();

    // Return a response to the client-side JavaScript (optional)
    echo json_encode(["success" => true]);
  } catch (PDOException $e) {
    // Rollback the transaction on error
    $conn->rollback();
    // Handle database errors
    echo json_encode(["error" => $e->getMessage()]);
  }
}
?>
