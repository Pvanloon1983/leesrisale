
<!DOCTYPE html>
<html lang="nl"> <!-- Specify the language as Dutch (Nederlands) -->
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LeesRisale | Lees Risale-i Nur online</title>
  <meta name="description" content="De Risale-i Nur is een ware spirituele tafsir van de Qur’an. Op een ongehoorde wijze worden de lastigste geloofskwesties in deze tafsir behandeld.">
  <meta property="og:title" content="LeesRisale">
  <meta property="og:description" content="De Risale-i Nur is een ware spirituele tafsir van de Qur’an. Op een ongehoorde wijze worden de lastigste geloofskwesties in deze tafsir behandeld.">
  <meta property="og:image" content="images/leesrisale_logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/style-normal-page.css?v=13">

  <!-- Add the icon link here -->
  <link rel="icon" href="/images/leesrisale_icon.png" type="image/x-icon">
</head>
<body>

<nav class="navbar">
    <div class="nav-bar-container">
        <div class="logo">
            <a href="/"><img src="../images/leesrisale_logo.png" alt=""></a>
        </div>
        <ul class="menu">       
          <li><a href="/"><i class="fa-solid fa-house"></i></a></li>
          <li><a href="/zoeken"><i class="fa-solid fa-magnifying-glass"></i></i></a></li>
          <?php
          // Check if the user is logged in using session or remember me cookie
          if (isset($_SESSION['user_id'])) {
              // User is logged in via session
              echo '<li><a href="logout">Uitloggen</a></li>';
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
                  echo '<li><a href="logout">Uitloggen</a></li>';
              } else {
                  echo '<li><a href="inloggen">Inloggen</a></li>';
              }
          } else {
              echo '<li><a href="inloggen">Inloggen</a></li>';
          }
          ?>
      </ul>
    </div>
</nav>