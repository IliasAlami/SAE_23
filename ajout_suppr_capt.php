<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "passroot";
$dbname = "sae23";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

// Traitement du formulaire d'ajout de capteur
if (isset($_POST['ajouter_capteur'])) {
    $id_capteur = $_POST['id_capteur'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $id_batiment = $_POST['id_batiment'];

    // Vérifier si le bâtiment existe avant d'ajouter le capteur
    $sql_check_batiment = "SELECT * FROM batiment WHERE id_batiment = '$id_batiment'";
    $result_check_batiment = mysqli_query($conn, $sql_check_batiment);
    if (mysqli_num_rows($result_check_batiment) > 0) {
        // Le bâtiment existe, on peut ajouter le capteur
        $sql = "INSERT INTO capteur (id_capteur, nom, type, id_batiment) VALUES ('$id_capteur', '$nom', '$type', '$id_batiment')";
        if (mysqli_query($conn, $sql)) {
            echo "Le capteur a été ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du capteur : " . mysqli_error($conn);
        }
    } else {
        echo "Le bâtiment avec l'ID $id_batiment n'existe pas. Veuillez ajouter d'abord le bâtiment.";
    }
}

// Traitement du formulaire de suppression de capteur
if (isset($_POST['supprimer_capteur'])) {
    $id_capteur = $_POST['id_capteur'];

    // Supprimer d'abord les mesures associées au capteur
    $sql_delete_mesures = "DELETE FROM mesure WHERE id_capteur = '$id_capteur'";
    if (mysqli_query($conn, $sql_delete_mesures)) {
        // Supprimer le capteur
        $sql_delete_capteur = "DELETE FROM capteur WHERE id_capteur = '$id_capteur'";
        if (mysqli_query($conn, $sql_delete_capteur)) {
            echo "Le capteur a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du capteur : " . mysqli_error($conn);
        }
    } else {
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
    <meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Pour bien gérer le RWD -->
    <meta name="author" content="ALAMI, " />
    <meta name="description" content="SAE_23" />
    <meta name="keywords" content="HTML, CSS, Portfolio" />
    <link rel="stylesheet" href="./styles/style.css" />
    <link rel="stylesheet" href="./styles/rwd.css" />
    <link rel="stylesheet" href="./styles/Hamburger.css" />
</head>
<body>
    <h1>Ajouter/Supprimer des capteurs</h1>

    <h2>Ajouter un capteur</h2>
    
    <section class="bulle">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="id_capteur">ID Capteur:</label>
        <input type="text" id="id_capteur" name="id_capteur" required><br>

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required><br>

        <label for="id_batiment">ID Bâtiment:</label>
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
        <input type="submit" name="supprimer_capteur" value="Supprimer Capteur">
        </section>
    </form>
</body>
</html>
