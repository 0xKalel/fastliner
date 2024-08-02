<?php	
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
			$$key=$value;
		
	$donnees_itineraires=$bdd->get_results("SELECT * FROM itineraires WHERE idprojet=$idprojet");
	$itineraires=array();
	if(count($donnees_itineraires))
		foreach($donnees_itineraires as $r)
		{
			$itineraire=array();
			foreach($r as $cle=>$valeur)
			{
				$itineraire[$cle]=securiser($valeur);
			}
			array_push($itineraires,$itineraire);
	 	}
	echo json_encode($itineraires);
?>
