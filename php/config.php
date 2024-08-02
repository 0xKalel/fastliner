<?php 
if(!isset($reference)) $reference="php/";
include($reference."ezSQL/shared/ez_sql_core.php"); 
include($reference."ezSQL/mysqli/ez_sql_mysqli.php"); 
// $bdd = new ezSQL_mysqli('mondersky23','mondersky7123','fast_liner','localhost');
// $bdd = new ezSQL_mysqli('root','','fast_liner','localhost');
	$bdd=new ezSQL_mysqli('zach23','Zach23','fast_liner','localhost');
//uilisez la fonction suivante pour securiser n'importe quelle variable entrante ou sortante  
function securiser($string){
	return addslashes(htmlspecialchars(trim($string))); 
}
function console_log($string){
	echo "<script type='text/javascript'>console.log('$string')</script>";
}
function formatter_date($date){
	$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
	$newDateString = $myDateTime->format('d/m/Y');
	return $newDateString;
}
function formatter_date_inverse($date){
	$myDateTime = DateTime::createFromFormat('d/m/Y', $date);
	$newDateString = $myDateTime->format('Y-m-d');
	return $newDateString;
}
function fin($delai){
	$datelocal=date("Y-m-d");
	$debut=date("Y-m-d");
	$secondes=strtotime($datelocal);
	$secondes-=$delai*24*60*60;
	return date('Y-m-d', $secondes);
}
function prolonger($date,$string){
	$new=str_replace("-","",$date);
	$new=strtotime(str_replace('-','/', $date));
	return date("Y-m-d", strtotime($string, $new));	
}

//cet objet contient tout les noms des champs du tableau routes ainsi que la syntaxe de leur nom sur la base de donnée
$chemin_fichiers="elements/fichiers/";
$chemin_fichiers_vehicules="elements/fichiers_vehicules/";
$parametres=array();
$parametre=$bdd->get_results("SELECT * FROM parametres");
foreach($parametre as $p)
{
	$parametres[$p->etiquette]=$p->valeur;
}
$limite=$parametres["elements_par_page"];
if($parametres["type"]=="sous-traitant")
	$liste_pages = (object)array(
			// nom clé (nom de la table ou du fichier) => nom de la page
		"routes"=>"FRoutes",
		"etats"=>"Etats",
		"projets"=>"Projets",
		"dettes"=>"Dettes",
		"creances"=>"Créances",
		);
else
	$liste_pages = (object)array(
			// nom clé (nom de la table ou du fichier) => nom de la page
		"routes"=>"FRoutes",
		"etats"=>"Etats",
		"projets"=>"Projets",
		"vehicules"=>"Vehicules",
		"chauffeurs"=>"Chauffeurs",
		"dettes"=>"Dettes",
		"creances"=>"Créances",
		"rapport"=>"Rapport"
		);
$liste_pages_inaccesibles=array(
	"dettes",
	"creances",
	"rapport",
	"dettes_personnel",
	);
if(!isset($facturation)){
$liste_champs["routes"] = (object)array(
	"nfr"=>"N&deg;fr"              ,
	"date"=>"Date"             ,
	"nom"=>"Nom chauffeur"     ,
	"matricule"=>"Matricule"   ,
	"idavance"=>"Avance"        ,
	"idprojet"=>"idprojet"        ,
	"projet"=>"Projet"        ,
	"observation"=>"Observation",
	"prix"=>"Prix",
	"depart"=>"Depart",
	"destination"=>"Destination",
	"idproduit"=>"Produit",
	"poids"=>"Poids",
	"ndocument"=>"N&deg;doccument"
	);
} else {
	$liste_champs["routes"] = (object)array(
	"nfr"=>"N&deg;fr"              ,
	"date"=>"Date"             ,
	"nom"=>"Nom chauffeur"     ,
	"matricule"=>"Matricule"   ,
	"idavance"=>"Avance"        ,
	"idprojet"=>"idprojet"        ,
	"projet"=>"Projet"        ,
	"observation"=>"Observation",
	"prix"=>"Prix Fr",
	"price"=>"Prix Iti",
	"depart"=>"Depart",
	"destination"=>"Destination",
	"idproduit"=>"Produit",
	"poids"=>"Poids",
	"ndocument"=>"N&deg;doccument"
	);
}
$liste_champs["etats"] = (object)array(
	"projet"=>"Projet"        ,
	"nfr"=>"N&deg;fr"         ,
	"matricule"=>"Matricule"  ,
	"depart"=>"Départ"        ,
	"destination"=>"Destination",
	"date"=>"Date"            ,
	"prix"=>"Prix"        	  ,
	"avances"=>"Avances"   	  ,
	"reste"=>"Reste a payer"  ,
	);

$liste_champs["creances"] = (object)array(
	"projet"=>"Nom Projet"     ,
	"nom"=>"Facture"   ,
	"date"=>"Date"             ,
	"routes"=>"Rotations",
	"total_prix"=>"Total Prix" ,
	"creances"=>"Creances"        ,
	);
$liste_champs["projets"] = (object)array(
	"projet"=>"Nom Projet"     ,
	"client"=>"Client"   ,
	// "depart"=>"Depart"   ,
	// "destination"=>"Destination",
	"date"=>"Date"             ,
	"prix"=>"Prix"        ,
	"observation"=>"Observation",
	);
$liste_champs["vehicules"] = (object)array(
	"marque"=>"Marque"             ,
	"type"=>"Type"     ,
	"matricule"=>"Matricule"   ,
	"date_assurance"=>"Date assurance",
	"date_vignette"=>"Date vignette",
	"date_scanner"=>"Date scanner",
	"controle_technique"=>"Controle technique"
	);
$liste_champs["chauffeurs"] = (object)array(
	"nom_chauffeur"=>"Nom" ,
	"paye_chauffeur"=>"Paye" ,
	"date_chauffeur"=>"Date paye",
	"matricule"=> "Matricule Camion" ,
	"assurance_chauffeur"=> "assurance" ,
	"date_assurance_chauffeur"=>"Date assurance"
	);
$liste_champs["dettes"] = (object)array(
	"projet"=>"Projet"        ,
	"nfr"=>"N&deg;fr"              ,
	"nom"=>"Nom chauffeur"     ,
	"date"=>"Date"             ,
	"matricule"=>"Matricule"   ,
	"reste"=>"Dette",
	);
$liste_champs["debits"] = (object)array(
	"nom"=>"Nom" ,
	"date"=>"Date" ,
	"avance"=> "Somme" 
	);
$liste_champs["dettes_personnel"] = (object)array(
	"nom"=>"Nom" ,
	"objet"=>"objet" ,
	"date"=>"Date" ,
	"somme"=> "Somme",
	"avances"=>"Avances",
	"dette"=>"Dettes", 
	);
$liste_champs["creances_personnel"] = (object)array(
	"nom"=>"Nom" ,
	"objet"=>"Objet" ,
	"date"=>"Date" ,
	"somme"=> "Somme",
	"avances"=>"Avances",
	"creance"=>"Créances",
	);
$liste_champs["parametres"] = (object)array(
	"comptes"=>"Comptes" ,
	"parametres"=>"Parametres" ,
	);
$liste_champs["rapport"] = (object)array(
	);
$champs_prix=(object)array("prix","avance","avances","reste","paye_chauffeur","somme","creance","creances","dette","dettes","total_prix");
$delai_paye_chauffeur=3;
$delai_assurance=11;
$delai_vignette=11;
$delai_scanner=11;
$delai_assurance_chauffeur=31;
$delai_controle_technique=11;
//routes
define("MESSAGE_AJOUTER_FR", "cliquez ici pour ajouter une feuille de route");
define("MESSAGE_RECEPTIONNE", "cette feuille de route à étée réceptionnée");
define("MESSAGE_FICHIER_ROUTES", "attacher un fichier image ou PDF à la feuille de route");
define("MESSAGE_SELECTION_ITINERAIRE", "choisir parmis les itineraires du projet");
define("MESSAGE_IMPRIMER_FR", "afficher/imprimer");

//projets
define("MESSAGE_AJOUTER_PROJET", "cliquez ici pour ajouter un projet");
define("MESSAGE_GERER_ITINERAIRES", "gérer les itinéraires de ce projet");
define("MESSAGE_LISTE_ETATS_PROJET", "afficher les états des FRs liées à ce projet");
define("MESSAGE_GERER_FACTURE", "gérer les factures de ce projet");
define("MESSAGE_DATE_FACTURE", "date de la facturation");
define("MESSAGE_ASSIGNER_FRS", "gérer les FRs assignées à cette facture");
define("MESSAGE_NOMBRE_FRS", "nombre de FRs assignées à cette facture");
define("MESSAGE_TOTAL_PRIX_FACTURE", "prix calculé selon les itineraires des routes assignées");

//dettes
define("MESSAGE_AJOUTER_DETTE_PERSONELLE", "cliquez ici pour ajouter une dette personelle");

//etats
define("MESSAGE_ETAT_REGLE", "feuille de route réglée");
define("MESSAGE_ETAT_SANS_AVANCE", "feuille de route sans aucune avance");
define("MESSAGE_ETAT_NON_REGLE", "feuille de route pas encore réglée");

//creances
define("MESSAGE_AJOUTER_CREANCE_PERSONELLE", "cliquez ici pour ajouter une créance personelle");

//vehicules
define("MESSAGE_AJOUTER_VEHICULE", "cliquez ici pour ajouter un vehicule");
define("MESSAGE_FICHIER_VEHICULES", "attacher un fichier image ou PDF au camion");

//chauffeur
define("MESSAGE_AJOUTER_CHAUFFEUR", "cliquez ici pour ajouter un chauffeur");

//parametres
define("MESSAGE_PARAMETRES", "parametres");
define("MESSAGE_SUFFIXE", "symbole à afficher à la fin de chaque chiffres");
define("MESSAGE_TYPE_ENTREPRISE", "adapter l'application au type de votre entreprise");
define("MESSAGE_ELEMENTS_PAR_TABLEAU", "le nombre maximale de lignes sur une page");
define("MESSAGE_SUPPRIMER_UTILISATEUR", "supprimer l\'utilisateur");
define("CONFIRMATION_SUPPRIMER_UTILISATEUR","etes vous sur de vouloir supprimer cet utilisateur?");

//general
try{
	define("MESSAGE_ORDRE_TABLEAU", "cliquez ici pour classer le tableau selon ce champ. cliquez de nouveau pour changer de direction");
	define("MESSAGE_AJOUTER_AVANCE", "ajouter une avance");
	define("MESSAGE_MODIFIER", "modifier les informations de cette ligne");
	define("MESSAGE_AFFICHER_FICHIER", "ouvrir le fichier dans un nouvel onglet");
	define("MESSAGE_FICHIER_VIDE", "aucun fichier n\'est attaché à cet élément");
	define("MESSAGE_PREMIERE_PAGE", "aller à la premiere page");
	define("MESSAGE_DERNIERE_PAGE", "aller à la dernière page");
	define("MESSAGE_INTERVALLE_DATE", "cliquez ici pour choisir un intervalle de date");
	define("MESSAGE_CHAMP_FILTRE", "taper un mot à rechercher");
	define("MESSAGE_SELECTION_FILTRE", "choisir par quel champ rechercher");
	define("MESSAGE_FILTRER", "rechercher un résultat");
	define("MESSAGE_FERMER_FORMULAIRE", "cliquez ici pour fermer le formulaire d'ajout");
	define("MESSAGE_SUPPRIMER_AVANCE", "supprimer l'avance");
	define("MESSAGE_VALEUR_NOUVELLE_AVANCE", "valeur de la nouvelle avance");
	define("MESSAGE_DATE_NOUVELLE_AVANCE", "date de la nouvelle avance");
	define("MESSAGE_FERMER_FENETRE", "fermer la fenetre");
	define("MESSAGE_NOM_UTILISATEUR", "nom d'utilisateur");
	define("MESSAGE_DECONNEXION", "Se déconnecter");
}
catch(Exception $e){
	echo "ok";
}

?>
