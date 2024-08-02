<?php
session_start();
if(isset($_SESSION["nom"])){

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
			{
				if($i==0)
					foreach($f as $fc=>$fv)
						$filtre_bdd.="WHERE $fc LIKE '$fv%'";
					else
						foreach($f as $fc=>$fv)
							$filtre_bdd.=" AND $fc LIKE '$fv%'";
						$i++;
					}
					if (isset($chauffeurs)){
						if($i==0)
							$filtre_bdd.="WHERE nom_chauffeur!=''";
						else
							$filtre_bdd.="AND nom_chauffeur!=''";
						$i++;
					}
					if(isset($interval_date))
					{
						if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
							$min_date= DateTime::createFromFormat('d/m/Y', $interval_date["min"]);
							$min_date = $min_date->format('Y-m-d');
							$max_date= DateTime::createFromFormat('d/m/Y', $interval_date["max"]);
							$max_date = $max_date->format('Y-m-d');
							if($i>0)
								$date_bdd="AND date BETWEEN '$min_date' AND '$max_date'  ";
							else
								$date_bdd="WHERE date BETWEEN '$min_date' AND '$max_date' ";
						}
					}
					$avances="( SELECT SUM(valeur) FROM avances WHERE avances.idroute=r.id )AS avances";
					$donnees_routes=$bdd->get_results("SELECT *,$avances FROM routes AS r $filtre_bdd $date_bdd ");
					if(count($donnees_routes)){
						foreach($donnees_routes as $r)
						{
							if(($r->prix)<=($r->avances))
							{
								$r->reste=0;
							} 
							else
								$r->reste=($r->prix)-($r->avances);
							if($r->reste>0)
								$bdd->query("INSERT INTO avances(valeur,idroute,date) VALUES($r->reste,$r->id,'".date("Y-m-d")."')");
						}
						echo 1;
					}
					else
						echo "erreur connexion";
				}
				else
					echo "votre session a expirée. actualisez la page et reconnectez vous";
