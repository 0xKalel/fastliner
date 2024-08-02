<?php	
$reference="../../php/";
include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
foreach($_POST as $key=>$value)
	$$key=$value;
switch($cle_actuelle){
	case("routes"):
	case("etats"):{
		$table="avances";
		$nom_id="idroute";
	}
	break;
	case("projets"):{
		$table="avances_projets";
		$nom_id="idprojet";
	}
	break;
	case("dettes_personnel"):{
		$table="avances_debits";
		$nom_id="id_debit";
	}
	break;
	case("creances_personnel"):{
		$table="avances_creances";
		$nom_id="id_creance";
	}
	break;
}
$donnees_avances=$bdd->get_results("SELECT *,DATE_FORMAT(date,'%d/%c/%Y') AS date  FROM $table WHERE $nom_id='$id' ORDER BY date ASC");
if(count($donnees_avances))
	echo json_encode($donnees_avances);
else
	echo -1;
?>
