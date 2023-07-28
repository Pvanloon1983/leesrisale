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
    <div class="terug-button">
      <button class="terug-naar-vorige-pagina"><i class="fa-solid fa-arrow-left"></i></button>
    </div>


    <div class="zoek-resultaten">
        <!-- Search results will be dynamically updated here -->
    </div>
</div>

<script>
function removeAccents(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase();
}

function compareStrings(string1, string2) {
    const collator = new Intl.Collator(undefined, { sensitivity: 'base' });
    return collator.compare(string1, string2) === 0;
}

function findAllOccurrences(searchQuery, text) {
    // Find occurrences of the original search query in the text
    let occurrences = findOccurrences(searchQuery, text, compareStrings);

    // If no occurrences are found, find occurrences of the normalized search query
    if (occurrences.length === 0) {
        const normalizedSearchQuery = removeAccents(searchQuery.toLowerCase());
        occurrences = findOccurrences(normalizedSearchQuery, text.toLowerCase(), compareStrings);
    }

    return occurrences;
}

function findOccurrences(searchQuery, text, stringComparator) {
    const occurrences = [];
    let currentIndex = text.indexOf(searchQuery);

    while (currentIndex !== -1) {
        const isAccented = !stringComparator(searchQuery, text.substr(currentIndex, searchQuery.length));
        occurrences.push({
            start: currentIndex,
            end: currentIndex + searchQuery.length,
            isAccented: isAccented,
        });
        currentIndex = text.indexOf(searchQuery, currentIndex + 1);
    }

    return occurrences;
}



function highlightSearchTerm(searchQuery, text, title, pageNumber, urlSlug) {
    const hasAccents = /[ÀÁÂÃÄÅàáâãäåĀāĂăĄąÇçĆćĈĉĊċČčÐðĎďĐđÈÉÊËèéêëĒēĔĕĖėĘęĚěĜĝĞğĠġĢģĤĥĦħÌÍÎÏìíîïĨĩĪīĬĭĮįİıĴĵĶķĸĹĺĻļĽľĿŀŁłÑñŃńŅņŇňŉŊŋÒÓÔÕÖØòóôõöøŌōŎŏŐőŔŕŖŗŘřŚśŜŝŞşŠšŢţŤťŦŧÙÚÛÜùúûüŨũŪūŬŭŮůŰűŲųŴŵÝýÿŶŷŸŹźŻżŽž]/.test(searchQuery);

    const normalizedSearchQuery = removeAccents(searchQuery);
    const normalizedText = removeAccents(text);

    // Get the base URL of the website
    const baseURL = window.location.origin;

    let occurrences = [];
    if (hasAccents) {
        occurrences = findAllOccurrences(searchQuery, text);
    } else {
        occurrences = findAllOccurrences(normalizedSearchQuery, normalizedText);
    }

    let highlightedText = '';

    occurrences.forEach((occurrence) => {
        const beforeMatch = text.substring(Math.max(occurrence.start - 40, 0), occurrence.start);
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
            highlightedText += `<a href="${completeURL}#zoekbladzijde=${pageNumber}" class="search-result-item search-result-item-box"><p class="boek-titel">${title} - <span class="boek-blz">Blz: ${pageNumber}</span></p>...${truncatedBeforeMatch}<mark class="highlight">${matchedText}</mark>${truncatedAfterMatch}</a>`;
        }
    });

    return highlightedText;
}

// Function to update search results with AJAX using fetch() API
function updateSearchResults() {
    const zoekResultaten = document.querySelector('.zoek-resultaten');
    const searchInput = document.querySelector('.search-page-input');
    let searchQuery = searchInput.value;
    searchQuery = searchQuery.trim();

    if (zoekResultaten && searchQuery) {
        const encodedSearchQuery = encodeURIComponent(searchQuery);        

        fetch('./includes/get_search_results.php?zoeken=' + searchQuery)
            .then((response) => response.text())
            .then((data) => {

                zoekResultaten.innerHTML = data;
                // Highlight the search term in the updated results
                const resultItems = zoekResultaten.querySelectorAll('div[data-title][data-url-slug][data-page-number]');
                resultItems.forEach((item) => {
                    const bookTitle = item.getAttribute('data-title');
                    const pageNumber = item.getAttribute('data-page-number');
                    const urlSlug = item.getAttribute('data-url-slug');
                    const content = item.innerHTML; // Use innerHTML instead of textContent
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



// Function to check if the referrer is from the same domain
function isSameDomainReferrer() {
  const referrer = document.referrer;
  if (referrer) {
    const referrerURL = new URL(referrer);
    const currentURL = new URL(window.location.href);
    return referrerURL.origin === currentURL.origin;
  }
  return false;
}

// Function to handle the button click
function handleBackButtonClick() {
  if (isSameDomainReferrer()) {
    window.history.back();
  } else {
    // Handle the case when coming from a different domain, or no referrer
    // For example, you can redirect to the homepage or another page on your domain.
    // Replace 'your-homepage-url' with the desired URL.
    window.location.href = '/';
  }
}

// Add click event listener to the back button
const backButton = document.querySelector('.terug-naar-vorige-pagina');
backButton.addEventListener('click', handleBackButtonClick);



</script>

<?php include('includes/footer-normal-page.php'); ?>
