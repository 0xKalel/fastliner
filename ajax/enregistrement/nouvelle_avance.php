<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securis
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	//modifis le code suivant pour enregistrer les differents champs de chaque route, n'oublis pas de faire le test pour verifier si un champs obligatoire
	//est vide ou non, chaque champs doit etre ecrit selon les normes de son type, le nom du chauffeur ne doit pas contenir de chiffre par example
	// remplace les variables tableaux par des variables simples, au lieu d'ecrire $_POST["nom_chauffeur"] ecrit $nom_chauffeur c'est deja pret utilise ou ma thawesch tefhem

	if(isset($nom))
	{			
		if($bdd->query("INSERT INTO avances(nom,avance,date) VALUES('$nom','$avance','$date')"))
		{		
			echo 1; 
		}
		else echo "erreur connexion";
		
	}
	else echo "les informations n'ont pas pu etre envoyées. réessayez"; 
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>