<?php
	
	$reference="../../php/";
	include("../../php/config.php");
		foreach($_POST as $key=>$value)
	{
		$$key=$value;
	}
	$donnees_valeurs=$bdd->get_row("SELECT *,DATE_FORMAT(date,'%d/%c/%Y') AS date FROM $cle_actuelle WHERE id=$id");
	
	echo json_encode($donnees_valeurs);
?>
