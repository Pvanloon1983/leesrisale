<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>

<script>
  let userIdFromServer = <?php echo isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0; ?>;
</script>

<script src="../js/main-scripts.js?v=12"></script>

<?php 

// Check if the user is logged in using session or remember me cookie
if (isset($_SESSION['user_id'])) {
  // User is logged in via session
  echo '<script src="../js/bookmark-scripts-server.js?v=12"></script>';
  echo '<script src="../js/user-settings-server.js?v=12"></script>';
} elseif (isset($_COOKIE['remember_token']) && !empty($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    // Retrieve user from the database based on the remember token
    $stmt = $conn->prepare("SELECT * FROM users WHERE remember_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // User is logged in via remember me cookie
        $_SESSION['user_id'] = $user['id'];
        echo '<script src="../js/bookmark-scripts-server.js?v=12"></script>';
        echo '<script src="../js/user-settings-server.js?v=12"></script>';
    } else {
        echo '<script src="../js/bookmark-scripts-client.js?v=12"></script>';
        echo '<script src="../js/user-settings-client.js?v=12"></script>';
    }
} else {
    echo '<script src="../js/bookmark-scripts-client.js?v=12"></script>';
    echo '<script src="../js/user-settings-client.js?v=12"></script>';
}

?>

<!-- Add this script to the target page (het-traktaat-over-de-natuur.php) -->
<script>
  // Function to scroll to the target element based on the URL hash
  function scrollToTargetElement() {
    const urlParams = new URLSearchParams(window.location.hash.substring(1));
    const scrollToElement = urlParams.get('zoekbladzijde');

    if (scrollToElement) {
      const targetElement = document.getElementById(scrollToElement);
      if (targetElement) {
        targetElement.scrollIntoView({ behavior: 'smooth' });
      }
    }
  }

  // Call the function once the DOM content is loaded
  document.addEventListener('DOMContentLoaded', () => {
    scrollToTargetElement();
  });

  // Scroll to the target element again after a short delay to ensure smooth scrolling
  setTimeout(scrollToTargetElement, 500);
</script>


</body>
</html>