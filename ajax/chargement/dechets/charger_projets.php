<?php
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
	include("../../php/filtre_ajax.php");
	$donnees_projets=$bdd->get_results("SELECT * FROM $cle_actuelle $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite");
	$projets=array();
	if(count($donnees_projets))
		foreach($donnees_projets as $r)
		{
			$projet=array();
			foreach($r as $cle=>$valeur)
			{
				$projet[$cle]=securiser($valeur);
			}
			array_push($projets,$projet);
	 	}
	echo json_encode($projets);
?>
					