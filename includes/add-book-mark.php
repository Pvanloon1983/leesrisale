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
    $title = $data['title'];
    $page = $data['page'];
    $url = $data['url'];
    $user_id = $_SESSION['user_id'];

    // Validate the data (optional, based on your requirements)

    try {
        // Check if the bookmark already exists for the user with the same boek, bladzijde, and boek_url
        $stmt = $conn->prepare("SELECT COUNT(*) FROM bladwijzers WHERE user_id = :user_id AND boek = :title AND bladzijde = :page AND boek_url = :url");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':page', $page, PDO::PARAM_INT);
        $stmt->bindParam(':url', $url, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Bookmark with the same combination already exists, return an error response
            //http_response_code(400); // Bad Request status code
            //echo json_encode('Bookmark with the same combination already exists');
            //echo json_encode(['error' => 'Bookmark with the same combination already exists']);
        } else {
            // Prepare the SQL statement to insert the bookmark into the database
            $stmt = $conn->prepare("INSERT INTO bladwijzers (user_id, boek, bladzijde, boek_url) VALUES (:user_id, :title, :page, :url)");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':page', $page, PDO::PARAM_INT);
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->execute();

            // Return a success response
            http_response_code(200); // OK status code
            echo json_encode(['message' => 'Bookmark added successfully']);
        }
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
