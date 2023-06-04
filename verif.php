<?php
    session_start();
    require_once 'config.php';


    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $chek = $bdd->prepare('SELECT login, mdp FROM sae23.batiment WHERE login = ?');
        $chek->execute(array($username));
        $data = $chek->fetch();
        $row = $chek->rowCount();

        if($row == 1){
            if($data['password'] === $password){
                $_SESSION['user'] = $data['login'];
                header('Location:');
            }else header('Location:connexion.php?login_err=password');
        }else header('Location:connexion.php?login_err=already');

    }else header('Location:login.php');
    
?>