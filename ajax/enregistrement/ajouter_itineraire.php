<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	if(isset($_POST["depart"]))
	{
			if($bdd->query("INSERT INTO itineraires(depart,destination,prix,idprojet) VALUES('$depart','$destination','$prix','$id')"))
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