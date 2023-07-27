<?php
// Include the necessary files and start the session if required
session_start();
include_once('../config/db.php'); // Include the database configuration file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Return an empty response for non-logged-in users
  echo json_encode([]);
  exit;
}

$user_id = $_SESSION['user_id'];

try {
  // Prepare the SQL statement to retrieve bookmarks for the user
  $stmt = $conn->prepare("SELECT id, boek, bladzijde, boek_url FROM bladwijzers WHERE user_id = :user_id");
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();

  // Fetch all the bookmarks for the user
  $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Clear the output buffer to remove unwanted characters
  ob_clean();

  // Set the response header to indicate JSON content
  header('Content-Type: application/json');

  // Return the bookmarks data as a JSON response
  echo json_encode($bookmarks);
} catch (PDOException $e) {
  // Return an error response to the client
  http_response_code(500);
  echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
