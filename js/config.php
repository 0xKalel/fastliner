<?php 
header('Content-type: text/html; charset=ANSI'); 
if(!isset($reference)) $reference="php/";
include($reference."ezSQL/shared/ez_sql_core.php"); 
include($reference."ezSQL/mysqli/ez_sql_mysqli.php"); 
$bdd = new ezSQL_mysqli('mondersky','mondersky','fastliner','monderskycom.ipagemysql.com ');
// $bdd = new ezSQL_mysqli('root','','fastliner','localhost');
//uilisez la fonction suivante pour securiser n'importe quelle variable entrante ou sortante  
function securiser($string)
	{
		return addslashes(htmlspecialchars(trim($string))); 
	}
//cet objet contient tout les noms des champs du tableau routes ainsi que la syntaxe de leur nom sur la base de donnée

	$champs = (object)array(
		"nfr"=>"N&deg;fr"              ,
		"date"=>"Date"             ,
		"nom"=>"Nom chauffeur"     ,
		"matricule"=>"Matricule"   ,
		"destination"=>"Destination",
		"idproduit"=>"N&deg;produit"    ,
		"poids"=>"Poids"            ,
		"ndocument"=>"N&deg;document"    ,
		"idavance"=>"Avance"        ,
		"observation"=>"observation",
	);
	$champs_etats = (object)array(
		"nfr"=>"N&deg;fr"              ,
		"date"=>"Date"             ,
		"nom"=>"Nom chauffeur"     ,
		"matricule"=>"Matricule"   ,
		"destination"=>"Destination",
		"idproduit"=>"N&deg;produit"    ,
		"poids"=>"Poids"            ,
		"ndocument"=>"N&deg;document"    ,
		"idavance"=>"Avance"        ,
		"prix"=>"Prix"        ,
		"observation"=>"observation",
	);
	$champs_projets = (object)array(
		"date"=>"Date"             ,
		"projet"=>"Projet"     ,
		"client"=>"Client"   ,
		"destination"=>"Destination",
		"prix"=>"Prix"        ,
		"observation"=>"observation",
	);
	$champs_camions = (object)array(
		"nom"=>"nom"             ,
		"type"=>"type"     ,
		"matricule"=>"matricule"   ,
		"date_assurance"=>"date assurance",
		"date_vignette"=>"date vignette"        ,
		"date_scanner"=>"date scanner",
		"controle_technique"=>"controle technique",
		"prix_assurance"=>"prix assurance",
		"prix_vignette"=>"prix vignette",
		"prix_scanner"=>"prix scanner",
		"prix_controle"=>"prix controle",
		
	);
	$champs_chauffeurs = (object)array(
	"nom"=>"Nom" ,
	"paye"=>"Paye" ,
	"matricule"=> "Matricule Camion" ,
	);
?>