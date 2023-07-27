<?php
// get_search_results.php

session_start();
include_once('../config/db.php'); // Include the database configuration file

// Helper function to remove accents from a string
function removeAccents($str) {
    return strtr($str, 
        'ÀÁÂÃÄÅàáâãäåĀāĂăĄąÇçĆćĈĉĊċČčÐðĎďĐđÈÉÊËèéêëĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħÌÍÎÏìíîïĨĩĪīĬĭĮįİıĴĵĶķĸĹĺĻļĽľĿŀŁłÑñŃńŅņŇňŉŊŋÒÓÔÕÖØòóôõöøŌōŎŏŐőŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧÙÚÛÜùúûüŨũŪūŬŭŮůŰűŲųŴŵÝýÿŶŷŸŹźŻżŽž',
        'AAAAAAAAaaaaaaaCCCCccDdEEEEeeeeGgGgGgHhIIIIiiiiIiIiIiIiIiJjKkkLlLlLlLlLlNnNnNnnNnOOOOOOooooooRrRrRrSSsSsSsSsTtTtTtUUUUuuuuUuUuUuUuUuWwYyyYyYZzZzZz'
    );
}

if (isset($_GET['zoeken']) && !empty($_GET['zoeken'])) {
    // Sanitize the search query to prevent SQL injection
    $search_query = strip_tags($_GET['zoeken']);

    // Create the SQL query to search for the input in the 'inhoud_blz' column
    $query = "SELECT * FROM boeken WHERE LOWER(inhoud_blz) LIKE :search_query";
    $stmt = $conn->prepare($query);

    // Normalize the search query and bind the parameter
    $normalized_search_query = '%' . removeAccents($search_query) . '%';
    $stmt->bindParam(':search_query', $normalized_search_query, PDO::PARAM_STR);
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
            echo '<p><strong>Titel:</strong> ' . $titel . '</p>';
            echo '<p><strong>URL Slug:</strong> ' . $url_slug . '</p>';
            echo '<p><strong>Inhoud Blz:</strong> ' . htmlspecialchars($inhoud_blz) . '</p>';
            echo '<p><strong>Bladzijde:</strong> ' . $bladzijde . '</p>';
            echo '<hr>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
}
?>
