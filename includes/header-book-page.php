<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LeesRisale | <?php echo $booktitle; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/style-books.css?v=12">
</head>
<body>

  <nav class="navbar-bottom">
    <div class="navbar-bottom-container">
      <div class="bottom-left-functions">
        <span class="inhoudsopgave-toggle">
          <span class="open"><i class="fa-solid fa-angles-right"></i></span>
        </span>

        <?php
          // Check if the user is logged in using session or remember me cookie
          if (isset($_SESSION['user_id'])) {
              // User is logged in via session
              echo '<i class="fa-solid fa-bookmark book-mark-page book-mark-page-server"></i>';
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
                  echo '<i class="fa-solid fa-bookmark book-mark-page book-mark-page-server"></i>';
              } else {
                  echo '<i class="fa-solid fa-bookmark book-mark-page book-mark-page-client"></i>';
              }
          } else {
              echo '<i class="fa-solid fa-bookmark book-mark-page book-mark-page-client"></i>';
          }
          ?>
       
        
        <a href="/" class="back-to-home-link"><i class="fa-solid fa-house back-to-home-page"></i></a>
      </div>

      <div class="bottom-functions-right">  
        <div class="search-container">
          <!-- <input class="bottom-search" type="text" autocomplete="on" id="searchInput" placeholder="Zoeken...">
          <div id="clearIcon">&times;</div> -->
          <a href="/zoeken"><button class="search-button-link">Zoeken... <i class="fa-solid fa-magnifying-glass"></i></button></a>       
        </div>      
      </div>
      
    </div>
  </nav>