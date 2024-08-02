<?php	
	$reference="../../php/";
	include("../../php/config.php");
	$donnees_matricules=$bdd->get_results("SELECT matricule FROM vehicules");
	$matricules=array();
	if(count($donnees_matricules))
		foreach($donnees_matricules as $r)
		{
			$matricule=array();
			foreach($r as $cle=>$valeur)
			{
				$matricule[$cle]=securiser($valeur);
			}
			array_push($matricules,$matricule);
	 	}
	echo json_encode($matricules);
?>
