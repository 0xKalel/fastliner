<?php
	
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
	foreach($_POST as $key=>$value)
		$$key=$value;
	$donnees_parametres=$bdd->query("UPDATE parametres SET valeur='$nbr_page' WHERE etiquette='element_par_page'");
	$donnees_parametres=$bdd->query("UPDATE parametres SET valeur='$type' WHERE etiquette='type'");
	if($donnees_parametres)
		echo 0;
	else
		echo 1;
?>
					