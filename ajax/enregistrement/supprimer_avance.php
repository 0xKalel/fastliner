<?php
session_start();
if(isset($_SESSION["nom"])){

	if(isset($_POST["id"])){
		$reference="../../php/";
		include("../../php/config.php");
		foreach($_POST as $key=>$value)
		{
			$$key=securiser($value);
		}
		switch($cle_actuelle){
			case("projets"):{
				$table="avances_projets";
			}
			break;
			case("routes"):
			case("etats"):{
				$table="avances";
			}
			break;
			case("dettes_personnel"):{
				$table="avances_debits";
			}
			break;
			case("creances_personnel"):{
				$table="avances_creances";
			}
			break;
		}
		if($donnees_utilisateurs=$bdd->query("DELETE FROM $table WHERE id='$id'"))
			echo 1;
		else echo "erreur connexion";
	}
	else
		echo "l'accès est interdit à cette page.";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>
