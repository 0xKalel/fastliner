<?php	
	$reference="../../php/";
	include("../../php/config.php");
		
	$listes_champs=$bdd->get_results("SELECT * FROM champs");
	$champs=array();
		foreach($listes_champs as $l)
		{
			$champ=array();
			foreach($l as $cle=>$valeur)
			{
				$champ[$cle]=securiser($valeur);
			}
			array_push($champs,$champ);
	 	}
	echo json_encode($champs);
	