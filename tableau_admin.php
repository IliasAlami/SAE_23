<!DOCTYPE html>
<html>
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
    <table id="data-table">
        <?php
        
        session_start();
        include 'config.php';

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Requête pour récupérer toutes les données des bâtiments, des capteurs et des mesures
        $sql = "SELECT * FROM batiment";
        $result_batiment = $conn->query($sql);

        $sql = "SELECT * FROM capteur";
        $result_capteur = $conn->query($sql);

        $sql = "SELECT * FROM mesure";
        $result_mesure = $conn->query($sql);

        // Génération du tableau HTML avec les données récupérées
        echo "<tr><th>Bâtiments</th></tr>";
        if ($result_batiment->num_rows > 0) {
            while ($row = $result_batiment->fetch_assoc()) {
                echo "<tr><td>" . $row["nom"] . "</td></tr>";
            }
        } else {
            echo "<tr><td>Aucun bâtiment trouvé.</td></tr>";
        }

        echo "<tr><th>Capteurs</th></tr>";
        if ($result_capteur->num_rows > 0) {
            while ($row = $result_capteur->fetch_assoc()) {
                echo "<tr><td>" . $row["id_capteur"] . "</td></tr>";
            }
        } else {
            echo "<tr><td>Aucun capteur trouvé.</td></tr>";
        }

        echo "<tr><th>Mesures</th></tr>";
        if ($result_mesure->num_rows > 0) {
            while ($row = $result_mesure->fetch_assoc()) {
                echo "<tr><td>" . $row["id_mesure"] . "</td></tr>";
            }
        } else {
            echo "<tr><td>Aucune mesure trouvée.</td></tr>";
        }

        // Fermeture de la connexion à la base de données
        $conn->close();
        ?>
    </table>
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
