<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['login'];
    $pass = $_POST['password'];

    // Requête SQL pour vérifier les informations de connexion dans la table `administration`
    $query_admin = "SELECT login FROM administration WHERE login='$user' AND mdp='$pass'";
    $result_admin = mysqli_query($conn, $query_admin);

    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        header('Location: gestion_de_projet.htmlLocation: ajout_suppr_capt.php');
        exit(); // Terminer le script pour éviter toute exécution supplémentaire
    }

    // Requête SQL pour vérifier les informations de connexion dans la table `batiment`
    $query_batiment = "SELECT login FROM batiment WHERE login='$user' AND mdp='$pass'";
    $result_batiment = mysqli_query($conn, $query_batiment);

    if ($result_batiment && mysqli_num_rows($result_batiment) > 0) {
        header('');
        exit(); // Terminer le script pour éviter toute exécution supplémentaire
    }
}
?>
