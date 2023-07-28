<?php
session_start();
include_once('config/db.php');
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

// Initialize error message variable and email value
$errorMessage = '';
$emailValue = '';

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    // Retrieve user from the database based on the email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Email not found in the database, display error message
        $errorMessage = "Het ingevoerde e-mailadres bestaat niet.";
        $emailValue = $email; // Store the entered email value
    } else {
        // Email found, proceed with password reset logic

        function getBaseUrl() {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            return $protocol . '://' . $host;
        }
        
        // Voorbeeldgebruik:
        $baseUrl = getBaseUrl();

        // Generate a random token
        $token = bin2hex(random_bytes(32));

        // Store the token in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = :token WHERE id = :id");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $user['id']);
        $stmt->execute();

        // Send the reset token to the user's email using PHPMailer
        $mail = new PHPMailer(true);

        // SMTP configuration (You need to set up your SMTP server details here)
        $mail->isSMTP();
        $mail->Host       = 'mail.leesrisale.nl';  // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'no-reply@leesrisale.nl';     // Your SMTP username
        $mail->Password   = '5#LiRGm72mibaGY';     // Your SMTP password
        $mail->SMTPSecure = 'tls';               // Use 'tls' or 'ssl' (depends on your SMTP server)
        $mail->Port       = 587;                 // Port number (depends on your SMTP server)

        // Sender and recipient details
        $mail->setFrom('no-reply@leesrisale.nl', 'LeesRisale');
        $mail->addAddress($email, $user['name']);  // Replace 'name' with the user's name from the database

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Wachtwoord resetten';
        $mail->Body    = "Hallo ".$user['name'].",<br><br>" .
            "Klik op de volgende link om jouw wachtwoord te resetten: ".$baseUrl."/wachtwoord-resetten.php?token=$token" . "<br><br>" .
            "Als je niet hebt gevraagd om het wachtwoord te resetten, negeer dan deze e-mail." . "<br><br>" .
            "Met vriendelijke groet," . "<br>" .
            "LeesRisale.nl";
        
        // Plain text version with line breaks
        $mail->AltBody = "Hallo ".$user['name']."," . PHP_EOL . PHP_EOL .
            "Klik op de volgende link om jouw wachtwoord te resetten: ".$baseUrl."/wachtwoord-resetten.php?token=$token" . PHP_EOL . PHP_EOL .
            "Als je niet hebt gevraagd om het wachtwoord te resetten, negeer dan deze e-mail." . PHP_EOL . PHP_EOL .
            "Met vriendelijke groet," . PHP_EOL .
            "LeesRisale.nl";

        // Send the email
        try {
            $mail->send();
            // Email sent successfully
            $_SESSION['reset_success'] = true;
            header("Location: wachtwoord-reset-succes.php");
            exit();
        } catch (Exception $e) {
            // Error occurred while sending the email
            $_SESSION['reset_success'] = false;
            header("Location: invoer_wachtwoord_voor_reset.php");
            exit();
        }
    }
}

// Close the database connection
$conn = null;
?>

<?php include('includes/header-normal-page.php'); ?>

<div class="container">
    <h1 class="main-title">Wachtwoord vergeten?</h1>
    <?php if (!empty($errorMessage)) : ?>
        <p class="error-message"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form class="form" method="post" action="invoer_wachtwoord_voor_reset.php">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" required value="<?php echo htmlspecialchars($emailValue); ?>">
        </div>
        <div class="form-group">
            <input type="submit" value="Verzenden">
        </div>
        <p class="account-vraag">Terug naar <a href="/">home</a></p> 
    </form>
</div>

<?php include('includes/footer-normal-page.php'); ?>
