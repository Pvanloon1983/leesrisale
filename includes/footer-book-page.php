<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>

<script>
  let userIdFromServer = <?php echo isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0; ?>;
</script>

<script src="../js/main-scripts.js?v=11"></script>

<?php 

// Check if the user is logged in using session or remember me cookie
if (isset($_SESSION['user_id'])) {
  // User is logged in via session
  echo '<script src="../js/bookmark-scripts-server.js?v=11"></script>';
  echo '<script src="../js/user-settings-server.js?v=11"></script>';
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
        echo '<script src="../js/bookmark-scripts-server.js?v=11"></script>';
        echo '<script src="../js/user-settings-server.js?v=11"></script>';
    } else {
        echo '<script src="../js/bookmark-scripts-client.js?v=11"></script>';
        echo '<script src="../js/user-settings-client.js?v=11"></script>';
    }
} else {
    echo '<script src="../js/bookmark-scripts-client.js?v=11"></script>';
    echo '<script src="../js/user-settings-client.js?v=11"></script>';
}

?>

</body>
</html>