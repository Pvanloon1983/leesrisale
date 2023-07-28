<?php
// get_search_results.php

session_start();
include_once('../config/db.php'); // Include the database configuration file

if (isset($_GET['zoeken']) && !empty($_GET['zoeken'])) {
    // Sanitize the search query to prevent SQL injection
    $search_query = strip_tags($_GET['zoeken']);
    $search_query = trim($search_query);
    $search_query = htmlspecialchars($search_query);

    // Get the selected book (if any) from the URL parameter
    $selected_book = isset($_GET['een_boek']) ? $_GET['een_boek'] : '';

    // Create the SQL query to search for the input in the 'inhoud_blz' column
    $query = "SELECT * FROM boeken WHERE inhoud_blz LIKE CONCAT('%', :search_query, '%')";

    // If a specific book is selected, add a condition to filter the results
    if ($selected_book !== 'alle_boeken') {
        $query .= " AND titel = :selected_book";
    }

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':search_query', $search_query, PDO::PARAM_STR);

    // If a specific book is selected, bind its value to the parameter
    if ($selected_book !== 'alle_boeken') {
        $stmt->bindParam(':selected_book', $selected_book, PDO::PARAM_STR);
    }

    $stmt->execute();

    // Fetch the matching rows
    $search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are search results
    if (count($search_results) > 0) {
        foreach ($search_results as $result) {
            // Normalize and remove all HTML tags and styling from output text
            $titel = strip_tags(htmlspecialchars_decode($result['titel']));
            $url_slug = strip_tags(htmlspecialchars_decode($result['url_slug']));
            $inhoud_blz = strip_tags(htmlspecialchars_decode($result['inhoud_blz']));
            $bladzijde = strip_tags(htmlspecialchars_decode($result['bladzijde']));

            // Display the search results inside the 'zoek-resultaten' div
            echo '<div data-title="' . htmlspecialchars($titel) . '" data-url-slug="' . htmlspecialchars($url_slug) . '" data-page-number="' . htmlspecialchars($bladzijde) . '">' . htmlspecialchars($inhoud_blz) . '</div>';
        }
    } else {
        echo '<p style="text-align:center;">Geen resultaten gevonden.</p>';
    }
}
?>
