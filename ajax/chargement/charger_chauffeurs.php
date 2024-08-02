<?php
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
	include("../../php/filtre_ajax.php");
	$donnees_chauffeurs=$bdd->get_results("SELECT r.nom_chauffeur, r.paye_chauffeur, r.date_chauffeur, r.matricule FROM vehicules AS r $filtre_bdd  $date_bdd $sortby LIMIT $affiche, $limite");
	echo json_encode($donnees_chauffeurs);
?>
					