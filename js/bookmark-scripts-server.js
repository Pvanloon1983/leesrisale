// Side bar right for bookmarks (server side)
if (document.querySelector(".book-mark-page-server")) {
  document.querySelector(".book-mark-page-server").addEventListener("click", function() {
    var sidebar = document.querySelector(".sidebar-right");
  
    if (getComputedStyle(sidebar).marginRight === "-275px") {
      sidebar.style.marginRight = "0";
    }
  });
  
  document.querySelector(".sluiten-right").addEventListener("click", function() {
    var sidebar = document.querySelector(".sidebar-right");
  
    if (getComputedStyle(sidebar).marginRight === "0px") {
      sidebar.style.marginRight = "-275px";
    }
  });
}

// Add bookmark
document.querySelector(".add-book-mark-button").addEventListener("click", function() {
  //console.log("Bookmark button clicked");
  var bookTitle = currentBook;
  var bookPage = document.querySelector(".blz-select").value;
  var bookUrl = bookUrlJS; // Assuming bookUrlJS is already defined with the appropriate URL

  addBookmarkToDB(bookTitle, bookPage, bookUrl);
});

async function addBookmarkToDB(title, page, url) {

  var pageNumber = parseInt(page, 10);

  // Create an object to send in the request body
  var data = { title: title, page: pageNumber, url: url };

  //console.log("Data being sent to server:", data); // Add this line for logging

  try {
    // Make a POST request using Axios
    const response = await axios.post('../includes/add-book-mark.php', data, {
      headers: {
        'Content-Type': 'application/json'
      }
    });

    //console.log("Server response:", response.data); // Add this line for logging

    if (response.status === 200) {
      //console.log("Bookmark added successfully");
      // Refresh the bookmarks in the sidebar by fetching the updated data from the server
      fetchBookmarks();
    } else if (response.status === 400 && response.data.error && response.data.error === 'Bookmark with the same combination already exists') {
      // Display a user-friendly error message for duplicate bookmark
      console.error('Duplicate bookmark: You have already bookmarked this page.');
    } else {
      // Bookmark could not be added, handle the error here if needed
      console.error('Bookmark could not be added');
    }
  } catch (error) {
    // Handle the error (e.g., show error message, error handling)
    console.error('Error:', error);
  }
}

function fetchBookmarks() {
  // Make a GET request using fetch API to retrieve bookmarks data from the server
  fetch('../includes/fetch-book-marks.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      // Update the bookmarks list in the sidebar using the retrieved data
      updateBookmarksList(data);
    })
    .catch(error => {
      // Handle the error (e.g., show error message, error handling)
      console.error('Error:', error);
    });
}

function updateBookmarksList(bookmarksData) {
  // Clear the existing bookmarks list
  var bookmarksList = document.querySelector(".sidebar-right ul");
  bookmarksList.innerHTML = "";

  // Populate the bookmarks list with the new data
  bookmarksData.forEach(function (bookmark) {
    // Create the anchor tag with the bookmark URL (boek_url)
    var bookmarkLink = document.createElement("a");
    bookmarkLink.href = bookmark.boek_url + '#' + bookmark.bladzijde; // Append bladzijde to the boek_url
    bookmarkLink.classList.add("bookmark-link-page"); // Add the class "bookmark-link-page" to the anchor tag

    var bookmarkItem = document.createElement("li"); // Create the li element for the bookmark item
    bookmarkItem.classList.add("bookmark-item");
    bookmarkItem.dataset.id = bookmark.bladzijde; // Set the 'data-id' attribute to the bookmark id

    var bookmarkContent = document.createElement("div"); // Create a div to wrap the bookmark content
    bookmarkContent.classList.add("bookmark-content");

    var bookmarkTitle = document.createElement("p");
    bookmarkTitle.classList.add("book-mark-book-title");
    bookmarkTitle.textContent = bookmark.boek;

    var bookmarkPageNumber = document.createElement("p");
    bookmarkPageNumber.classList.add("book-mark-book-page-number");
    bookmarkPageNumber.textContent = "Blz. " + bookmark.bladzijde;

    var deleteButton = document.createElement("p");
    deleteButton.classList.add("delete-mark");
    deleteButton.innerHTML = "<i class='fa-solid fa-trash delete-bookmark-icon'></i>";

    deleteButton.addEventListener("click", function (event) {
      event.stopPropagation();
      event.preventDefault(); // Prevent default behavior (following the link and refreshing the page)
      deleteBookmarkFromDB(bookmark);
    });

    // Append title and page number to the bookmark content div
    bookmarkContent.appendChild(bookmarkTitle);
    bookmarkContent.appendChild(bookmarkPageNumber);

    // Append the bookmark content div to the list item
    bookmarkItem.appendChild(bookmarkContent);
    bookmarkItem.appendChild(deleteButton); // Append the delete button to the list item

    // Append the list item to the anchor tag
    bookmarkLink.appendChild(bookmarkItem);

    bookmarkLink.addEventListener("click", function () {
      scrollToPage(bookmark.bladzijde);
    });

    bookmarksList.appendChild(bookmarkLink);
  });
}

async function deleteBookmarkFromDB(bookmark) {
  //console.log(bookmark);
  // Make a POST request using fetch API to delete the bookmark from the server
  fetch('../includes/delete-book-mark.php', {
    method: 'POST',
    body: JSON.stringify({ id: bookmark.id }),
    headers: {
      'Content-Type': 'application/json'
    }
  }).then(response => {
    if (response.ok) {
      //console.log("Bookmark deleted from the database");
      fetchBookmarks(); // Refresh the bookmarks in the sidebar after successful deletion
    } else {
      console.error('Bookmark could not be deleted from the database');
    }
  }).catch(error => {
    console.error('Error:', error);
  });
}

function scrollToPage(pageNumber) {
  var pageId = pageNumber;
  var pageElement = document.getElementById(pageId);
  if (pageElement) {
    pageElement.scrollIntoView();
  }
}

// Call fetchBookmarks on page load to populate the sidebar with existing bookmarks
fetchBookmarks();
