<?php	
	$reference="../../php/";
	include("../../php/config.php");
	$donnees_projets=$bdd->get_results("SELECT id,projet FROM projets");
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
