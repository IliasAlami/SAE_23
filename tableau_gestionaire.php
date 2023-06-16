<?php
    include 'config.php';


    session_start(); // Start the session

    $gest = "SELECT login FROM `administration` WHERE login='$user'";

    if (isset($_SESSION['login'] && $_POST['login'] = $gest)) {
        // User is logged in
        $login = $_SESSION['login'];
    } else {
    // User is not logged in
    // Redirect to the login page
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

    // SQL query to retrieve measurements for a specific user (filtered by login)
    $sql = "SELECT batiment.nom AS batiment, capteur.salle AS salle, capteur.type, mesure.date, mesure.horaire, mesure.valeur
            FROM capteur
            JOIN mesure ON capteur.id_capteur = mesure.id_capteur
            JOIN batiment ON capteur.id_batiment = batiment.id_batiment
            WHERE batiment.login = '" . $login . "'
            ORDER BY mesure.date DESC, mesure.horaire DESC";

    $result = $conn->query($sql);

    // Generate the HTML table with the retrieved data
    if ($result->num_rows > 0) {
        // Table header
        echo "<table>";
        echo "<tr>";
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>" . $fieldinfo->name . "</th>"; 
            // Display the column names as table headers
        }
        echo "</tr>";

        // Table data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<td>" . $value . "</td>"; 
                // Display each value in a table cell
            }
            echo "</tr>";
        }
    }
    else {
        echo "<tr><td colspan='6'>No data available.</td></tr>"; 
        // Display a message if no data is found
    }


////////////////////////////////Metrics//////////////////////////////////////////////


    // SQL query to calculate metrics for a specific user (filtered by login)
    $sql = "SELECT capteur.type, AVG(mesure.valeur) AS moyenne, MIN(mesure.valeur) AS minimum, MAX(mesure.valeur) AS maximum
            FROM capteur
            JOIN mesure ON capteur.id_capteur = mesure.id_capteur
            JOIN batiment ON capteur.id_batiment = batiment.id_batiment
            WHERE batiment.login = '" . $login . "'
            GROUP BY capteur.type";

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if any results are returned
    if ($result->num_rows > 0) {
        // Loop through the results and display the values
        while ($row = $result->fetch_assoc()) {
            echo "Sensor Type: " . $row["type"] . "<br>";
            echo "Average: " . $row["moyenne"] . "<br>";
            echo "Minimum: " . $row["minimum"] . "<br>";
            echo "Maximum: " . $row["maximum"] . "<br>";
            echo "<br>";
        }
    } else {
        echo "No results found.";
    }

    // Close the database connection
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
