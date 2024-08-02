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
	$date_string= DateTime::createFromFormat('d/m/Y', $date);
	$date = $date_string->format('Y-m-d');
	//modifis le code suivant pour enregistrer les differents champs de chaque route, n'oublis pas de faire le test pour verifier si un champs obligatoire
	//est vide ou non, chaque champs doit etre ecrit selon les normes de son type, le nom du chauffeur ne doit pas contenir de chiffre par example
	// remplace les variables tableaux par des variables simples, au lieu d'ecrire $_POST["nom_chauffeur"] ecrit $nom_chauffeur c'est deja pret utilise ou ma thawesch tefhem

	if(isset($nom))
	{			
		if($bdd->query("INSERT INTO creances(nom,date,somme,objet) VALUES('$nom','$date','$somme','$objet')"))
		{		
			$id_creance=$bdd->insert_id;
			if(!$bdd->query("INSERT INTO avances_creances(valeur,date,id_creance) VALUES(0,'$date','$id_creance')")){
				echo "erreur connexion";
				exit;
			}
			else
			echo 1; //informations correctes
	}
	else echo "erreur connexion";
}
else echo "les informations n'ont pas pu etre envoyées. réessayez";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>