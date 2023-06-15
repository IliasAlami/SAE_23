<?php
include 'config.php';

session_start(); // Start the session

if (isset($_SESSION['login'])) {
    // User is logged in
    $login = $_SESSION['login'];
} else {
    // User is not logged in
    // Redirect to the login page
    header('Location: connexion.php');
}


// Handling the building addition form
if (isset($_POST['ajouter_batiment'])) {
    $id_batiment = $_POST['id_batiment'];
    $nom_batiment = $_POST['nom_batiment'];
    $login_batiment = $_POST['login_batiment'];
    $mdp_batiment = $_POST['mdp_batiment'];

    $sql = "INSERT INTO batiment (id_batiment, nom, login, mdp) VALUES ('$id_batiment', '$nom_batiment', '$login_batiment', '$mdp_batiment')";
    if (mysqli_query($conn, $sql)) {
        echo "Le bâtiment a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du bâtiment : " . mysqli_error($conn);
    }
}

// Handling the building deletion form
if (isset($_POST['supprimer_batiment'])) {
    $id_batiment = $_POST['id_batiment'];

    // Check if the building contains sensors before deleting it
    $sql_check_capteurs = "SELECT * FROM capteur WHERE id_batiment = '$id_batiment'";
    $result_check_capteurs = mysqli_query($conn, $sql_check_capteurs);
    if (mysqli_num_rows($result_check_capteurs) > 0) {
        echo "Le bâtiment avec l'ID $id_batiment contient des capteurs. Veuillez supprimer d'abord les capteurs.";
    } else {
        // Delete the building
        $sql_delete_batiment = "DELETE FROM batiment WHERE id_batiment = '$id_batiment'";
        if (mysqli_query($conn, $sql_delete_batiment)) {
            echo "Le bâtiment a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du bâtiment : " . mysqli_error($conn);
        }
    }
}

// Retrieve the list of buildings for selection
$sql_select_batiments = "SELECT id_batiment, nom FROM batiment";
$result_batiments = mysqli_query($conn, $sql_select_batiments);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter/Supprimer des bâtiments</title>
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
                    <li><a href="ajout_suppr_capt.php">Ajout/Suppression de Capteurs</a></li>
                    <li><a href="gestion_de_projet.html">Gestion de projet</a></li>
                    <li><a href="deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <h1>Ajouter/Supprimer des bâtiments</h1>

    <section class="bulle">
        <h2>Ajouter un bâtiment</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="id_batiment">ID Bâtiment:</label>
            <input type="text" id="id_batiment" name="id_batiment" required><br>

            <label for="nom_batiment">Nom:</label>
            <input type="text" id="nom_batiment" name="nom_batiment" required><br>

            <label for="login_batiment">Utilisateur:</label>
            <input type="text" id="login_batiment" name="login_batiment" required><br>

            <label for="mdp_batiment">Mot de passe:</label>
            <input type="password" id="mdp_batiment" name="mdp_batiment" required><br>

            <input type="submit" name="ajouter_batiment" value="Ajouter Bâtiment">
        </form>
    </section>

    <section class="bulle">
        <h2>Supprimer un bâtiment</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="id_batiment_supprimer">Sélectionnez un bâtiment:</label>
            <select class="bouton_selec" id="id_batiment_supprimer" name="id_batiment" required>
                <?php
                while ($row = mysqli_fetch_assoc($result_batiments)) {
                    echo "<option value='" . $row['id_batiment'] . "'>" . $row['nom'] . "</option>";
                }
                ?>
            </select><br>

            <input type="submit" name="supprimer_batiment" value="Supprimer Bâtiment"><br><br><br>
        </form>
    </section>
</body>

<footer>
    <aside id="last">

        <p>Validation de la page HTML5 - CSS3</p>
        <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Filias-alami-31000.atwebpages.com%2FSAE_14%2Findex.html"
            target="_blank">
            <img class="image-responsive" src="./images/html5-validator-badge-blue.png" alt="HTML5 Valide !" />
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Filias-alami-31000.atwebpages.com%2FSAE_14%2Fstyles%2Fstyle.css"
            target="_blank">
            <img class="image-responsive" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" />
        </a>
    </aside>


    <ul class="IUT">
        <li><a href="https://www.iut-blagnac.fr/fr/" target="_blank">IUT de Blagnac</a></li>
        <li>Département Réseaux et Télécommunications</li>
        <li>BUT1</li>
    </ul>
</footer>

</html>