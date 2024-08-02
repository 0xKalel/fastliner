<?php
	$reference="../../php/";
	include("../../php/config.php");
	// $donnees_rapports=$bdd->get_results("SELECT SUM(prix_assurance) as prix_assurance ,SUM(prix_vignette) as prix_vignette,SUM(prix_scanner) as prix_scanner,SUM(prix_controle) as prix_controle,SUM(paye_chauffeur) as paye_chauffeur FROM vehicules");
	// $rapports=array();
	// if(count($donnees_rapports))
	// 	foreach($donnees_rapports as $r)
	// 	{
	// 		$rapport=array();
	// 		foreach($r as $cle=>$valeur)
	// 		{
	// 			$rapport[$cle]=securiser($valeur);
	// 		}
	// 		array_push($rapports,$rapport);
	//  	}
	$creances=$bdd->get_results(
		"SELECT 
				SUM(
					valeur * (SELECT FROM(
						SELECT COUNT(id>0) AS compte FROM routes WHERE idprojet=(
							SELECT id FROM projets WHERE id=c.id
						)
					) WHERE compte>)
				) AS creances 
		FROM avances_projets AS c 
		WHERE valeur!=0 AND c.id IN (SELECT id FROM projets WHERE c.id=id) ");
	echo json_encode($creances);
?>
