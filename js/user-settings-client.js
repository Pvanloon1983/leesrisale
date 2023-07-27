var sizePlusButton = document.querySelector(".size-plus");
var sizeMinButton = document.querySelector(".size-min");
var resetButton = document.querySelector(".reset-font-sizes");
var pagenumbers = document.querySelectorAll(".pagenumber");

sizePlusButton.addEventListener("click", function () {
  adjustFontSize("bigger");
});

sizeMinButton.addEventListener("click", function () {
  adjustFontSize("smaller");
});

resetButton.addEventListener("click", function() {
  resetFontSizes();
});

function adjustFontSize(direction) {
  pagenumbers.forEach(function (pagenumber) {
    var elements = pagenumber.querySelectorAll("p, span, img, h3");

    elements.forEach(function (element) {
      var currentFontSize = parseFloat(getComputedStyle(element).fontSize);

      // Get the initial font size from the data-original-font-size attribute or computed style if not available
      var initialFontSize = parseFloat(element.getAttribute("data-original-font-size")) || currentFontSize;

      var newFontSize;
      if (direction === "bigger") {
        newFontSize = currentFontSize + 1; // Increase the font size by 1 step
        newFontSize = Math.min(40, newFontSize); // Limit the font size to a maximum of 40px
      } else if (direction === "smaller") {
        newFontSize = currentFontSize - 1; // Decrease the font size by 1 step
        newFontSize = Math.max(14, newFontSize); // Limit the font size to a minimum of 14px
      } else {
        return; // If no valid direction is provided, exit the function without making any changes
      }

      element.style.fontSize = newFontSize + "px";
      localStorage.setItem(getLocalStorageKey(element), newFontSize + "px");
      element.setAttribute("data-original-font-size", initialFontSize + "px"); // Update the original font size attribute

      // Adjust the font size of SUP elements within .voetnoot-p
      if (element.classList.contains("voetnoot-p")) {
        var supElements = element.querySelectorAll("sup");
        supElements.forEach(function (supElement) {
          // Set the minimum font size for SUP elements to 13px
          var currentSupFontSize = parseFloat(getComputedStyle(supElement).fontSize);
          var newSupFontSize;
          if (direction === "bigger") {
            newSupFontSize = currentSupFontSize + 1; // Increase the font size by 1 step
            newSupFontSize = Math.min(17, newSupFontSize); // Limit the font size to a maximum of 17px
          } else if (direction === "smaller") {
            newSupFontSize = currentSupFontSize - 1; // Decrease the font size by 1 step
            newSupFontSize = Math.max(13, newSupFontSize); // Limit the font size to a minimum of 13px
          } else {
            return; // If no valid direction is provided, exit the function without making any changes
          }

          supElement.style.fontSize = newSupFontSize + "px";
          localStorage.setItem(getLocalStorageKey(supElement), newSupFontSize + "px");
          supElement.setAttribute("data-original-font-size", currentSupFontSize + "px"); // Update the original font size attribute
        });
      }
      // Add other conditions for handling specific elements if required
    });
  });
}


function resetFontSizes() {
  // Remove all keys starting with "font-size" from local storage
  Object.keys(localStorage).forEach(function (key) {
    if (key.startsWith("font-size")) {
      localStorage.removeItem(key);
    }
  });

  pagenumbers.forEach(function (pagenumber) {
    var elements = pagenumber.querySelectorAll("p, span, img, h3");
    elements.forEach(function (element) {
      var localStorageKey = getLocalStorageKey(element);
      localStorage.removeItem(localStorageKey);

      // Remove the data-original-font-size attribute
      element.removeAttribute("data-original-font-size");

      // Remove the font-size style from the element
      element.style.removeProperty("font-size");
      element.style.removeProperty("--font-size");
    });
  });

  // Remove the currentPageId from local storage
  localStorage.removeItem("currentPageId");

  // Reload the page after removing font sizes from the local storage
  location.reload();
}

// Function to remove font size style from SUP elements within .voetnoot-p
function setSupFontSizeInVoetnootP() {
  var voetnootPElems = document.querySelectorAll(".voetnoot-p");
  voetnootPElems.forEach(function (voetnootPElem) {
    var supElements = voetnootPElem.querySelectorAll("sup");
    supElements.forEach(function (supElement) {
      supElement.style.removeProperty("font-size"); // Remove the fixed font size style
      supElement.removeAttribute("data-original-font-size"); // Remove the original font size attribute
    });
  });
}

// Call setSupFontSizeInVoetnootP on page load to ensure correct font size for SUP within .voetnoot-p
document.addEventListener("DOMContentLoaded", setSupFontSizeInVoetnootP);

function getLocalStorageKey(element) {
  return "font-size-" + element.tagName.toLowerCase() + "-" + Array.from(element.classList).join("-");
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
      element.setAttribute("data-original-font-size", storedFontSize); // Store the original font size in the attribute
    } else {
      var defaultFontSize;
      if (element.classList.contains("text-arabic")) {
        defaultFontSize = "28px"; // Set the default font size for Arabic text to 28px
      } else if (element.classList.contains("voetnoot-p")) {
        defaultFontSize = "16px"; // Set the default font size for voetnoot-p class to 16px
      } else if (element.classList.contains("sup-pointer") || element.classList.contains("blz-num")) {
        defaultFontSize = "15px"; // Set the default font size for sup-pointer class and blz-num class to 15px
      } else {
        defaultFontSize = "19px";
      }
      element.style.fontSize = defaultFontSize;
      localStorage.setItem(getLocalStorageKey(element), defaultFontSize);
      element.setAttribute("data-original-font-size", defaultFontSize); // Store the original font size in the attribute
    }


  });
});

document.addEventListener("DOMContentLoaded", function () {
  var pagenumberElements = document.querySelectorAll(".pagenumber");
  var blzSelect = document.getElementById("bladzijdes-select");
  var previousScrollPosition = 0;

  // Function to check if a page is in view and update the local storage
  function updateCurrentPageInView() {
    for (var i = 0; i < pagenumberElements.length; i++) {
      var pagenumber = pagenumberElements[i];
      var bounding = pagenumber.getBoundingClientRect();

      if (bounding.top >= 0 && bounding.top <= 30) {
        var pageId = pagenumber.id;
        if (blzSelect.value !== pageId) {
          blzSelect.value = pageId; // Update the select tag if the value changed
        }
        localStorage.setItem("currentPageId" + "-" + currentBookStore, pageId);
        break;
      }
    }
  }

  // Function to scroll to the correct page div
  function scrollToSelectedPage() {
    var storedPageId = localStorage.getItem("currentPageId" + "-" + currentBookStore);
    if (storedPageId) {
      var elementToScroll = document.getElementById(storedPageId);
      if (elementToScroll) {
        var scrollOffset = elementToScroll.offsetTop - 0;
        window.scrollTo({ top: scrollOffset, behavior: "smooth" });
      }
    }
  }

  // Event listener to track changes in the select tag and update the local storage
  blzSelect.addEventListener("change", function () {
    var selectedPageId = blzSelect.value;
    localStorage.setItem("currentPageId" + "-" + currentBookStore, selectedPageId);
    var elementToScroll = document.getElementById(selectedPageId);
    if (elementToScroll) {
      elementToScroll.scrollIntoView();
    }
  });

  // Check if there is a stored currentPageId in local storage and update the blz-select element
  var storedPageId = localStorage.getItem("currentPageId" + "-" + currentBookStore);
  if (storedPageId) {
    blzSelect.value = storedPageId;
    scrollToSelectedPage(); // Scroll to the correct page div after the font sizes are loaded
  }

  // Event listener to track scroll position and update the current page in view
  window.addEventListener("scroll", function () {
    var currentScrollPosition = window.scrollY || document.documentElement.scrollTop;

    // Check if scrolling direction is down or up
    if (currentScrollPosition > previousScrollPosition) {
      // Scrolling down
      updateCurrentPageInView();
    } else {
      // Scrolling up
      var currentPageId = blzSelect.value;
      localStorage.setItem("currentPageId" + "-" + currentBookStore, currentPageId);
    }

    // Update previous scroll position
    previousScrollPosition = currentScrollPosition;
  });
});
