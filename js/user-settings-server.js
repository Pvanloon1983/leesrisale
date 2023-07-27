// Updated JavaScript code with modifications
var sizePlusButton = document.querySelector(".size-plus");
var sizeMinButton = document.querySelector(".size-min");
var resetButton = document.querySelector(".reset-font-sizes");
var pagenumbers = document.querySelectorAll(".pagenumber");

// JavaScript object to store the font size adjustments
var fontSizesData = {};

sizePlusButton.addEventListener("click", function () {
  adjustFontSize("bigger");
});

sizeMinButton.addEventListener("click", function () {
  adjustFontSize("smaller");
});

resetButton.addEventListener("click", function () {
  console.log("User ID from server:", userIdFromServer);
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
  // Remove font sizes from local storage
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

  // Send the AJAX request to remove font sizes from the database
  var formData = new FormData();
  formData.append("user_id", userIdFromServer);

  axios
    .post("../includes/remove_font_size.php", formData)
    .then(function (response) {
      console.log("Server Response:", response.data);
      // Reload the page after successfully removing font sizes from the database
      location.reload();
    })
    .catch(function (error) {
      console.error("Error removing font sizes from the database:", error);
    });
}


// Function to send font sizes to the server and save in the database
// Function to save font sizes to the database
function saveFontSizesToDatabase(fontSizesData) {
  var formData = new FormData();
  formData.append("user_id", userIdFromServer);
  formData.append("font_sizes_data", JSON.stringify(fontSizesData));

  // Make an AJAX request to the server-side PHP script
  axios
    .post("../includes/save_all_font_sizes.php", formData)
    .then(function (response) {
      console.log("Font sizes saved to database:", response.data);
    })
    .catch(function (error) {
      console.error("Error saving font sizes to database:", error);
    });
}

// Event listener to save font sizes when the user leaves the page
window.addEventListener("beforeunload", function (event) {
  var fontSizesData = [];

  pagenumbers.forEach(function (pagenumber) {
    var elements = pagenumber.querySelectorAll("p, span, img, h3");

    elements.forEach(function (element) {
      var originalFontSize = element.getAttribute("data-original-font-size");
      if (originalFontSize) {
        var tagName = element.tagName.toLowerCase();
        var classNames = Array.from(element.classList).join(" ");
        var fontSize = element.style.fontSize;
        fontSizesData.push({ tag_name: tagName, class_names: classNames, font_size: fontSize });
      }
    });
  });

  // Save all the font sizes to the database
  saveFontSizesToDatabase(fontSizesData);
});

// Function to load font sizes from the database
function loadFontSizesFromDatabase() {
  // Make an AJAX request to the server-side PHP script to get font sizes
  axios
    .post("../includes/get_font_sizes.php", { user_id: userIdFromServer })
    .then(function (response) {
      var fontSizes = response.data;
      // Check if the response is valid JSON
      if (Array.isArray(fontSizes)) {
        for (var i = 0; i < fontSizes.length; i++) {
          var font = fontSizes[i];
          var selector = font.tag_name;

          if (font.class_names.trim() !== "") {
            selector += "." + font.class_names.replace(/\s+/g, ".");
          }

          var elements = document.querySelectorAll(selector);
          elements.forEach(function (element) {
            if (element.classList.contains("text-arabic") && element.tagName.toLowerCase() === "span") {
              // Use a more specific selector for .text-arabic
              element.style.fontSize = font.font_size;
            } else {
              element.style.fontSize = font.font_size;
            }

            // Store the original font size in the data-original-font-size attribute
            element.setAttribute("data-original-font-size", font.font_size);
          });
        }
      } else {
        console.error("Error loading font sizes from database: Invalid JSON response");
      }
    })
    .catch(function (error) {
      console.error("Error loading font sizes from database:", error);
    });
}

// Call the function to load font sizes when the page is ready
document.addEventListener("DOMContentLoaded", function () {
  loadFontSizesFromDatabase();

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
