<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	if(isset($_POST["valeur"]))
	{
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
		if(isset($date))
		{			
			$date_string= DateTime::createFromFormat('d/m/Y', $date);
			$date = $date_string->format('Y-m-d');
			if($bdd->query("INSERT INTO $table(valeur,date,$nom_id) VALUES('$valeur','$date',$id)"))
			{		
				echo 1; 
			}
			else echo "erreur connexion";
		}
		else echo "les informations n'ont pas pu etre envoyées. réessayez";
	}
	else echo "les informations n'ont pas pu etre envoyées. réessayez"; 
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>