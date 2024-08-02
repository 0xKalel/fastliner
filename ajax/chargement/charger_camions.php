<?php
	
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
	$sortby="";
	$filtre_bdd="";
	$date_bdd="";
	$i=0;
	$limite=5;
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
			if($i==0)
			{
				foreach($f as $fc=>$fv)
				$filtre_bdd.="WHERE $fc LIKE '$fv%'";
			}
			else
			{
				foreach($f as $fc=>$fv)
				$filtre_bdd.=" AND $fc LIKE '$fv%'";
			}
			$i++;
		}
	if(isset($interval_date))
	{
		if(!empty($interval_date["min"]) && !empty($interval_date["max"])){
		$min_date= DateTime::createFromFormat('Y/m/d', $interval_date["min"]);
		$min_date = $min_date->format('Y-m-d');
		$max_date= DateTime::createFromFormat('Y/m/d', $interval_date["max"]);
		$max_date = $max_date->format('Y-m-d');
		if(isset($filtre))
			$date_bdd="AND date BETWEEN '$min_date' AND '$max_date'  ";
		else
			$date_bdd="WHERE date BETWEEN '$min_date' AND '$max_date' ";
		}
	}
	$limite=15;
	$affiche=($page-1)*$limite;
	$donnees_camions=$bdd->get_results("SELECT * FROM camions $filtre_bdd $date_bdd $sortby LIMIT $affiche, $limite");
	$camions=array();
	if(count($donnees_camions))
		foreach($donnees_camions as $r)
		{
			$camion=array();
			foreach($r as $cle=>$valeur)
			{
				$camion[$cle]=securiser($valeur);
			}
			array_push($camions,$camion);
	 	}
	echo json_encode($camions);
?>
					