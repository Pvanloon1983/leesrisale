<?php
session_start();
include_once('config/db.php');

// Initialize error message variable
$errorMessage = '';
$emailValue = '';

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if username or email already exist
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $errorMessage = "Het e-mailadres bestaat al.";
        $emailValue = $email; // Retain the email value
    } elseif ($password !== $confirmPassword) {
        $errorMessage = "De ingevoerde wachtwoorden komen niet overeen.";
        $emailValue = $email; // Retain the email value
    } elseif (strlen($password) < 8) {
        $errorMessage = "Het wachtwoord moet minimaal 8 tekens bevatten.";
        $emailValue = $email; // Retain the email value
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            // Set success message in session variable
            session_start();
            $_SESSION['registration_success'] = true;

            // Redirect to login page
            header("Location: inloggen");
            exit();
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
            $emailValue = $email; // Retain the email value
        }
    }
}

// Close the database connection
$conn = null;
?>

<?php include('includes/header-normal-page.php'); ?>

  <div class="container">
    <h1 class="main-title">Registreren</h1>
    <!-- <p class="text-under-main-title">De plek om online de Nederlandse vertalingen van de Risale-i Nur te lezen.</p> -->

    <form class="form" method="post" action="registreren">
      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" required value="<?php echo $emailValue; ?>">
      </div>
      <div class="form-group">
        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Wachtwoord bevestigen:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
      </div>
      <div class="form-group">
        <input type="submit" value="Registeren">
      </div>
      <div class="error-message"><?php echo $errorMessage; ?></div>
    </form>

  </div> 

<?php include('includes/footer-normal-page.php'); ?>