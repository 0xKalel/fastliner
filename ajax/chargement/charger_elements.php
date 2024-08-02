<?php 
$reference="../../php/";
include("../../php/config.php");
$sortby="";
$filtre_bdd="";
$date_bdd="";
$i=0;
$projets="";
$mode_reglage="";
$donnees_chargement=array();
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
						if($cle_actuelle=="dettes_personnel")
						{
							if($i==0)
							{
								$filtre_bdd.="WHERE debits.$fc = '$fv'";
								$i++;
							}
							else
								$filtre_bdd.="AND debits.$fc = '$fv'";
						}
						else
							if($cle_actuelle=="creances_personnel")
							{
								if($i==0)
								{
									$filtre_bdd.="WHERE creances.$fc = '$fv'";
									$i++;
								}
								else
									$filtre_bdd.="AND creances.$fc = '$fv'";
							}
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
										$date_bdd2="WHERE mondersky.id=q.idroute";
										if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
											$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
											$min_date = $min_date->format('Y-m-d');
											$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
											$max_date = $max_date->format('Y-m-d');
											if($cle_actuelle=="dettes"){
												$date_bdd="AND avances.date BETWEEN '$min_date' AND '$max_date' ";
												$date_bdd2="WHERE q.date BETWEEN '$min_date' AND '$max_date' ";

											}
											if($cle_actuelle=="routes"){
												$date_bdd="AND cible.date BETWEEN '$min_date' AND '$max_date'";
											}
											else
												if($cle_actuelle=="dettes_personnel"){
													if($i==0)
													{
														$date_bdd="WHERE debits.date BETWEEN '$min_date' AND '$max_date' ";
														$i++;
													}
													else
														$date_bdd="AND debits.date BETWEEN '$min_date' AND '$max_date'  ";
												}
												else
													if($cle_actuelle=="creances_personnel"){
														if($i==0)
														{
															$date_bdd="WHERE creances.date BETWEEN '$min_date' AND '$max_date' ";
															$i++;
														}
														else
															$date_bdd="AND creances.date BETWEEN '$min_date' AND '$max_date'  ";
													}
													else
														if($cle_actuelle=="creances"){
															$date_bdd="AND p.date BETWEEN '$min_date' AND '$max_date'";
														}
														else
														{
															$date_bdd="AND avances.date BETWEEN '$min_date' AND '$max_date' ";
														}

														$date_bdd2="WHERE q.date BETWEEN '$min_date' AND '$max_date' AND mondersky.id=q.idroute";
													}
												}
												$projets="WHERE cible.idprojet=p.id AND cible.iditineraire=it.id";
												$affiche=($page-1)*$limite;
												if(isset($reglage))
													if($reglage==0)
													{
														$mode_reglage="HAVING avances < cible.prix";
													}
													else
														$mode_reglage="";

													if($cle_actuelle=="routes")
													{
														if(isset($idprojet))	
														{
															if($donnees_chargement=$bdd->get_results(
																"SELECT x.* FROM(SELECT cible.*,DATE_FORMAT(cible.date,'%d/%c/%Y') AS date2,it.prix AS price,p.projet,it.depart,it.destination FROM $cle_actuelle AS cible,itineraires AS it,projets AS p WHERE p.id=$idprojet ) AS x WHERE x.idprojet=$idprojet $sortby LIMIT $affiche, $limite"))
															{
																echo json_encode($donnees_chargement);
																exit();
															}
															else
															{
																echo -1;
																exit();
															}
														}else
														{
															if($donnees_chargement=$bdd->get_results("SELECT cible.*,DATE_FORMAT(cible.date,'%d/%c/%Y') AS date2,p.projet,it.depart,it.destination FROM $cle_actuelle AS cible,itineraires AS it,projets AS p $projets $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite"))
															{
																echo json_encode($donnees_chargement);
																exit();
															}
															else
															{
																echo -1;
																exit();
															}
														}
													}
													else
														if($cle_actuelle=="etats")
														{
															$avances="( SELECT SUM(valeur) FROM avances WHERE avances.idroute=cible.id $date_bdd )AS avances";
															if($donnees=$bdd->get_results("SELECT mondersky.* FROM (
																SELECT cible.*,DATE_FORMAT(cible.date,'%d/%c/%Y') AS date2,$avances,p.projet,it.depart,it.destination 
																FROM routes AS cible,itineraires AS it,projets AS p
																$projets $filtre_bdd  
																$mode_reglage	
																$sortby												LIMIT $affiche, $limite) AS mondersky WHERE mondersky.id IN(SELECT q.idroute FROM avances AS q $date_bdd2 ) "))
															{
																foreach($donnees as $d)
																{
																	$d->date=$d->date2;
																	if(($d->prix)<=($d->avances))
																	{
																		$d->reste=0;
																	} 
																	else
																		$d->reste=($d->prix)-($d->avances);
																	array_push($donnees_chargement,$d);
																}
																echo json_encode($donnees_chargement);
																exit();	
															}
															else
																echo -1;
															exit();
														}
														else 
															if($cle_actuelle=="chauffeurs")
															{
																$donnees_chargement=$bdd->get_results("SELECT cible.nom_chauffeur,cible.id, DATE_FORMAT(cible.date_chauffeur,'%d/%c/%Y') AS date_chauffeur, cible.matricule,cible.paye_chauffeur,cible.date_chauffeur,cible.assurance_chauffeur,cible.date_assurance_chauffeur FROM vehicules AS cible WHERE cible.nom_chauffeur!='' $filtre_bdd  $date_bdd $sortby LIMIT $affiche, $limite");
															}
															else
																if($cle_actuelle=="projets")
																{
																	if($donnees_chargement=$bdd->get_results("SELECT *,DATE_FORMAT(date,'%d/%c/%Y') AS date FROM $cle_actuelle $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite"))
																	{
																		echo json_encode($donnees_chargement);
																		exit();
																	}
																	else
																		echo -1;
																	exit();

																}
																else
																	if($cle_actuelle=="creances")
																	{
																		$count="(SELECT COUNT(cible.id) FROM routes AS cible WHERE cible.idfacture=f.id ) AS routes";
																		$sum="(SELECT SUM(it.prix) FROM itineraires AS it WHERE cible.iditineraire=it.id AND cible.idfacture=f.id )";
																		if($donnees_chargement=$bdd->get_results("SELECT f.id,f.nom,f.date,p.projet,$count,SUM($sum)AS total_prix
																			FROM factures AS f
																			INNER JOIN projets p ON p.id=f.idprojet
																			INNER JOIN routes cible ON cible.idprojet=p.id
																			INNER JOIN itineraires it ON cible.iditineraire=it.id
																			GROUP BY f.id"))
																		{
																			foreach($donnees_chargement as $d)
																			{
																				if (is_null($d->total_prix)){$d->total_prix=0;}
																				if (is_null($d->routes)){$d->routes=0;}
																			}
																			echo json_encode($donnees_chargement);
																			exit();	
																		}
																		else
																			echo json_encode($donnees_chargement);
																		exit();
																	}
																	else
																		if($cle_actuelle=="vehicules")
																		{
																			if($donnees_chargement=$bdd->get_results("SELECT *, DATE_FORMAT(date_chauffeur,'%d/%c/%Y') AS date_chauffeur,DATE_FORMAT(date_assurance,'%d/%c/%Y') AS date_assurance,DATE_FORMAT(date_vignette,'%d/%c/%Y') AS date_vignette,DATE_FORMAT(date_scanner,'%d/%c/%Y') AS date_scanner,DATE_FORMAT(controle_technique,'%d/%c/%Y') AS controle_technique FROM $cle_actuelle $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite"))
																			{
																				echo json_encode($donnees_chargement);
																				exit();
																			}
																			else{
																				echo -1;
																				exit();
																			}
																		}
																		else
																			if($cle_actuelle=="dettes")
																			{
																				if($donnees=$bdd->get_results("
																					SELECT cible.*,DATE_FORMAT(cible.date,'%d/%c/%Y') AS date,SUM(valeur) AS avance,p.projet
																					FROM routes AS cible
																					INNER JOIN projets p
																					ON p.id=cible.idprojet  
																					LEFT JOIN avances avances
																					ON avances.idroute=cible.id  $filtre_bdd $date_bdd  
																					GROUP BY cible.id, avances.idroute
																					HAVING avance<>cible.prix AND cible.prix-avance>-1
																					$sortby
																					LIMIT $affiche, $limite
																					"))
																					foreach($donnees as $d)
																					{			
																						$d->reste=$d->prix-$d->avance;
																						array_push($donnees_chargement,$d);


																					} else
																					{
																						echo -1;
																						exit();
																					}

																				}
																				if($cle_actuelle=="dettes_personnel")
																				{

																					if($donnees_chargement=$bdd->get_results("SELECT debits.*, DATE_FORMAT(debits.date,'%d/%c/%Y') AS date,SUM(ad.valeur) AS avances 
																						FROM debits AS debits
																						LEFT JOIN avances_debits ad ON ad.id_debit=debits.id 
																						$filtre_bdd $date_bdd
																						GROUP BY debits.id
																						$sortby LIMIT $affiche, $limite"))
																					{	
																						foreach($donnees_chargement as $d)
																						{
																							if(is_null($d->avances))$d->avances=0;
																							$d->dette=$d->somme-$d->avances;
																						}



																						echo json_encode($donnees_chargement);
																						exit();
																					}
																					else{
																						echo -1;
																						exit();
																					}
																				}
																				if($cle_actuelle=="creances_personnel")
																				{
																					if($donnees_chargement=$bdd->get_results("SELECT creances.*, DATE_FORMAT(creances.date,'%d/%c/%Y') AS date,SUM(ac.valeur) AS avances
																						FROM creances AS creances
																						LEFT JOIN avances_creances ac ON ac.id_creance=creances.id 
																						$filtre_bdd $date_bdd
																						GROUP BY creances.id
																						$sortby LIMIT $affiche, $limite"))
																					{
																						foreach($donnees_chargement as $d)
																						{
																							if(is_null($d->avances))$d->avances=0;
																							$d->creance=$d->somme-$d->avances;
																						}
																						echo json_encode($donnees_chargement);
																						exit();
																					}
																					else{
																						echo -1;
																						exit();
																					}
																				}
																				if(count($donnees_chargement))
																					echo json_encode($donnees_chargement);
																				else
																					echo -1;
																				?>

