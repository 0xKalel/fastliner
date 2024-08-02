<?php
$reference="../../php/";
include("../../php/config.php");
foreach($_POST as $key=>$value)
{
	$$key=$value;
}
$date="";
switch($cle_actuelle){
	case("vehicules"):{
		$date=",DATE_FORMAT(date_assurance,'%d/%c/%Y') AS date_assurance,DATE_FORMAT(date_vignette,'%d/%c/%Y') AS date_vignette,DATE_FORMAT(date_scanner,'%d/%c/%Y') AS date_scanner,DATE_FORMAT(controle_technique,'%d/%c/%Y') AS controle_technique";
		$date.=",DATE_FORMAT(date_assurance_chauffeur,'%d/%c/%Y') AS date_assurance_chauffeur,DATE_FORMAT(date_chauffeur,'%d/%c/%Y') AS date_chauffeur";
	}
	break;
	case("chauffeurs"):{
		$date=",DATE_FORMAT(date_assurance_chauffeur,'%d/%c/%Y') AS date_assurance_chauffeur,DATE_FORMAT(date_chauffeur,'%d/%c/%Y') AS date_chauffeur";
	}
	break;
	default:
		$date=",DATE_FORMAT(date,'%d/%c/%Y') AS date";
	break;
}
switch($cle_actuelle){
	case("dettes_personnel"):{
		$cle_actuelle="debits";
		$avances_debits=0;
	}
	break;
	case("creances_personnel"):{
		$cle_actuelle="creances";
		$avances_creances=0;
	}
	break;
	case("projets"):{
		$avances_projets=0;
	}
	break;
	case("routes"):{
		$avances_routes=0;
	}
	break;
	case("chauffeurs"):{
		$cle_actuelle="vehicules";
	}
	break;
}
if(isset($avances_creances))
{
	$donnees_valeurs=$bdd->get_row("SELECT creances.*,DATE_FORMAT(creances.date,'%d/%c/%Y') AS date,creances.somme AS somme,SUM(ac.valeur) AS avances FROM creances AS creances
									LEFT JOIN avances_creances ac ON id_creance=$id
								WHERE creances.id=$id  ");
}else
if(isset($avances_debits))
{
	$donnees_valeurs=$bdd->get_row("SELECT debits.*,DATE_FORMAT(debits.date,'%d/%c/%Y') AS date,debits.somme AS somme,SUM(ad.valeur) AS avances FROM debits AS debits
									LEFT JOIN avances_debits ad ON id_debit=$id
								WHERE debits.id=$id  ");
}else
if(isset($avances_projets))
{
	$donnees_valeurs=$bdd->get_row("SELECT projets.*,DATE_FORMAT(projets.date,'%d/%c/%Y') AS date,projets.prix AS prix,SUM(ap.valeur) AS avances FROM projets AS projets
									LEFT JOIN avances_projets ap ON ap.idprojet=$id
								WHERE projets.id=$id  ");
}else
if(isset($avances_routes))
{
	$donnees_valeurs=$bdd->get_row("SELECT routes.*,DATE_FORMAT(routes.date,'%d/%c/%Y') AS date,routes.prix AS prix,SUM(ar.valeur) AS avances FROM routes AS routes
									LEFT JOIN avances ar ON ar.idroute=$id
								WHERE routes.id=$id  ");
}else
$donnees_valeurs=$bdd->get_row("SELECT * $date FROM $cle_actuelle WHERE id=$id");

echo json_encode($donnees_valeurs);
?>
