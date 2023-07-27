<?php
session_start();
include_once('config/db.php');
include('includes/header-normal-page.php');
?>

<div class="container">
    <form id="search-page-form" action="zoeken" method="GET">
        <input placeholder="Zoeken..." class="search-page-input" type="text" name="zoeken" value="<?php echo isset($_GET['zoeken']) ? htmlspecialchars($_GET['zoeken']) : ''; ?>">
        <button class="search-clear-button" type="button" aria-label="Clear search input"><i class="fa-solid fa-xmark"></i></button>        
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

function highlightSearchTerm(searchQuery, text, title, pageNumber, urlSlug) {

    // Get the base URL of the website
    const baseURL = window.location.origin;

    const occurrences = findAllOccurrences(searchQuery, text);
    let highlightedText = '';

    occurrences.forEach((occurrence) => {
        const beforeMatch = text.substring(occurrence.start, Math.max(occurrence.start - 40, 0));
        const matchedText = text.substring(occurrence.start, occurrence.end);
        const afterMatch = text.substring(occurrence.end, occurrence.end + 40);
        const isAccented = occurrence.isAccented;

        let truncatedBeforeMatch = beforeMatch;
        let truncatedAfterMatch = afterMatch;

        if (beforeMatch.length > 40) {
            truncatedBeforeMatch = '...' + beforeMatch.substring(beforeMatch.length - 40);
        }

        if (afterMatch.length === 40) {
            truncatedAfterMatch += '...';
        }

        // Combine the baseURL and urlSlug to get the complete URL
        const completeURL = baseURL + '/' + urlSlug;

        if (isAccented) {
            highlightedText += `<a href="${completeURL}#zoekbladzijde=${pageNumber}" class="search-result-item search-result-item-box"><p class="boek-titel">${title} - <span class="boek-blz">Blz: ${pageNumber}</span></p>...${truncatedBeforeMatch}<mark class="highlight">${matchedText}</mark>${truncatedAfterMatch}</a>`;
        } else {
            highlightedText += `<a href="${completeURL}#zoekbladzijde=${pageNumber}" class="search-result-item search-result-item-box"><p class="boek-titel">${title} - <span class="boek-blz">Blz: ${pageNumber}</span></p>...${truncatedBeforeMatch}<mark class="highlight">${matchedText.toLowerCase()}</mark>${truncatedAfterMatch}</a>`;
        }

        // Add the book title and page number to the output
        //highlightedText += `<div class="search-result-info"><p class="boek-titel">${title}</p><p class="boek-blz">Blz: ${pageNumber}</p></div>`;
    });

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
                const resultItems = zoekResultaten.querySelectorAll('div[data-title][data-url-slug][data-page-number]');
                resultItems.forEach((item) => {
                    const bookTitle = item.getAttribute('data-title');
                    const pageNumber = item.getAttribute('data-page-number');
                    const urlSlug = item.getAttribute('data-url-slug');
                    const content = item.textContent;
                    item.innerHTML = highlightSearchTerm(searchQuery, content, bookTitle, pageNumber, urlSlug);
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

// Function to clear the search input and results
function clearSearchInput() {
    const zoekResultaten = document.querySelector('.zoek-resultaten');
    const searchInput = document.querySelector('.search-page-input');
    searchInput.value = ''; // Clear the input value
    zoekResultaten.innerHTML = ''; // Remove search results from the page
    searchInput.focus(); // Set focus back to the input
}

// Add event listener to the input event on the search input box
const searchInput = document.querySelector('.search-page-input');
searchInput.addEventListener('input', function () {
    const zoekResultaten = document.querySelector('.zoek-resultaten');
    const searchQuery = searchInput.value.trim();

    if (zoekResultaten && searchQuery === '') {
        zoekResultaten.innerHTML = ''; // Remove search results from the page
    }
});

// Set the focus inside the search input on page load
searchInput.focus();

// Add click event listener to the clear button
const clearButton = document.querySelector('.search-clear-button');
clearButton.addEventListener('click', clearSearchInput);
</script>

<?php include('includes/footer-normal-page.php'); ?>
