<?php
// Include the necessary files and start the session if required
session_start();
include_once('../config/db.php'); // Include the database configuration file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  http_response_code(403); // Forbidden status code
  exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the data from the request body
  $data = json_decode(file_get_contents('php://input'), true);

  // Extract the data
  $bookmark_id = $data['id'];
  $user_id = $_SESSION['user_id'];

  // Validate the data (optional, based on your requirements)

  try {
    // Prepare the SQL statement to delete the bookmark from the database
    $stmt = $conn->prepare("DELETE FROM bladwijzers WHERE id = :bookmark_id AND user_id = :user_id");
    $stmt->bindParam(':bookmark_id', $bookmark_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Return a success response
    http_response_code(200); // OK status code
    echo json_encode(['message' => 'Bookmark deleted successfully']);
  } catch (PDOException $e) {
    // Return an error response to the client
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
  }
} else {
  http_response_code(405); // Method Not Allowed status code
  echo json_encode(['error' => 'Invalid request method']);
}
?>