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
	if($table=="chauffeurs") $table="vehicules";
	if (($table=="etats")||($table=="dettes")) $table="routes";
	if($table=="creances") $table="projets";
	if(isset($filtre))
		foreach($filtre as $f)
		{
			foreach($f as $fc=>$fv)
				if(($table=="projets")||($table=="vehicules"))
				{
					$filtre_bdd.="AND $fc ='$fv'";
				}
				else
					if(($table=="routes")&&($fc=='projet')){
						$idprojet=$bdd->get_var("SELECT id FROM projets WHERE projet='$fv' ");
						$filtre_bdd.=" AND r.idprojet = $idprojet AND r.iditineraire=it.id ";
					}
					if($table=="dettes")
					{
						if($i==0)
						{
							if($fc=='projet')
							{
								$idprojet=$bdd->get_var("SELECT id FROM projets WHERE projet='$fv' ");
								$filtre_bdd.=" WHERE routes.idprojet = $idprojet ";
							}
							$filtre_bdd.="WHERE $fc ='$fv'";
							$i++;
						}
						else
							if($fc=='projet')
								$filtre_bdd.=" AND routes.idprojet = $idprojet ";
							else
								$filtre_bdd.="AND $fc ='$fv'";	
					}
						if($table=="dettes_personnel")
						{
							if($i==0)
							{
								$filtre_bdd.="WHERE $fc ='$fv'";
								$i++;
							}else
							$filtre_bdd.="AND $fc ='$fv'";	
						}
						else
						{
							$filtre_bdd.=" AND r.$fc = '$fv' ";
							$i++;
						}
					}
					if (isset($chauffeurs)){
						$filtre_bdd.="AND r.nom_chauffeur!='' ";
						$i++;
					}
					if(isset($interval_date))
					{
						if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
							$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
							$min_date = $min_date->format('Y-m-d');
							$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
							$max_date = $max_date->format('Y-m-d');
							if($table=="dettes_personnel")
							{
								if($i==0)
								{
									$date_bdd="WHERE debits.date BETWEEN '$min_date' AND '$max_date' ";
									$i++;
								}
								else
									$date_bdd="AND debits.date BETWEEN '$min_date' AND '$max_date' ";
							}
							else if($table=="creances_personnel")
							{
								if($i==0)
								{
									$date_bdd="WHERE creances.date BETWEEN '$min_date' AND '$max_date' ";
									$i++;
								}
								else
									$date_bdd="AND creances.date BETWEEN '$min_date' AND '$max_date' ";
							}
							$date_bdd="AND r.date BETWEEN '$min_date' AND '$max_date' ";
						}
					}
					if(($table=="projets")||($table=="vehicules"))
					{
						$auto=$bdd->get_col("SELECT $champ FROM $table WHERE $champ LIKE '%$Lettre%'  $filtre_bdd  $date_bdd  GROUP BY $champ LIMIT 5 ");
					}
					else
					if($table=="dettes_personnel")
					{
						$auto=$bdd->get_col("SELECT $champ FROM debits WHERE $champ LIKE '%$Lettre%'  $filtre_bdd  $date_bdd  GROUP BY $champ LIMIT 5 ");
					}
					else
					if($table=="creances_personnel")
					{
						$auto=$bdd->get_col("SELECT $champ FROM creances WHERE $champ LIKE '%$Lettre%'  $filtre_bdd  $date_bdd  GROUP BY $champ LIMIT 5 ");
					}
					else
						{
							$projets="WHERE r.idprojet=p.id";
							if(($table=="routes")&&($champ=='projet'))
								{
									$champ="p.projet";
								}
							else if(($table=="routes")&&(($champ=='depart')||($champ=='destination')))
							{
								$champ="it.$champ";
							}
							else
								$champ="r.$champ";
							$auto= $bdd->get_col("SELECT $champ FROM $table AS r,projets AS p,itineraires AS it $projets AND $champ LIKE '%$Lettre%'  $filtre_bdd  $date_bdd  GROUP BY $champ LIMIT 5 ");  
						}
					echo  json_encode($auto);

							?>
