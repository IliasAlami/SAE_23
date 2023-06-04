<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=sae23.batiment;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{
		die('Erreur'.$e->getMessage());
	}
?>