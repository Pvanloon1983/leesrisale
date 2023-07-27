<?php
session_start();
include_once('config/db.php');
include('includes/header-normal-page.php');
?>

<div class="container">
    <h1 class="main-title">Zoeken</h1>
    <p class="text-under-main-title">De plek om online de Nederlandse vertalingen van de Risale-i Nur te lezen.</p>

    <form id="search-page-form" action="zoeken" method="GET">
        <input class="search-page-input" type="text" name="zoeken" value="<?php echo isset($_GET['zoeken']) ? htmlspecialchars($_GET['zoeken']) : ''; ?>">
        <button class="search-page-search-button" type="submit">Zoeken</button>
    </form>

    <div class="zoek-resultaten">
        <!-- Search results will be dynamically updated here -->
    </div>
</div>

<script>
// Helper function to remove accents from a string
function removeAccents(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

// Function to find all occurrences of a search term in the text
function findAllOccurrences(searchQuery, text) {
    const normalizedSearchQuery = removeAccents(searchQuery.toLowerCase());
    const regex = new RegExp(normalizedSearchQuery, 'gi');
    const matches = [];

    let match;
    while ((match = regex.exec(removeAccents(text.toLowerCase()))) !== null) {
        matches.push({
            start: match.index,
            end: match.index + match[0].length,
            isAccented: removeAccents(match[0].toLowerCase()) === normalizedSearchQuery,
        });
    }

    return matches;
}

// Function to highlight search term in the results
function highlightSearchTerm(searchQuery, text) {
    const occurrences = findAllOccurrences(searchQuery, text);
    let highlightedText = '';
    let currentIndex = 0;

    occurrences.forEach((occurrence) => {
        const beforeMatch = text.substring(currentIndex, occurrence.start);
        const matchedText = text.substring(occurrence.start, occurrence.end);
        highlightedText += beforeMatch;

        if (occurrence.isAccented) {
            highlightedText += `<span style="background-color: yellow;">${matchedText}</span>`;
        } else {
            highlightedText += `<span style="background-color: yellow;">${matchedText.toLowerCase()}</span>`;
        }

        currentIndex = occurrence.end;
    });

    highlightedText += text.substring(currentIndex);
    return highlightedText;
}

    // Function to update search results with AJAX using fetch() API
    function updateSearchResults() {
        const zoekResultaten = document.querySelector('.zoek-resultaten');
        const searchInput = document.querySelector('.search-page-input');
        const searchQuery = searchInput.value;

        if (zoekResultaten && searchQuery) {
            const encodedSearchQuery = encodeURIComponent(searchQuery);

            fetch('./includes/get_search_results.php?zoeken=' + encodedSearchQuery)
                .then((response) => response.text())
                .then((data) => {
                    zoekResultaten.innerHTML = data;
                    // Highlight the search term in the updated results
                    const resultParagraphs = zoekResultaten.querySelectorAll('p');
                    resultParagraphs.forEach((paragraph) => {
                        paragraph.innerHTML = highlightSearchTerm(searchQuery, paragraph.textContent);
                    });
                })
                .catch((error) => {
                    console.error('Error fetching search results:', error);
                });
        }
    }

    // Call the function on search form submit and page load
    document.querySelector('#search-page-form').addEventListener('submit', function (event) {
        event.preventDefault();
        updateSearchResults();
    });

    // Call the function on page load if the search query is present
    const initialSearchQuery = '<?php echo isset($_GET['zoeken']) ? htmlspecialchars($_GET['zoeken']) : ''; ?>';
    if (initialSearchQuery) {
        updateSearchResults();
    }
</script>

<?php include('includes/footer-normal-page.php'); ?>
