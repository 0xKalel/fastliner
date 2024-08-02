<?php
	
	$reference="../../php/";
	include("../../php/config.php");
	include("../../php/filtre_ajax.php");

	$avances="( SELECT SUM(valeur) FROM avances WHERE avances.idroute=r.id )AS avances";
	if($donnees_routes=$bdd->get_results("SELECT r.*,$avances,p.projet FROM avances AS r,projets AS p $projets $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite")){
		$routes=array();
		if(count($donnees_routes))
			foreach($donnees_routes as $r)
			{
				$route=array();
				foreach($r as $cle=>$valeur)
				{
					if(($r->prix)<=($r->avances))
					{
						$r->reste=0;
					} 
					else
						$r->reste=($r->prix)-($r->avances);
					$route[$cle]=securiser($valeur);
				}
				array_push($routes,$route);

		 	}
		echo json_encode($routes);
	}
	else
		echo -1;
?>
					