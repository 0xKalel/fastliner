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
	if($id_matricule = $bdd->get_var("SELECT id FROM vehicules WHERE matricule='$matricule'"))
	{
		if($bdd->query("UPDATE vehicules SET nom_chauffeur = '$nom_chauffeur', paye_chauffeur = '$paye_chauffeur', date_chauffeur = '$date_chauffeur', assurance_chauffeur = '$assurance_chauffeur'
			, date_assurance_chauffeur = '$date_assurance_chauffeur' WHERE id='$id_matricule'"))
		{
			echo 1;
		}
		else
			echo "erreur connexion";
	}
	else
		echo "erreur connexion";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";




?>