<!DOCTYPE html>
<html lang="fr">
 <head>
  <title>SAE 23</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="DAUDIGNON" />
  <meta name="description" content="Portfolio SAE 23" />
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
            <li><a href="index.php" class="first">Accueil</a></li>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="gestion_de_projet.html">Gestion de projet</a></li>
          </ul>
      </nav>
    </div>
  </header>

  <h1>ACCUEIL</h1>
  
	<h2>Quel est l'objectif de ce site ?</h2>
  <section class="bulle">
    <p>Nous avons créé ce site afin de faciliter la consultation des mesures des différents capteurs par des élèves de l'IUT ou bien par les professeurs. Ce site est principalement géré par l'administrateur ainsi que par les gestionnaires de chaque bâtiment.</p>
  </section> <br> <br>

	<h2>Vous trouverez sur ce site:</h2>
  <section class="bulle">
    <ul>
      <li>La page Accueil est accessible par tout le monde et affiche la dernière mesure des capteurs de chaques bâtiments</li> <br>
      <li>La page Administration accessible uniquement par la/les personne(s) autorisée(s), possédant un user et un mot de passe pour y accéder. La page sert à ajouter et supprimer des capteurs et/ou des bâtiments.</li><br>
      <li>La page Gestion est accessible uniquement par les gestionnaires qui possèdent un user et un mot de passe. Cette page affiche les 9 dernières valeurs mesurées par les capteurs de leur propre bâtiment uniquement.</li><br>
      <li>Et enfin, la page gestion de projet qui affiche [A REMPLIR]</li><br>
    </ul>
    </section>  <br> <br>

	<section class="bulle">
      <?php

        include 'config.php';


            $sql = "SELECT batiment.nom AS nom_batiment, capteur.nom AS nom_capteur, capteur.type, mesure.date, mesure.horaire, mesure.valeur
            FROM capteur
            JOIN (
            SELECT id_capteur, MAX(id_mesure) AS last_mesure_id
            FROM mesure
            GROUP BY id_capteur) 
            AS last_mesure ON capteur.id_capteur = last_mesure.id_capteur
            JOIN mesure ON last_mesure.last_mesure_id = mesure.id_mesure
            JOIN batiment ON capteur.id_batiment = batiment.id_batiment
            ORDER BY mesure.date DESC, mesure.horaire DESC";
            $result = $conn->query($sql);

            // Génération du tableau HTML avec les données récupérées
            if ($result->num_rows > 0) 
            {
                    // En-tête du tableau
                    echo "<table>";
                    echo "<tr>";
                    while ($fieldinfo = $result->fetch_field()) {
                    echo "<th>" . $fieldinfo->name . "</th>";
                }
                    echo "</tr>";

                    // Données du tableau
                    while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value) 
                    {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucune donnée disponible.</p>";
            }

// Fermeture de la connexion à la base de données
$conn->close();
?>

  </section>

  <footer>
  <aside id="last">

    <p>Validation de la page HTML5 - CSS3</p>
	<!-- Compléter les hyperliens avec vos références -->
	<a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Filias-alami-31000.atwebpages.com%2FSAE_14%2Findex.html" target="_blank"> 
		<img class= "image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
	</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <!-- style1RWD.css ou style2RWD.css selon votre choix -->
	<a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Filias-alami-31000.atwebpages.com%2FSAE_14%2Fstyles%2Fstyle.css" target="_blank">
		<img class= "image-responsive" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" />
	</a>
  </aside>
    

    <ul class="IUT">
	    <li>IUT de Blagnac</li>
	    <li>Département Réseaux et Télécommunications</li>
      <li>BUT1</li>
	  </ul>  
  </footer>
    
 </body>
</html>