<?php
	$reference="../../php/";
	$filtre_bdd="";
	$date_bdd="";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
		if($key=="filtre")
			$$key=$value;
		elseif($key=="interval_date")
			$$key=$value;
		else
			$$key=$value;
	$i=0;
	if(isset($filtre))
		foreach($filtre as $f)
		foreach($f as $fc=>$fv)
		{
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
						$filtre_bdd.="WHERE cible.nom_chauffeur!='' ";
					else
						if($cle_actuelle=="creances")
							$filtre_bdd.="AND projets.$fc='$fv'";
						if($cle_actuelle=="dettes")
						{
							if($i==0)
							{
								if($fc=="projet")
								{
									$filtre_bdd.="AND p.$fc = '$fv' ";
								}
								else 
								{
								$filtre_bdd.="AND cible.$fc = '$fv' ";
								$i=$i+2;
								}
							}			
						else
							if($fc=="projet")
								$filtre_bdd.="AND p.$fc = '$fv' ";
							else
								$filtre_bdd.="AND cible.$fc = '$fv' ";
						}
						else
							if($cle_actuelle=="dettes_personnel")
							{
								if($i==0)
									{
										$filtre_bdd.="WHERE debits.$fc ='$fv'";
										$i++;
									}else
									$filtre_bdd.="AND debits.$fc='$fv'";
							}
						else	
							if($cle_actuelle=="creances_personnel")
							{
								if($i==0)
									{
										$filtre_bdd.="WHERE creances.$fc ='$fv'";
										$i++;
									}else
									$filtre_bdd.="AND creances.$fc='$fv'";
							}
					}
	if(isset($interval_date))
	{
		if(!empty($interval_date["min"]) && !empty($interval_date["max"]))
		{
			$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
			$min_date = $min_date->format('Y-m-d');
			$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
			$max_date = $max_date->format('Y-m-d');
				if($cle_actuelle=="creances")
					$date_bdd="AND avances_projets.date BETWEEN '$min_date' AND '$max_date' AND projets.date BETWEEN '$min_date' AND '$max_date'";
				else
				if($cle_actuelle=="dettes")
					$date_bdd="INNER JOIN avances dat ON dat.date BETWEEN '$min_date' AND '$max_date'  ";
				else
					if($cle_actuelle=="etats")
						$date_bdd=" AND (a.date BETWEEN '$min_date' AND '$max_date')";
				else
					if($cle_actuelle=="dettes_personnel")
						{
							if($i==0)
							{
								$date_bdd="WHERE debits.date BETWEEN '$min_date' AND '$max_date' ";
								$i++;
							}
							else
								$date_bdd="AND debits.date BETWEEN '$min_date' AND '$max_date'  ";
						}
				else
					if($cle_actuelle=="creances_personnel")
						{
							if($i==0)
											{
												$date_bdd="WHERE creances.date BETWEEN '$min_date' AND '$max_date' ";
												$i++;
											}
											else
												$date_bdd="AND creances.date BETWEEN '$min_date' AND '$max_date'  ";
						}
				else
				$date_bdd=" AND (a.date BETWEEN '$min_date' AND '$max_date') AND (cible.date BETWEEN '$min_date' AND '$max_date')  ";
		}
	}
	$projets="WHERE cible.idprojet=p.id AND cible.iditineraire=it.id";
	if($cle_actuelle=="dettes")
	{
		$avances=$bdd->get_row("SELECT SUM(alucard.uu) as total_prix,SUM(alucard.vv) as total_avances FROM(
									SELECT ultimate.id,SUM(ultimate.prix) as uu,SUM(ultimate.valeur) as vv FROM(
										SELECT e.id,e.prix,e.idprojet,e.valeur FROM(
											SELECT cible.id,cible.prix,cible.idprojet,a.valeur=4 AS valeur FROM avances AS a
												INNER JOIN routes cible ON a.idroute=cible.id 
												INNER JOIN projets p ON p.id=cible.idprojet $filtre_bdd $date_bdd
												GROUP BY cible.id) AS e
										UNION 

										SELECT cible.id,cible.prix=4,cible.idprojet,SUM(a.valeur) FROM avances as a
											INNER JOIN routes cible ON a.idroute=cible.id 
											INNER JOIN projets p ON p.id=cible.idprojet $filtre_bdd $date_bdd
											GROUP BY cible.id) AS ultimate
										GROUP BY ultimate.id
										HAVING SUM(ultimate.prix)>SUM(ultimate.valeur) ) AS alucard
			");
	}
	else
	if($cle_actuelle=="creances")
	{
		$nbr_routes="(SELECT COUNT(DISTINCT routes.id) FROM routes WHERE routes.idprojet=projets.id)";
		$a="(SELECT SUM(avances_projets.valeur) FROM avances_projets WHERE avances_projets.idprojet=projets.id $date_bdd) ";
		$avances=$bdd->get_row("SELECT SUM(tt.total_pri) AS total_prix,SUM(tt.total_avance) AS total_avances FROM
										(SELECT (SUM(DISTINCT projets.prix)*$nbr_routes) AS total_pri,SUM(DISTINCT $a) AS total_avance,projets.* FROM projets
											INNER JOIN avances_projets a ON a.idprojet=projets.id $filtre_bdd 
											INNER JOIN routes cible ON cible.idprojet=projets.id $filtre_bdd 
											GROUP BY projets.id
											HAVING total_pri-total_avance>0) AS tt 
													 ");
	}
	else
	if($cle_actuelle=="dettes_personnel")
	{	
		$a="(SELECT SUM(DISTINCT ad.valeur) FROM avances_debits as ad) AS total_avances";
		$avances=$bdd->get_row("SELECT SUM(debits.somme) AS total_prix,$a  FROM debits $filtre_bdd $date_bdd");	
	}
	else
		if($cle_actuelle=="creances_personnel")
	{
		$a="(SELECT SUM(DISTINCT ad.valeur) FROM avances_creances as ad) AS total_avances";
		$avances=$bdd->get_row("SELECT SUM(creances.somme) AS total_prix,$a FROM creances $filtre_bdd $date_bdd");
	}
	else
		if($cle_actuelle=="routes")
	{
$sum="()";
		$avances=$bdd->get_row("SELECT SUM(it.prix) AS total_prix FROM itineraires AS it,routes AS cible WHERE cible.iditineraire=it.id AND cible.idfacture=$idfacture ");
	}
	else
		$avances=$bdd->get_row("SELECT SUM(alucard.uu) as total_prix,SUM(alucard.vv) as total_avances FROM(
									SELECT ultimate.id,SUM(ultimate.prix) as uu,SUM(ultimate.valeur) as vv FROM(
										SELECT e.id,e.prix,e.idprojet,e.valeur FROM(
											SELECT cible.id,cible.prix,cible.idprojet,a.valeur=4 AS valeur FROM avances AS a
												INNER JOIN routes cible ON a.idroute=cible.id 
												INNER JOIN itineraires it ON cible.iditineraire=it.id
												INNER JOIN projets p ON p.id=cible.idprojet $filtre_bdd 
												 $date_bdd
												GROUP BY cible.id) AS e
										UNION 

										SELECT cible.id,cible.prix=4,cible.idprojet,SUM(a.valeur) FROM avances as a
											INNER JOIN routes cible ON a.idroute=cible.id 
											INNER JOIN itineraires it ON cible.iditineraire=it.id
											INNER JOIN projets p ON p.id=cible.idprojet $filtre_bdd 
										 	$date_bdd
											GROUP BY cible.id) AS ultimate
										GROUP BY ultimate.id
										 ) AS alucard"
								);
	if($cle_actuelle!="routes")
	{
	if (is_null($avances->total_prix)){$avances->total_prix=0;}
	if (is_null($avances->total_avances)){$avances->total_avances=0;}
	}else
	{
		if (is_null($avances->total_prix)){$avances->total_prix=0;}
	}
	if(count($avances))
	{	
		echo json_encode($avances);
	}
	else
		echo -1;
	