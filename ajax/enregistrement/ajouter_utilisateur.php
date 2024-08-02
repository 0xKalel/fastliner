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

	if($bdd->query("INSERT INTO comptes (nom,mdp,type) VALUES('$nom','$mdp','$type') "))
	{		
		echo 1;
	}
	else echo "erreur connexion";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>