<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	if(isset($_POST["nom"]))
	{
		foreach($_POST as $key=>$value)
		{
			$$key=securiser($value);
		}
		$date_string= DateTime::createFromFormat('d/m/Y', $date);
		$date = $date_string->format('Y-m-d');
		if($bdd->query("INSERT INTO factures(nom,idprojet,date) VALUES('$nom',$id,'$date')"))
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