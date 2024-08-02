<?php 
	$reference="../../php/";
	include("../../php/config.php");
	$sortby="";
	$filtre_bdd="";
	$date_bdd="";
	$i=0;
	$projets="";
	$donnees_chargement=array();
	$nbr_page=0;
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
				{
					if((($cle_actuelle=="routes")||($cle_actuelle=="etats"))&&($fc=='projet')){
						$idprojet=$bdd->get_var("SELECT id FROM projets WHERE projet='$fv' ");
						$idprojet=$bdd->get_var("SELECT id FROM projets WHERE projet='$fv' ");
						$filtre_bdd.="AND cible.idprojet = $idprojet ";
					}
					else
					if($cle_actuelle=="chauffeurs")
						$filtre_bdd.="WHERE cible.nom_chauffeur!='' ";
					else
					if($cle_actuelle=="creances_personnel")
					{
						if($i==0)
						{
							$filtre_bdd.="WHERE creances.$fc = '$fv' ";
							$i++;
						}
						else
							$filtre_bdd.="AND creances.$fc = '$fv' ";
					}
					if($cle_actuelle=="dettes_personnel")
					{
						if($i==0)
						{
							$filtre_bdd.="WHERE debits.$fc = '$fv' ";
							$i++;
						}
						else
							$filtre_bdd.="AND debits.$fc = '$fv' ";
					}
						else
						$filtre_bdd.="AND cible.$fc = '$fv' ";
			}
		}
	if(isset($interval_date))
	{
		if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
		$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
		$min_date = $min_date->format('Y-m-d');
		$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
		$max_date = $max_date->format('Y-m-d');
			if($cle_actuelle=="creances_personnel")
			{
				if($i==0)
				{
					$date_bdd="WHERE cible.date BETWEEN '$min_date' AND '$max_date'  ";	
				}
				else
					$date_bdd="AND cible.date BETWEEN '$min_date' AND '$max_date'  ";
			}
			$date_bdd="AND cible.date BETWEEN '$min_date' AND '$max_date'  ";
		}
	}
	$projets="WHERE cible.idprojet=p.id ";
	if(($cle_actuelle=="routes")||($cle_actuelle=="etats")||($cle_actuelle=="chauffeurs"))
		{
			if($cle_actuelle=="etats") $cle_actuelle="routes";
			$nbr_page=$bdd->get_var("SELECT count(*) FROM $cle_actuelle AS cible, projets AS p  $projets $filtre_bdd  $date_bdd");
		}
	else
	if(($cle_actuelle=="projets")||($cle_actuelle=="vehicules"))
		{	
			$nbr_page=$bdd->get_var("SELECT count(*) FROM $cle_actuelle $filtre_bdd  $date_bdd  ");
		}
	else
	if($cle_actuelle=="dettes")
		{
			$cle_actuelle="routes";
			$avances="( SELECT SUM(valeur) FROM avances WHERE avances.idroute=cible.id )AS avances";
			if($donnees=$bdd->get_results("SELECT cible.*,$avances,p.projet FROM routes AS cible,projets AS p $projets $filtre_bdd $date_bdd $sortby"))
			{
				if(count($donnees))
					foreach($donnees as $d)
					{
						$route=array();
							if(($d->prix)<=($d->avances))
							{
								$d->reste=0;
							} 
							else
							{
								$d->reste=($d->prix)-($d->avances);
								if($d->reste>0)
								$nbr_page=$nbr_page+1;
							}
				 	}
			}
		}
		else
		if($cle_actuelle=="dettes_personnel")
		{
			$nbr_page=$bdd->get_var("SELECT count(*) FROM debits $filtre_bdd  $date_bdd  ");
		}
		if($cle_actuelle=="creances_personnel")
		{
			$nbr_page=$bdd->get_var("SELECT count(*) FROM creances $filtre_bdd  $date_bdd  ");
		}
	echo json_encode($nbr_page);
?>
