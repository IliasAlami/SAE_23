<?php
    include 'config.php';


    session_start(); // Démarrer la session

    if (isset($_SESSION['login'])) 
    {
        // L'utilisateur est connecté
        $login = $_SESSION['login'];
        // Effectuer les opérations spécifiques à l'utilisateur connecté
    } 
    
    else 
    {
        // L'utilisateur n'est pas connecté
        // Rediriger vers la page de connexion ou afficher un message d'erreur
        header('Location: connexion.php');
    }


$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) 
{
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

// Traitement du formulaire d'ajout de capteur
if (isset($_POST['ajouter_capteur'])) 
{
    $id_capteur = $_POST['id_capteur'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $id_batiment = $_POST['id_batiment'];

    // Vérifier si le bâtiment existe avant d'ajouter le capteur
    $sql_check_batiment = "SELECT * FROM batiment WHERE id_batiment = '$id_batiment'";
    $result_check_batiment = mysqli_query($conn, $sql_check_batiment);
    if (mysqli_num_rows($result_check_batiment) > 0) 
    {
        // Le bâtiment existe, on peut ajouter le capteur
        $sql = "INSERT INTO capteur (id_capteur, nom, type, id_batiment) VALUES ('$id_capteur', '$nom', '$type', '$id_batiment')";
        if (mysqli_query($conn, $sql)) 
        {
            echo "Le capteur a été ajouté avec succès.";
        } 
        
        else 
        {
            echo "Erreur lors de l'ajout du capteur : " . mysqli_error($conn);
        }
    } 
    
    else 
    {
        echo "Le bâtiment avec l'ID $id_batiment n'existe pas. Veuillez ajouter d'abord le bâtiment.";
    }
}

// Traitement du formulaire de suppression de capteur
if (isset($_POST['supprimer_capteur'])) 
{
    $id_capteur = $_POST['id_capteur'];

    // Supprimer d'abord les mesures associées au capteur
    $sql_delete_mesures = "DELETE FROM mesure WHERE id_capteur = '$id_capteur'";
    if (mysqli_query($conn, $sql_delete_mesures)) 
    {
        // Supprimer le capteur
        $sql_delete_capteur = "DELETE FROM capteur WHERE id_capteur = '$id_capteur'";
        if (mysqli_query($conn, $sql_delete_capteur)) 
        {
            echo "Le capteur a été supprimé avec succès.";
        } 
        
        else 
        {
            echo "Erreur lors de la suppression du capteur : " . mysqli_error($conn);
        }
    } 
    
    else 
    {
        echo "Erreur lors de la suppression des mesures : " . mysqli_error($conn);
    }
}

// Récupérer la liste des capteurs pour la sélection
$sql_select_capteurs = "SELECT id_capteur, nom FROM capteur";
$result_capteurs = mysqli_query($conn, $sql_select_capteurs);

// Fermer la connexion à la base de données
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter/Supprimer des capteurs</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="ALAMI, " />
    <meta name="description" content="SAE_23" />
    <meta name="keywords" content="HTML, CSS, Portfolio" />
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
                    <li><a href="ajout_suppr_bat.php">Ajout/Suppression de Batiments</a></li>
                    <li><a href="gestion_de_projet.html">Gestion de projet</a></li>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <h1>Ajouter/Supprimer des capteurs</h1>

    
    <section class="bulle">
        <h2>Ajouter un capteur</h2>
        
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="id_capteur">ID Capteur:</label>
        <input type="text" id="id_capteur" name="id_capteur" required><br>

        <label for="nom capteur">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required><br>

        <label for="nom batiment">ID Bâtiment:</label>
        <input type="text" id="id_batiment" name="id_batiment" required><br>

        <input type="submit" name="ajouter_capteur" value="Ajouter Capteur">
    </form>
	</p>
	</section>
	
	<section class="bulle">
    <h2>Supprimer un capteur</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="id_capteur_supprimer">Sélectionnez un capteur:</label>
        <select class="bouton_selec" id="id_capteur_supprimer" name="id_capteur" required>
            <?php
            while ($row = mysqli_fetch_assoc($result_capteurs)) {
                echo "<option value='" . $row['id_capteur'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
        </select><br>	
        <input type="submit" name="supprimer_capteur" value="Supprimer Capteur"><br><br><br>
        </section>
    <section class="bulle">
        <table id="data-table">
        <?php
    // SQL query to retrieve all measurements and related information from the database
    $sql = "SELECT batiment.nom AS nom_batiment, capteur.nom AS nom_capteur, capteur.type, mesure.date, mesure.horaire, mesure.valeur
            FROM capteur
            JOIN mesure ON capteur.id_capteur = mesure.id_capteur
            JOIN batiment ON capteur.id_batiment = batiment.id_batiment
            ORDER BY mesure.date DESC, mesure.horaire DESC";

    $result = $conn->query($sql);

    // Generate the HTML table with the retrieved data
    if ($result->num_rows > 0) {
        // Table header
        echo "<tr>";
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>" . $fieldinfo->name . "</th>"; // Display the column names as table headers
        }
        echo "</tr>";

        // Table data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $key => $value) {
                echo "<td>" . $value . "</td>"; // Display each value in a table cell
            }
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data available.</td></tr>"; // Display a message if no data is found
    }

///////////////////////////////////Metrics///////////////////////////////////////////

    // SQL query to calculate metrics for all sensors
    $sql = "SELECT capteur.type, AVG(mesure.valeur) AS moyenne, MIN(mesure.valeur) AS minimum, MAX(mesure.valeur) AS maximum
            FROM capteur
            JOIN mesure ON capteur.id_capteur = mesure.id_capteur
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
    </form>
</body>
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
</html>
