<?php
    include 'config.php';

    // Start the session
    session_start();



    // Check if the 'login' session variable is set
    if (isset($_SESSION['login'])) {
        // Retrieve the 'login' session variable
        $login = $_SESSION['login'];
    } else {
        // Redirect to the 'connexion.php' page if 'login' session variable is not set
        header('Location: connexion.php');
    }


    

    // Connect to the database
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        // Display an error message if the database connection fails
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }





    // Check if the 'ajouter_capteur' form has been submitted
    if (isset($_POST['ajouter_capteur'])) {
        // Retrieve form data
        $id_capteur = $_POST['id_capteur'];
        $nom = $_POST['nom'];
        $type = $_POST['type'];
        $id_batiment = $_POST['id_batiment'];




        // Check if the specified 'id_batiment' exists in the 'batiment' table
        $sql_check_batiment = "SELECT * FROM batiment WHERE id_batiment = '$id_batiment'";
        $result_check_batiment = mysqli_query($conn, $sql_check_batiment);
        if (mysqli_num_rows($result_check_batiment) > 0) {
            // Insert the new sensor data into the 'capteur' table
            $sql = "INSERT INTO capteur (id_capteur, nom, type, id_batiment) VALUES ('$id_capteur', '$nom', '$type', '$id_batiment')";
            if (mysqli_query($conn, $sql)) {
                // Display success message if the sensor is successfully added
                echo "Le capteur a été ajouté avec succès.";
            } else {
                // Display error message if there is an issue with adding the sensor
                echo "Erreur lors de l'ajout du capteur : " . mysqli_error($conn);
            }
        } else {
            // Display error message if the specified 'id_batiment' does not exist
            echo "Le bâtiment avec l'ID $id_batiment n'existe pas. Veuillez ajouter d'abord le bâtiment.";
        }
    }




    // Check if the 'supprimer_capteur' form has been submitted
    if (isset($_POST['supprimer_capteur'])) {
        // Retrieve form data
        $id_capteur = $_POST['id_capteur'];

        // Delete the sensor measurements associated with the specified 'id_capteur'
        $sql_delete_mesures = "DELETE FROM mesure WHERE id_capteur = '$id_capteur'";
        if (mysqli_query($conn, $sql_delete_mesures)) {
            // Delete the sensor from the 'capteur' table
            $sql_delete_capteur = "DELETE FROM capteur WHERE id_capteur = '$id_capteur'";
            if (mysqli_query($conn, $sql_delete_capteur)) {
                // Display success message if the sensor is successfully deleted
                echo "Le capteur a été supprimé avec succès.";
            } else {
                // Display error message if there is an issue with deleting the sensor
                echo "Erreur lors de la suppression du capteur : " . mysqli_error($conn);
            }
        } else {
            // Display error message if there is an issue with deleting the associated measurements
            echo "Erreur lors de la suppression des mesures : " . mysqli_error($conn);
        }
    }




    

    // Select all sensors from the 'capteur' table
    $sql_select_capteurs = "SELECT id_capteur, nom FROM capteur";
    $result_capteurs = mysqli_query($conn, $sql_select_capteurs);





    // Close the database connection
    mysqli_close($conn);
?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- HTML head section -->
</head>
<body>
    <!-- Header section -->
    
    <!-- Display the title -->
    <h1>Ajouter/Supprimer des capteurs</h1>




    <!-- Section for adding a sensor -->
    <section class="bulle">
        <h2>Ajouter un capteur</h2>
        
        <!-- Form for adding a sensor -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- Input fields for sensor details -->
            <label for="id_capteur">ID Capteur:</label>
            <input type="text" id="id_capteur" name="id_capteur" required><br>

            <label for="nom capteur">Nom:</label>
            <input type="text" id="nom" name="nom" required><br>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>

            <label for="nom batiment">ID Bâtiment:</label>
            <input type="text" id="id_batiment" name="id_batiment" required><br>

            <!-- Submit button for adding the sensor -->
            <input type="submit" name="ajouter_capteur" value="Ajouter Capteur">
        </form>
    </section>







	
    <!-- Section for deleting a sensor -->
    <section class="bulle">
        <h2>Supprimer un capteur</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- Select dropdown for choosing a sensor to delete -->
            <label for="id_capteur_supprimer">Sélectionnez un capteur:</label>
            <select class="bouton_selec" id="id_capteur_supprimer" name="id_capteur" required>
                <!-- Display options for each sensor retrieved from the database -->
                <?php
                while ($row = mysqli_fetch_assoc($result_capteurs)) {
                    echo "<option value='" . $row['id_capteur'] . "'>" . $row['nom'] . "</option>";
                }
                ?>
            </select><br>

            <!-- Submit button for deleting the selected sensor -->
            <input type="submit" name="supprimer_capteur" value="Supprimer Capteur"><br><br><br>
        </form>
    </section>









    <section class="bulle">
        <!-- Display the sensor data in a table -->
        <table id="data-table">
            <?php
            // Select sensor data from multiple tables and display it in a table format
            $sql = "SELECT batiment.nom AS nom_batiment, capteur.nom AS nom_capteur, capteur.type, mesure.date, mesure.horaire, mesure.valeur
                    FROM capteur
                    JOIN mesure ON capteur.id_capteur = mesure.id_capteur
                    JOIN batiment ON capteur.id_batiment = batiment.id_batiment
                    ORDER BY mesure.date DESC, mesure.horaire DESC";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display table header row
                echo "<tr>";
                while ($fieldinfo = $result->fetch_field()) {
                    echo "<th>" . $fieldinfo->name . "</th>";
                }
                echo "</tr>";

                // Display table rows with sensor data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                // Display a message if no data is available
                echo "<tr><td colspan='6'>No data available.</td></tr>";
            }
            ?>
        </table>
    </section>
</body>
</html>
