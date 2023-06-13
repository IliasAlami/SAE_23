<?php
    include 'config.php';


    session_start(); // Démarrer la session

    if (isset($_SESSION['login'])) {
        // L'utilisateur est connecté
        $login = $_SESSION['login'];
        // Effectuer les opérations spécifiques à l'utilisateur connecté
    } else {
        // L'utilisateur n'est pas connecté
        // Rediriger vers la page de connexion ou afficher un message d'erreur
        header('Location: connexion.php');
    }

?>


<!DOCTYPE html>
<html>
<head>
  <title>SAE 23</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="DAUDIGNON" />
  <meta name="description" content="SAE 23" />
  <meta name="keywords" content="HTML, CSS, PHP" />
  <link rel="stylesheet" href="./styles/style.css" />
  <link rel="stylesheet" href="./styles/rwd.css" />
  <link rel="stylesheet" href="./styles/Hamburger.css" />
</head>
<body>
    <header>
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
                    <li><a href="consultation.php" class="first">Consultation</a></li>
                    <li><a href="gestion_de_projet.html">Gestion de projet</a></li>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <h1>Données des capteurs</h1>

    <section class="bulle">
    <table id="data-table">

        <?php

		$sql = "SELECT batiment.nom AS nom_batiment, capteur.nom AS nom_capteur, capteur.type, mesure.date, mesure.horaire, mesure.valeur
       			FROM capteur
       			JOIN mesure ON capteur.id_capteur = mesure.id_capteur
        		JOIN batiment ON capteur.id_batiment = batiment.id_batiment
     			WHERE batiment.login = '" . $login . "'
        		ORDER BY mesure.date DESC, mesure.horaire DESC";

            $result = $conn->query($sql);

            // Génération du tableau HTML avec les données récupérées
            if ($result->num_rows > 0) {
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
                    foreach ($row as $key => $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucune donnée disponible.</p>";
            }
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
				///////////////////////////////Métrique//////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			
			// Liste des types de mesure
			$typesMesure = array("temperature", "co2"); // Ajoutez d'autres types de mesure si nécessaire
			
			// Parcourir les types de mesure
			foreach ($typesMesure as $typeMesure) {
    			// Requête SQL pour récupérer les valeurs du type de mesure pour le bâtiment spécifié
    			$sql = "SELECT mesure.valeur
            			FROM mesure
            			JOIN capteur ON capteur.id_capteur = mesure.id_capteur
            			JOIN batiment ON capteur.id_batiment = batiment.id_batiment
            			WHERE batiment.login = '" . $login . "'
            			AND mesure.type = '$typeMesure'";
			
    			// Exécution de la requête
    			$result = $conn->query($sql);
			
    			if ($result) {
        			// Tableau pour stocker les valeurs des mesures
        			$valeurs = array();
			
        			// Parcourir les résultats de la requête
        			while ($row = $result->fetch_assoc()) {
            			$valeurs[] = $row['valeur'];
        			}
			
        			// Compter le nombre de valeurs
        			$denominateur = count($valeurs);
			
        			// Calculer la somme des valeurs
        			$somme = array_sum($valeurs);
			
        			// Chercher la valeur minimale
        			$minimum = min($valeurs);
			
        			// Chercher la valeur maximale
        			$maximum = max($valeurs);
			
        			// Calculer la moyenne
        			$moyenne = $somme / $denominateur;
			
        			// Afficher les résultats
        			echo "Type de mesure: $typeMesure\n";
        			echo "Login du bâtiment: $loginBatiment\n";
        			echo "Somme des valeurs: $somme\n";
        			echo "Nombre de valeurs: $denominateur\n";
        			echo "Moyenne: $moyenne\n";
        			echo "Minimum: $minimum\n";
        			echo "Maximum: $maximum\n";
        			echo "\n";
    			} else {
        			echo "Erreur lors de l'exécution de la requête : " . $conn->error;
    			}
			}

// Fermeture de la connexion à la base de données
$conn->close();


?>


    </table>
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
