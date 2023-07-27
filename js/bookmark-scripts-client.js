if (document.querySelector(".book-mark-page-client")){
  document.querySelector(".book-mark-page-client").addEventListener("click", function() {
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

document.querySelector(".add-book-mark-button").addEventListener("click", function() {
  var bookTitle = currentBook;
  var bookPage = document.querySelector(".blz-select").value;
  var bookUrl = bookUrlJS; // Assuming bookUrlJS is already defined with the appropriate URL

  if (bookPage && !isNaN(bookPage)) {
    var bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];
    var existingBookmarkIndex = bookmarks.findIndex(function(item) {
      return item.title === bookTitle && item.page === bookPage;
    });

    if (existingBookmarkIndex === -1) {
      saveBookmark(bookTitle, bookPage, bookUrl);
      refreshBookmarks();
    } else {
      // alert("Bookmark already exists.");
    }
  }
});

function saveBookmark(title, page, url) {
  var bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];
  bookmarks.push({ title: title, page: page, url: url });
  localStorage.setItem("bookmarks", JSON.stringify(bookmarks));
}

function refreshBookmarks() {
  var bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];
  var bookmarksList = document.querySelector(".sidebar-right ul");
  bookmarksList.innerHTML = "";

  bookmarks.forEach(function(bookmark) {
    var bookmarkItem = document.createElement("li");
    bookmarkItem.classList.add("bookmark-item");

    // Create the anchor tag with the bookmark URL
    var bookmarkLink = document.createElement("a");
    bookmarkLink.classList.add("bookmark-link-page");
    bookmarkLink.href = bookmark.url + '#' + bookmark.page; // Append page to the URL

    bookmarkLink.addEventListener("click", function(event) {
      // Stop event propagation so that the link is not followed when clicking the item
      event.stopPropagation();
      scrollToPage(bookmark.page);
    });

    var bookmarkContent = document.createElement("div");
    bookmarkContent.classList.add("bookmark-content");

    var bookmarkTitle = document.createElement("p");
    bookmarkTitle.classList.add("book-mark-book-title");
    bookmarkTitle.textContent = bookmark.title;

    var bookmarkPageNumber = document.createElement("p");
    bookmarkPageNumber.classList.add("book-mark-book-page-number");
    bookmarkPageNumber.textContent = "Blz. " + bookmark.page;

    var deleteButton = document.createElement("p");
    deleteButton.classList.add("delete-mark");
    deleteButton.innerHTML = "<i class='fa-solid fa-trash delete-bookmark-icon'></i>";
    deleteButton.addEventListener("click", function(event) {
      event.stopPropagation();
      event.preventDefault(); // Prevent default behavior (following the link and refreshing the page)
      deleteBookmark(bookmark);
      refreshBookmarks();
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

function deleteBookmark(bookmark) {
  var bookmarks = JSON.parse(localStorage.getItem("bookmarks")) || [];
  var index = bookmarks.findIndex(function(item) {
    return item.title === bookmark.title && item.page === bookmark.page;
  });
  if (index !== -1) {
    bookmarks.splice(index, 1);
    localStorage.setItem("bookmarks", JSON.stringify(bookmarks));
  }
}

function scrollToPage(pageNumber) {
  var pageId = pageNumber;
  var pageElement = document.getElementById(pageId);
  if (pageElement) {
    pageElement.scrollIntoView();
  }
}

// Call refreshBookmarks on page load to populate the sidebar with existing bookmarks
refreshBookmarks();
