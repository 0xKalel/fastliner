<?php
	$reference="../../php/";
	include("../../php/config.php");
	$donnees_comptes=$bdd->get_results("SELECT * FROM comptes");
	$comptes=array();
	if(count($donnees_comptes))
		foreach($donnees_comptes as $r)
		{
			$compte=array();
			foreach($r as $cle=>$valeur)
			{
				$compte[$cle]=securiser($valeur);
			}
			array_push($comptes,$compte);
	 	}
	echo json_encode($comptes);
?>
