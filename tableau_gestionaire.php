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

        // Requête pour récupérer les données des capteurs, des mesures, du bâtiment et du gestionnaire
        $sql = "SELECT capteur.*, mesure.*, batiment.nom AS nom_batiment, batiment.login AS login_gestionnaire FROM capteur 
                JOIN mesure ON capteur.id_capteur = mesure.id_capteur
                JOIN batiment ON capteur.id_batiment = batiment.id_batiment";
        $result = $conn->query($sql);

        // Génération du tableau HTML avec les données récupérées
        if ($result->num_rows > 0) {
            // En-tête du tableau
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
        } else {
            echo "<tr><td colspan='6'>Aucune donnée disponible.</td></tr>";
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
