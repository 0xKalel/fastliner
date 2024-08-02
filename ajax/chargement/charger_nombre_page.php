<?php 
	$reference="../../php/";
	include("../../php/config.php");
	$sortby="";
	$filtre_bdd="";
	$date_bdd="";
	$date_bddd="";
	$i=0;
	$projets="";
	$donnees_chargement=array();
	$nbr_page=0;
	foreach($_POST as $key=>$value)
	{
		if($key=="filtre")
			$$key=$value;
		else if($key=="interval_date")
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
				if(($cle_actuelle=="routes")||($cle_actuelle=="etats")){
						if($fc=="projet")
						{
							if($idprojet=$bdd->get_var("SELECT id FROM projets WHERE projet='$fv' "))
							{
								$filtre_bdd.="AND cible.idprojet = $idprojet ";
							} 
							else
							{
								echo -1;
								exit();
							}
						}
						else
							if(($fc=="depart")||($fc=="destination"))
							{
								$filtre_bdd.="AND it.$fc = '$fv' ";
							}
						else
						$filtre_bdd.="AND cible.$fc='$fv' ";	
					}
				else
				if($cle_actuelle=="chauffeurs")
							$filtre_bdd.="AND cible.$fc='$fv' ";
				else
				if($cle_actuelle=="dettes")
					{
						if($i==0)
						{
							if($fc=="projet")
							{
								$filtre_bdd.="WHERE p.$fc = '$fv' ";
							}
							else 
								$filtre_bdd.="WHERE cible.$fc = '$fv' ";
								$i=$i+1;
						}
						else
							if($fc=="projet")
								$filtre_bdd.="AND p.$fc = '$fv' ";
							else
								$filtre_bdd.="AND cible.$fc = '$fv' ";
					}
				else
					if(($cle_actuelle=="projets")||($cle_actuelle=="vehicules"))
						{
							if($i==0)
							{
								$filtre_bdd.="WHERE $fc ='$fv'";
								$i++;
							}else
							$filtre_bdd.="AND $fc='$fv'";
						}
				else
					if($cle_actuelle=="creances")
					{
						$filtre_bdd.="AND p.$fc ='$fv'";
					}
				}
				
	if(isset($interval_date))
	{
		if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
		$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
		$min_date = $min_date->format('Y-m-d');
		$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
		$max_date = $max_date->format('Y-m-d');
		if($cle_actuelle=="dettes")
			$date_bdd="AND avances.date BETWEEN '$min_date' AND '$max_date' ";
		else
		if($cle_actuelle=="creances")
			$date_bdd="AND p.date BETWEEN '$min_date' AND '$max_date' ";
		if($cle_actuelle=="etats")
		{
			$date_bdd="AND cible.date BETWEEN '$min_date' AND '$max_date' ";
			$date_bddd="AND avances.date BETWEEN '$min_date' AND '$max_date' ";
		}
		else
			if($cle_actuelle=="projets")
			{
				if($i==0)
				{
					$date_bdd="WHERE projets.date BETWEEN '$min_date' AND '$max_date' ";
					$i++;
				}
				else
					$date_bdd="AND projets.date BETWEEN '$min_date' AND '$max_date' ";
			}
			else
				$date_bdd="AND cible.date BETWEEN '$min_date' AND '$max_date' ";
		}
	}
	if(isset($projet))
		{
			$projets="WHERE p.projet='$projet' AND cible.idprojet=p.id AND cible.iditineraire=it.id";
		}
		else
	$projets="WHERE cible.idprojet=p.id AND iditineraire=it.id ";
	if($cle_actuelle=="dettes_personnel")
	{
		$nbr_page=$bdd->get_var("SELECT count(*) FROM debits AS cible $filtre_bdd $date_bdd");
	}
	else
	if($cle_actuelle=="creances_personnel")
	{
		$nbr_page=$bdd->get_var("SELECT count(*) FROM creances AS cible $filtre_bdd $date_bdd");
	}
	if(($cle_actuelle=="routes")||($cle_actuelle=="etats"))
		{
			if($cle_actuelle=="etats") $cle_actuelle="routes";
			$nbr_page=$bdd->get_var("SELECT count(*) FROM $cle_actuelle AS cible, projets AS p,itineraires AS it  $projets $filtre_bdd  $date_bdd");
		}
	else
	if(($cle_actuelle=="projets")||($cle_actuelle=="vehicules"))
		{	
			$nbr_page=$bdd->get_var("SELECT count(*) FROM $cle_actuelle $filtre_bdd  $date_bdd  ");
		}
	else
		if($cle_actuelle=="chauffeurs")
		{
			$nbr_page=$bdd->get_var("SELECT count(*) FROM vehicules AS cible WHERE cible.nom_chauffeur!='' $filtre_bdd  $date_bdd ");
		}
	else
		if($cle_actuelle=="creances")
		{
			$avances="( SELECT SUM(valeur) FROM avances_projets AS a WHERE a.idprojet=p.id )AS avances";
			if($donnees=$bdd->get_results("SELECT p.*,COUNT(cible.id) AS route,DATE_FORMAT(p.date,'%d/%c/%Y') AS date,$avances 
													FROM projets AS p,routes AS cible
													WHERE cible.idprojet=p.id $filtre_bdd $date_bdd 
													GROUP BY cible.idprojet	  
													  "))
			{
				foreach($donnees as $d)
					{
						$d->total_prix=($d->route)*($d->prix);
						$d->creances=($d->total_prix)-($d->avances);
						if (($d->creances)>0)
						$nbr_page=$nbr_page+1;
				 	}	
			}
			else
				echo -1;	
		}
	else
	if($cle_actuelle=="dettes")
		{
			if($donnees=$bdd->get_results("
												SELECT cible.*,SUM(valeur) AS avance,p.projet
												FROM routes AS cible
												INNER JOIN projets p
													ON p.id=cible.idprojet  
												INNER JOIN avances avances
													ON avances.idroute=cible.id  
												$filtre_bdd $date_bdd  
												GROUP BY cible.id , avances.idroute 
												HAVING avance<>cible.prix AND cible.prix-avance>-1
												
												"))
			{
			 	if(count($donnees))
			 	{
					foreach($donnees as $d)
					{
								$d->reste=($d->prix)-($d->avance);
								if($d->reste>0)
									$nbr_page=$nbr_page+1;
				 	}
				 }
				 else
				echo -1;
			}
			else
				echo -1;
		}
		echo $nbr_page;
?>
