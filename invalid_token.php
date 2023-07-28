<?php
session_start();
include_once('config/db.php');

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
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']) ? $_POST['remember_me'] : '';

    // Retrieve user from the database based on the email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errorMessage = "Het ingevoerde e-mailadres bestaat niet.";
        $emailValue = $email; // Store the entered email value
    } elseif (!password_verify($password, $user['password'])) {
        $errorMessage = "Ongeldig wachtwoord.";
        $emailValue = $email; // Store the entered email value
    } else {
        // Password is correct, log in the user
        $_SESSION['user_id'] = $user['id'];

        if ($rememberMe) {
            // Generate a random token
            $token = bin2hex(random_bytes(32));

            // Store the token in the database
            $stmt = $conn->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();

            $_SESSION['remember_token'] = $token;

            // Set the token as a cookie
            setcookie('remember_token', $token, time() + (86400 * 30), '/');
        }

        header("Location: /");
        exit();
    }
}

// Close the database connection
$conn = null;
?>
<?php include('includes/header-normal-page.php'); ?>

<div class="container">
    <h1 style="text-align:center;" class="main-title">Ongeldig resettoken</h1>
    <p style="text-align:center;">Het resettoken is ongeldig of verlopen. Probeer het opnieuw of vraag een nieuw wachtwoord aan.</p>
    <p style="text-align:center;" class="account-vraag">Terug naar <a href="/">Home</a></p>
</div>

<?php include('includes/footer-normal-page.php'); ?>
