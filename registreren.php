<?php
session_start();
include_once('config/db.php');

// Initialize error message variable
$errorMessage = '';
$emailValue = '';
$nameValue = '';

// Process registration form submission
// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if email address and name are empty
    if (empty($email) && empty($name)) {
        $errorMessage = "E-mailadres en naam mogen niet leeg zijn.";
    }
    // Check if email address is empty
    elseif (empty($email)) {
        $errorMessage = "Het e-mailadres mag niet leeg zijn.";
    }
    // Check if name is empty
    elseif (empty($name)) {
        $errorMessage = "De naam mag niet leeg zijn.";
    }
    // Check if password and confirm password match
    elseif ($password !== $confirmPassword) {
        $errorMessage = "De ingevoerde wachtwoorden komen niet overeen.";
    }
    // Check if password is at least 8 characters long
    elseif (strlen($password) < 8) {
        $errorMessage = "Het wachtwoord moet minimaal 8 tekens bevatten.";
    }
    // All checks passed, proceed with registration
    else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (email, name, password) VALUES (:email, :name, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            // Set success message in session variable
            session_start();
            $_SESSION['registration_success'] = true;

            // Redirect to login page
            header("Location: inloggen");
            exit();
        } else {
            // echo "Error: " . $stmt->errorInfo()[2];
            // Display error message and retain email and name values
            $errorMessage = "Er is een fout opgetreden bij het registreren. Probeer het later opnieuw.";
            $emailValue = $email; // Retain the email value
            $nameValue = $name; // Retain the name value
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
    <div class="error-message"><?php echo $errorMessage; ?></div>
      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" name="email" required value="<?php echo htmlspecialchars($emailValue); ?>">
      </div>
      <div class="form-group">
        <label for="name">Naam</label>
        <input type="text" name="name" required value="<?php echo htmlspecialchars($nameValue); ?>">
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
      <p class="account-vraag">Al een account? <a href="/inloggen">Inloggen</a></p>      
    </form>

  </div> 

<?php include('includes/footer-normal-page.php'); ?>