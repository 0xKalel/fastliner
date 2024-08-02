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
	
	if($nom==$_SESSION["nom"]){
		echo "vous ne pouvez pas supprimer votre propre compte";
	}
	else{
		
		if($donnees_utilisateurs=$bdd->query("DELETE FROM comptes WHERE nom='$nom'")) 
			echo 1;
		else
			echo "erreur connexion";
	}
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>
