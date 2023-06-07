<?php
    include 'config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['login'];
        $pass = $_POST['password'];

        // Requête SQL pour vérifier les informations de connexion
        $query = "SELECT login FROM `administration` WHERE login='$user' AND mdp='$pass'";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_array($result);

        if ($result[0] == $user) {
            header('Location: gestion_de_projet.html');
        }

        else {
                // Requête SQL pour vérifier les informations de connexion
            $query = "SELECT login FROM `batiment` WHERE login='$user' AND mdp='$pass'";
            $result = mysqli_query($conn, $query);
            $result = mysqli_fetch_array($result);

            if ($result[0] == $user) {
                header('Location: ajout_suppr_capt.php');
            }
        }
    }
?>
