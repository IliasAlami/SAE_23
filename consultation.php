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
          <li><a href="index.html" class="first">Accueil</a></li>
            <li><a href="consultation.php" class="first">Consultation</a></li>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="gestion_de_projet.html">Gestion de projet</a></li>
          </ul>
      </nav>
    </div>
  </header>

  <h1>CONSULTATION</h1> <br>
  


	<section class="bulle">
  <h2>Affichage des dernières mesures:</h2>
      <?php
    include 'config.php';

    // SQL query to retrieve the latest measurements for each sensor
    $sql = "SELECT batiment.nom AS batiment, capteur.salle AS salle, capteur.type, mesure.date, mesure.horaire, mesure.valeur
    FROM capteur
    JOIN (
        SELECT id_capteur, MAX(id_mesure) AS last_mesure_id
        FROM mesure
        GROUP BY id_capteur
    ) AS last_mesure ON capteur.id_capteur = last_mesure.id_capteur
    JOIN mesure ON last_mesure.last_mesure_id = mesure.id_mesure
    JOIN batiment ON capteur.id_batiment = batiment.id_batiment
    ORDER BY mesure.date DESC, mesure.horaire DESC";

    // Execute the SQL query
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
        echo "</table>";
    } else {
        echo "<p>No data available.</p>"; 
        // Display a message if no data is found
    }

    // Close the database connection
    $conn->close();
	?>
  </section>

  <footer>
  
    <ul class="IUT">
	    <li>IUT de Blagnac</li>
	    <li>Département Réseaux et Télécommunications</li>
      <li>BUT1</li>
	  </ul>  
  </footer>
    
 </body>
</html>
