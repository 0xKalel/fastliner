<?php
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
	include("../../php/filtre_ajax.php");
	$donnees_routes=$bdd->get_results("SELECT r.*,p.projet FROM $cle_actuelle AS r,projets AS p $projets $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite");
	$routes=array();
	if(count($donnees_routes))
		foreach($donnees_routes as $r)
		{
			$route=array();
			foreach($r as $cle=>$valeur)
			{
				$route[$cle]=securiser($valeur);
			}
			array_push($routes,$route);
	 	}
	echo json_encode($routes);
?>
					