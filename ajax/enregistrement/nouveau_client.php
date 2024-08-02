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
	if(isset($nom))
	{
		if($bdd->query("INSERT INTO clients(nom,wilaya,adresse,observation) VALUES('$nom','$wilaya','$adresse','$observation')"))
		{		
			echo 1; 
		}
		else echo "erreur connexion";
	}
	else "les informations n'ont pas pu etre envoyées. réessayez";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>