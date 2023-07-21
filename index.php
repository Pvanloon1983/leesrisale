<?php 
  session_start();
  include_once('config/db.php');
  include('includes/header-normal-page.php'); 
?>

  <div class="container">

    <!-- <h1 class="main-title">Welkom bij LeesRisale</h1>
    <p class="text-under-main-title">De plek om online de Nederlandse vertalingen van de Risale-i Nur te lezen.</p> -->
    <div class="books-container">
      <div class="book-item">
        <p class="book-title">
          Het Traktaat over de Natuur
        </p> 
        <div class="lees-button-container">  
          <a href="het-traktaat-over-de-natuur"><button class="lees-button">Lezen</button></a>   
        </div> 
      </div>
      <div class="book-item">
        <p class="book-title">
          Het Traktaat Voor de Zieken
        </p>       
        <div class="lees-button-container">  
          <p class="verschijnt-binnenkort">Verschijnt binnenkort</p>
        </div> 
      </div>
      <div class="book-item">
        <p class="book-title">
          Afwegingen van Geloof & Ongeloof
        </p>  
        <div class="lees-button-container">  
          <p class="verschijnt-binnenkort">Verschijnt binnenkort</p>
        </div>    
      </div>
      <div class="book-item">
        <p class="book-title">
          De Mirakelen van Ahmed
        </p>    
        <div class="lees-button-container">  
          <p class="verschijnt-binnenkort">Verschijnt binnenkort</p>
        </div>    
      </div>
      <div class="book-item">
        <p class="book-title">
          De Traktaten over de Ramadan, Bezuiniging & Dankbetuiging
        </p>    
        <div class="lees-button-container">  
          <p class="verschijnt-binnenkort">Verschijnt binnenkort</p>
        </div>    
      </div>
      <div class="book-item">
        <p class="book-title">
          Geloofswaarheden
        </p>    
        <div class="lees-button-container">  
          <p class="verschijnt-binnenkort">Verschijnt binnenkort</p>
        </div>    
      </div>
      <div class="book-item">
        <p class="book-title">
          Broederschap & Oprechtheid
        </p>    
        <div class="lees-button-container">  
          <p class="verschijnt-binnenkort">Verschijnt binnenkort</p>
        </div>    
      </div>
    </div>
  </div> 

<?php include('includes/footer-normal-page.php'); ?>