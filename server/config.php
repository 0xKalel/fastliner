<?php 
if(!isset($reference)) $reference="php/";
include($reference."ezSQL/shared/ez_sql_core.php"); 
include($reference."ezSQL/mysqli/ez_sql_mysqli.php"); 
$bdd = new ezSQL_mysqli('mondersky','mondersky','fastliner','monderskycom.ipagemysql.com');
 // $bdd = new ezSQL_mysqli('root','','fastliner','localhost');
//uilisez la fonction suivante pour securiser n'importe quelle variable entrante ou sortante  
function securiser($string){
	return addslashes(htmlspecialchars(trim($string))); 
}
function console_log($string){
	echo "<script type='text/javascript'>console.log('$string')</script>";
}
//cet objet contient tout les noms des champs du tableau routes ainsi que la syntaxe de leur nom sur la base de donnée

	$liste_pages = (object)array(
		// nom clé (nom de la table ou du fichier) => nom de la page
		"routes"=>"FRoutes"   ,
		"etats"=>"Etats"     ,
		"projets"=>"Projets"   ,
		"vehicules"=>"Vehicules"  ,
		"chauffeurs"=>"Chauffeurs",
		"prets"=>"Prets"      ,
		"debits"=>"debits" 
	);
	$liste_champs["routes"] = (object)array(
		"nfr"=>"N&deg;fr"              ,
		"date"=>"Date"             ,
		"nom"=>"Nom chauffeur"     ,
		"matricule"=>"Matricule"   ,
		"destination"=>"Destination",
		"idavance"=>"Avance"        ,
		"observation"=>"observation",
	);
	$liste_champs["etats"] = (object)array(
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
	$liste_champs["projets"] = (object)array(
		"projet"=>"Nom Projet"     ,
		"client"=>"Client"   ,
		"destination"=>"Destination",
		"date"=>"Date"             ,
		"prix"=>"Prix"        ,
		"observation"=>"observation",
	);
	$liste_champs["vehicules"] = (object)array(
		"nom"=>"Marque"             ,
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
	$liste_champs["chauffeurs"] = (object)array(
		"nom"=>"Nom" ,
		"paye"=>"Paye" ,
		"matricule"=> "Matricule Camion" ,
		"date"=>"date paye"
	);
	$liste_champs["prets"] = (object)array(
		"nom"=>"Nom" ,
		"date"=>"date" ,
		"avance"=> "avance" 
	);
	$liste_champs["debits"] = (object)array(
		"nom"=>"Nom" ,
		"date"=>"date" ,
		"avance"=> "somme" 
	);
?>