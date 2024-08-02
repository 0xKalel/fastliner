<?php
session_start();
if(isset($_SESSION["nom"])){
	$avance=0;
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securis
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	if(str_replace(" ","",$avance)=="")
		$avance=0;
	$date_string= DateTime::createFromFormat('d/m/Y', $date);
	$date = $date_string->format('Y-m-d');
	if(isset($nom))
	{			
		if($bdd->query("INSERT INTO debits(nom,date,somme,objet) VALUES('$nom','$date','$somme','$objet')"))
		{		
			$id_debit=$bdd->insert_id;
			if(!$bdd->query("INSERT INTO avances_debits(valeur,date,id_debit) VALUES(0,'$date','$id_debit')")){
				echo "erreur connexion";
				exit;
			}
			else
				echo 1; 
		}
		else echo "erreur connexion";
	}
	else echo "les informations n'ont pas pu etre envoyées. réessayez";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>