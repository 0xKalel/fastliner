<?php 
	$sortby="";
	$filtre_bdd="";
	$date_bdd="";
	$i=0;
	$limite=10;
	$projets="";
	foreach($_POST as $key=>$value)
	{
		if($key=="filtre")
			$$key=$value;
		elseif($key=="interval_date")
			$$key=$value;
		else
			$$key=$value;
	}
    if(isset($sort))
		$sortby="ORDER BY $sort $ordre";
	if(isset($filtre))
		foreach($filtre as $f)
		{
				foreach($f as $fc=>$fv)
					if((($cle_actuelle=="routes")||($cle_actuelle=="etats"))&&($fc=='projet')){
						$idprojet=$bdd->get_var("SELECT id FROM projets WHERE projet='$fv' ");
						$filtre_bdd.="AND r.idprojet = $idprojet ";
					}
					else
					if($cle_actuelle=="chauffeurs")
						$filtre_bdd.="WHERE r.nom_chauffeur!='' ";
					else
						$filtre_bdd.="AND r.$fc = '$fv' ";
		}
	if(isset($interval_date))
	{
		if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
		$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
		$min_date = $min_date->format('Y-m-d');
		$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
		$max_date = $max_date->format('Y-m-d');
			$date_bdd="AND r.date BETWEEN '$min_date' AND '$max_date'  ";
		}
	}
	$projets="WHERE r.idprojet=p.id ";
	$affiche=($page-1)*$limite;

	
	
?>
