<?php
session_start();
include_once('config/db.php');

// Check if the user has a valid reset token
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Token is valid, allow the user to reset the password
        $_SESSION['reset_token'] = $token;
    } else {
        // Invalid token, redirect to an error page or home page
        header("Location: invalid_token.php");
        exit();
    }
} else {
    // No token found, redirect to an error page or home page
    header("Location: invalid_token.php");
    exit();
}

// Function to display error messages
function displayErrorMessage()
{
    if (isset($_SESSION['reset_error'])) {
        echo '<div class="error-message">' . $_SESSION['reset_error'] . '</div>';
        unset($_SESSION['reset_error']);
    }
}

// Check if the form is submitted and the passwords match
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the new password and confirm password from the form
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the password fields (you can add more validation if needed)
    if ($newPassword !== $confirmPassword) {
        $_SESSION['reset_error'] = "Wachtwoorden komen niet overeen.";
        // Redirect back to the same page to display the error message
        header("Location: wachtwoord-resetten.php?token=" . $_SESSION['reset_token']);
        exit();
    } elseif (strlen($newPassword) < 8) {
        $_SESSION['reset_error'] = "Wachtwoord moet minimaal 8 karakters lang zijn.";
        // Redirect back to the same page to display the error message
        header("Location: wachtwoord-resetten.php?token=" . $_SESSION['reset_token']);
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the user's password and reset_token in the database
    $token = $_SESSION['reset_token'];
    $stmt = $conn->prepare("UPDATE users SET password = :password, reset_token = NULL WHERE reset_token = :token");
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    // Password reset successful, set success message
    $_SESSION['reset_success'] = true;

    // Redirect to the login page
    header("Location: inloggen.php");
    exit();
}
?>

<?php include('includes/header-normal-page.php'); ?>

<div class="container">
    <h1 style="text-align:center;" class="main-title">Wachtwoord resetten</h1>
    <?php
    // Check again if there is a valid token before displaying the form
    if (isset($_SESSION['reset_token']) && !empty($_SESSION['reset_token'])) {
        // Display the form only when there is a valid token
        displayErrorMessage();
        ?>
        <form class="form" action="" method="post">
            <div class="form-group">
                <label for="new_password">Nieuw wachtwoord:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Wachtwoord bevestigen:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div class="form-group submit-button-form-group">
                <input type="submit" value="Verzenden">
            </div>
        </form>
    <?php } ?>
</div>

<?php include('includes/footer-normal-page.php'); ?>
