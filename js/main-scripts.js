function findAllOccurrences(text, searchTerm) {
  const occurrences = [];
  let index = text.indexOf(searchTerm);
  while (index !== -1) {
    occurrences.push([index, index + searchTerm.length]);
    index = text.indexOf(searchTerm, index + 1);
  }
  return occurrences;
}

function highlightDiacriticMatches(text, searchTerm, pageNumber) {
  const normalizedText = normalizeText(text);
  const normalizedSearchTerm = normalizeText(searchTerm);

  const MAX_WORDS = 20; // Adjust this value to set the number of words on each side

  const occurrences = findAllOccurrences(normalizedText, normalizedSearchTerm);

  let highlightedContent = '';
  let foundResults = false;

  for (const [startIndex, endIndex] of occurrences) {
    foundResults = true;
    const startIndexWithBoundaries = Math.max(startIndex - MAX_WORDS * 2, 0);
    const endIndexWithBoundaries = Math.min(endIndex + MAX_WORDS * 2, normalizedText.length);
    const context = normalizedText.substring(startIndexWithBoundaries, endIndexWithBoundaries);

    const highlightedTerm = context.replace(
      new RegExp(normalizedSearchTerm, 'gi'),
      (match) => `<mark class="highlight">${match}</mark>`
    );

    highlightedContent += `<div class="search-item-result item-result" data-page-id="${pageNumber}" onclick="goToPageAndScroll(${pageNumber})"><p class="page-item-result">Blz. ${pageNumber} - ${currentBook}</p> ...${highlightedTerm}...</div>`;
  }

  return highlightedContent;
}

// Function to get surrounding words of a given text
function getSurroundingWords(text, numWords) {
  const words = text.split(/\s+/);
  const startIndex = Math.max(words.length - numWords, 0);
  const endIndex = Math.min(startIndex + numWords * 2, words.length);
  const surroundingWords = words.slice(startIndex, endIndex);
  return surroundingWords.join(' ');
}

// Function to perform the search based on the user input
function performSearch() {
  const searchInput = document.getElementById('searchInput');
  const searchTerm = searchInput.value.trim().toLowerCase();

  const pageElements = document.getElementsByClassName('pagenumber');
  const minSearchLength = 3; // Minimum number of characters required for the search

  if (searchTerm.length < minSearchLength) {
    // If the search term has less than the minimum required characters, do not perform the search
    return;
  }

  let foundResults = false; // Variable to check if results are found

  for (const pageElement of pageElements) {
    const pageText = pageElement.innerText.toLowerCase();
    const pageNumber = pageElement.getAttribute('id');

    const highlightedContent = highlightDiacriticMatches(pageText, searchTerm, pageNumber);
    pageElement.innerHTML = highlightedContent;

    if (containsDiacriticMatch(pageText, searchTerm)) {
      pageElement.style.display = 'block';
      foundResults = true; // Set to true if results are found
      document.querySelector('.pagina-title-reeks').style.display = 'none';
    } else {
      document.querySelector('.pagina-title-reeks').style.display = 'none';
      pageElement.style.display = 'none';
    }

    pageElement.style.marginBottom = '10px'; // Add margin to each displayed block
    pageElement.style.cursor = 'pointer'; // Set cursor style to pointer
    pageElement.addEventListener('click', goToPage.bind(null, pageNumber));
  }

  if (foundResults) {
    const popup = document.getElementById('popup');
    popup.style.display = 'none';
  } else {
    // If no results are found, display the popup and reload the page after closing it
    const popup = document.getElementById('popup');
    popup.style.display = 'block';

    const closePopupButton = document.getElementById('closePopup');
    closePopupButton.addEventListener('click', function () {
      popup.style.display = 'none';
      location.reload(); // Reload the page after closing the popup
    });
  }

  window.scrollTo({ top: 0, behavior: 'smooth' }); // Scroll to the top of the page
}

// Function to navigate to a specific page
function navigateToPage(pageId) {
  const pageElement = document.getElementById(pageId);
  if (pageElement) {
    pageElement.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
  }
}

// Function to clear the stored page ID from local storage
function clearStoredPageId() {
  localStorage.removeItem('selectedPage');
}

// Function to check if there is a stored page ID and navigate to it on page reload
function checkStoredPageId() {
  const selectedPage = localStorage.getItem('selectedPage');
  if (selectedPage) {
    navigateToPage(selectedPage);
    clearStoredPageId();
  }
}

// Function to check if the text contains a diacritic match
function containsDiacriticMatch(text, searchTerm) {
  const normalizedText = normalizeText(text);
  const normalizedSearchTerm = normalizeText(searchTerm);

  return normalizedText.includes(normalizedSearchTerm);
}

// Function to normalize the text by removing diacritics
function normalizeText(text) {
  return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

// Function to navigate to a specific page
function goToPage(pageId, shouldScroll = true) {
  sessionStorage.setItem('selectedPage', pageId);
  if (shouldScroll) {
    location.reload();
  }
}

// Function to attach event listeners to search-related elements
// function attachEventListeners() {
//   const searchButton = document.querySelector('.search-button');
//   searchButton.addEventListener('click', performSearch);

//   const searchInput = document.getElementById('searchInput');
//   searchInput.addEventListener('input', function () {
//     if (searchInput.value.trim() === '') {
//       location.reload(); // Reload the page when the input box is empty
//     } else {
//       // Show the clear icon when there is text in the input box
//       document.getElementById('clearIcon').style.display = 'block';
//     }
//   });

//   // Handle the click event of the clear icon
//   const clearIcon = document.getElementById('clearIcon');
//   clearIcon.addEventListener('click', function () {
//     // Reload the page when the clear icon is clicked
//     location.reload();
//   });

//   // Hide the clear icon initially
//   clearIcon.style.display = 'none';

//   searchInput.addEventListener('keyup', function (event) {
//     // Check if the Enter key was pressed (key value "Enter" or "NumpadEnter")
//     if (event.key === 'Enter') {
//       performSearch();
//     }
//   });

//   // Replace search item results with clickable links
//   const searchItemResults = document.getElementsByClassName('search-item-result');
//   for (const searchItemResult of searchItemResults) {
//     const pageNumber = searchItemResult.getAttribute('data-page-id');
//     const link = generateSearchResultLink(pageNumber);
//     searchItemResult.parentNode.replaceChild(link, searchItemResult);
//   }
// }

// Function to navigate to a specific page and scroll to the element with requestAnimationFrame
function goToPageAndScroll(pageId) {
  const pageElement = document.getElementById(pageId);
  if (pageElement) {
    // Clear the current page ID from local storage
    localStorage.removeItem("currentPageId" + "-" + currentBookStore);

    window.requestAnimationFrame(function() {
      pageElement.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
      });
    });
  }
}


// Function to generate search result link with proper URL and page ID
function generateSearchResultLink(pageNumber) {
  const link = document.createElement('a');
  link.href = `${currentBookStore}.html#${pageNumber}`;
  link.classList.add('search-item-result', 'item-result');
  link.innerHTML = `<p class="page-item-result">Blz. ${pageNumber} - ${currentBook}</p>`;
  return link;
}

// Global flag to check if the click event is triggered by a search result
let isSearchResultClick = false;

// Function to perform actions on page load
window.addEventListener('load', function () {
  const selectedPage = sessionStorage.getItem('selectedPage');
  if (selectedPage) {
    const pageElement = document.getElementById(selectedPage);
    if (pageElement && !isSearchResultClick) {
      setTimeout(function () {
        pageElement.scrollIntoView({ behavior: 'smooth' });
      }, 0);
    }
    sessionStorage.removeItem('selectedPage');
  } else if (!isSearchResultClick) { // Add condition to skip scroll to top if it's a search result click
    setTimeout(function () {
      //window.scrollTo(0, 0);
    }, 0);
  }

  const searchInput = document.getElementById('searchInput');
  //searchInput.focus(); // Set focus to the search input element

  
  // Attach event listeners after page is fully loaded
  //attachEventListeners();
});

/* Tool tip code */
var tooltipDiv = null;

document.addEventListener("click", function(event) {
  var target = event.target;

  if (target.classList.contains("sup-pointer")) {
    var titleText = target.getAttribute("title");
    showTooltip(target, titleText);
  } else {
    hideTooltip();
  }
});

function showTooltip(element, text) {
  hideTooltip(); // Hide any existing tooltips

  tooltipDiv = document.createElement("div");
  tooltipDiv.textContent = text;
  tooltipDiv.classList.add("tooltip");

  document.body.appendChild(tooltipDiv);

  var tooltipWidth = tooltipDiv.offsetWidth;
  var tooltipHeight = tooltipDiv.offsetHeight;

  var windowWidth = window.innerWidth;
  var windowHeight = window.innerHeight;

  var tooltipTop = windowHeight / 2 - tooltipHeight / 2 + window.pageYOffset;
  var tooltipLeft = windowWidth / 2 - tooltipWidth / 2 + window.pageXOffset;

  tooltipDiv.style.top = tooltipTop + "px";
  tooltipDiv.style.left = tooltipLeft + "px";
}


function hideTooltip() {
  if (tooltipDiv) {
    tooltipDiv.remove();
    tooltipDiv = null;
  }
}

/* Font size plus min code */
var sizePlusButton = document.querySelector(".size-plus");
var sizeMinButton = document.querySelector(".size-min");
var pagenumbers = document.querySelectorAll(".pagenumber");

sizePlusButton.addEventListener("click", function() {
  adjustFontSize(1);
});

sizeMinButton.addEventListener("click", function() {
  adjustFontSize(-1);
});

function adjustFontSize(step) {
  pagenumbers.forEach(function(pagenumber) {
    var elements = pagenumber.querySelectorAll("p, span, img");

    elements.forEach(function(element) {
      if (!element.classList.contains("text-arabic") && element.tagName !== "SUP" && !element.classList.contains("voetnoot-p") && !element.classList.contains("sup-pointer")) {
        var currentFontSize = parseFloat(getComputedStyle(element).fontSize);
        var newFontSize = currentFontSize + step;

        // Limit the font size between 15px and 30px
        newFontSize = Math.min(30, Math.max(15, newFontSize));

        element.style.fontSize = newFontSize + "px";
        localStorage.setItem(getLocalStorageKey(element), newFontSize + "px");
      } else {
        if (element.classList.contains("text-arabic")) {
          // Set the Arabic text font size to 28px
          element.style.fontSize = "28px";
          localStorage.setItem(getLocalStorageKey(element), "28px");
        } else if (element.tagName === "SUP" || element.classList.contains("voetnoot-p")) {
          var currentFontSize = parseFloat(getComputedStyle(element).fontSize);
          var newFontSize = currentFontSize + step;

          // Limit the font size between 15px and 30px
          newFontSize = Math.min(30, Math.max(15, newFontSize));

          element.style.fontSize = newFontSize + "px";
          localStorage.setItem(getLocalStorageKey(element), newFontSize + "px");
        } else if (element.classList.contains("sup-pointer")) {
          // Set the font size for sup-pointer class to 15px
          element.style.fontSize = "15px";
          localStorage.setItem(getLocalStorageKey(element), "15px");
        }
      }
    });
  });
}

function getLocalStorageKey(element) {
  return "font-size-" + element.tagName + "-" + Array.from(element.classList).join("-");
}

// Restore font sizes from local storage
pagenumbers.forEach(function(pagenumber) {
  var elements = pagenumber.querySelectorAll("p, span, img, sup");

  elements.forEach(function(element) {
    var localStorageKey = getLocalStorageKey(element);
    var storedFontSize = localStorage.getItem(localStorageKey);

    if (storedFontSize) {
      element.style.fontSize = storedFontSize;
      if (element.classList.contains("text-arabic")) {
        element.style.setProperty("--font-size", storedFontSize);
      }
    } else {
      var defaultFontSize;
      if (element.classList.contains("text-arabic")) {
        defaultFontSize = "28px"; // Set the default font size for Arabic text to 28px
      } else if (element.tagName === "SUP" || element.classList.contains("voetnoot-p")) {
        defaultFontSize = "16px"; // Set the default font size for voetnoot-p class, sup-pointer class, and blz-num class to 16px
      } else if (element.classList.contains("sup-pointer")) {
        defaultFontSize = "15px"; // Set the default font size for sup-pointer class to 15px
      } else if (element.classList.contains("blz-num")) {
        defaultFontSize = "15px"; // Set the default font size for blz-num class to 15px
      } else {
        defaultFontSize = "19px";
      }
      element.style.fontSize = defaultFontSize;
      localStorage.setItem(getLocalStorageKey(element), defaultFontSize);
    }
  });
});

/* Handling scroll to top function when click on scroll to top button */
document.querySelector(".go-to-top-page").addEventListener("click", function(){
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});


/* select option code */
window.addEventListener('DOMContentLoaded', function() {
  const selectElement = document.querySelector('.blz-select');
  const pageElements = Array.from(document.getElementsByClassName('pagenumber'));
  const offset = 5; // Adjust this value as needed

  // Find the starting and ending page numbers dynamically
  const startingPage = parseInt(pageElements[0].getAttribute('id'));
  const endingPage = parseInt(pageElements[pageElements.length - 1].getAttribute('id'));

  function updateSelectOptions() {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;

    const visiblePageId = pageElements
      .filter(function(pageElement) {
        const rect = pageElement.getBoundingClientRect();
        return rect.top <= offset && rect.bottom > offset;
      })
      .map(function(pageElement) {
        return pageElement.getAttribute('id');
      })
      .pop();

    selectElement.innerHTML = ''; // Clear existing options

    for (let i = startingPage; i <= endingPage; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      selectElement.appendChild(option);
    }

    selectElement.value = visiblePageId || startingPage;
  }

  function scrollToPage(pageId) {
    const pageElement = document.getElementById(pageId);
    if (pageElement) {
      pageElement.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
      });
    }
  }

  updateSelectOptions(); // Initial update of select options

  window.addEventListener('scroll', updateSelectOptions); // Update select options on scroll

  selectElement.addEventListener('change', function(event) {
    const selectedPage = event.target.value;
    scrollToPage(selectedPage);
  });
});


// Left sidebar code
document.querySelector(".navbar-bottom .open").addEventListener("click", function() {
  var sidebar = document.querySelector(".sidebar");
  
  if (getComputedStyle(sidebar).marginLeft === "-275px") {
    sidebar.style.marginLeft = "0";
  }
});

document.querySelector(".sluiten").addEventListener("click", function() {
  var sidebar = document.querySelector(".sidebar");
  
  if (getComputedStyle(sidebar).marginLeft === "0px") {
    sidebar.style.marginLeft = "-275px";
  }
});

// Call checkStoredPageId on page load to navigate to the stored page ID
checkStoredPageId();

