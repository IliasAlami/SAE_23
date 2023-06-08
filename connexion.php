<!DOCTYPE html>
<html lang="fr">
 <head>
  <title>SAE 23</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="DAUDIGNON" />
  <meta name="description" content="Portfolio SAE 24" />
  <meta name="keywords" content="HTML, CSS, Portfolio" />
  <link rel="stylesheet" href="./styles/style.css" />
  <link rel="stylesheet" href="./styles/rwd.css" />
  <link rel="stylesheet" href="./styles/Hamburger.css" />
 </head>
 <body>
 
  <header>



   <!-- <div class="nav">
      <input type="checkbox" id="nav-check">
      <div class="nav-header">
      </div>
      <div class="nav-btn">
        <label for="nav-check">
          <span></span>
          <span></span>
          <span></span>
        </label>
      </div>
      
      <div class="nav-links">
        <a href="index.html" class="first">Accueil</a>
        <a href="administration.html">Administration</a>
        <a href="gestion.html">Gestion</a>
        <a href="consultation.html">Consultation</a>
        <a href="gestion_de_projet.html">Gestion de projet</a>
      </div>
    </div>-->




     <div class="nav">
      <input type="checkbox" id="nav-check">
      <div class="nav-btn">
        <label for="nav-check">
          <span></span>
          <span></span>
          <span></span>
        </label>
      </div>
      <nav class="nav-links">
          <ul>
            <li><a href="index.html" class="first">Accueil</a></li>
            <li><a href="administration.html">Administration</a></li>
            <li><a href="gestion.html">Gestion</a></li>
            <li><a href="consultation.html">Consultation</a></li>
            <li><a href="gestion_de_projet.html">Gestion de projet</a></li>
          </ul>
      </nav>
    </div>
  </header>
  <section class="sujet">
    <h1> CONNEXION </h1>
    <section class="bulle">
      <form action="login.php" method="POST">
        <p class="justify">
          <strong>Utilisateurs</strong> <br> <br>
        </p>
        <label><b>Nom d'utilisateur</b></label><br>
        <input type="text" placeholder="Entrer le nom d'utilisateur" name="login" required><br><br><br>
        <label><b>Mot De Passe</b></label><br>
        <input type="password" placeholder="Entrer le mot de passe" name="password" required><br><br><br>
        <button type="submit" class="btn btn-primary btn-block">Connexion</button>
      </form>
    </section>
  </section>
  <footer>
    <aside id="last">

      <p>Validation de la page HTML5 - CSS3</p>
    <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Filias-alami-31000.atwebpages.com%2FSAE_14%2Findex.html" target="_blank"> 
      <img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
    </a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Filias-alami-31000.atwebpages.com%2FSAE_14%2Fstyles%2Fstyle.css" target="_blank">
      <img class= "image-responsive" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" />
    </a>
    </aside>
    

    <ul class="IUT">
      <li><a href="https://www.iut-blagnac.fr/fr/" target="_blank">IUT de Blagnac</a></li>
      <li>Département Réseaux et Télécommunications</li>
      <li>BUT1</li>
    </ul>  
  </footer>
    
 </body>
</html>
