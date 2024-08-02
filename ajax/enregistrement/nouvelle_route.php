<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securis
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	//modifis le code suivant pour enregistrer les differents champs de chaque route, n'oublis pas de faire le test pour verifier si un champs obligatoire
	//est vide ou non, chaque champs doit etre ecrit selon les normes de son type, le nom du chauffeur ne doit pas contenir de chiffre par example
	// remplace les variables tableaux par des variables simples, au lieu d'ecrire $_POST["nom_chauffeur"] ecrit $nom_chauffeur c'est deja pret utilise ou ma thawesch tefhem
	if(isset($_POST["nom"]))
	{		
		$si_nfr_existe=$bdd->get_var("SELECT COUNT(*) FROM routes WHERE nfr='$nfr' AND idprojet=$idprojet ");
		if($bdd->query("INSERT INTO routes(nom,date,matricule,destination,nfr,poids,ndocument,observation,idproduit,depart,receptionne) VALUES('$nom','$date','$matricule','$destination','$nfr','$poids','$n_document','$observation','$idproduit','$depart',$receptionne)"))
		{		
			echo 1; //informations correctes
		}
		else {
			echo "erreur connexion";
			exit;
		}
		//informations incorrectes
		$idroute=$bdd->insert_id;
		if($bdd->query("INSERT INTO avances(avance,date,idroute) VALUES('$avance','$date','$idroute')"))
		{		
			echo 1; //informations correctes
		}
		else echo "erreur connexion";
	}
	else echo "le formulaire n'a pas pu etre envoyé correctement. veuillez réessayer";
	?>