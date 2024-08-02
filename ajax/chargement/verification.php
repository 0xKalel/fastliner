<?php
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securis
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	$donnees_utilisateurs=$bdd->get_results("SELECT nom FROM comptes WHERE nom='$nom'");
	if(count($donnees_utilisateurs))
		echo json_encode(1);
	else
		echo json_encode(0);
	?>
