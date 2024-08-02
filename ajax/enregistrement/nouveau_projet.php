<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	//la boucle suivante prepare les variables et les securis
	$avance=0;
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	if(str_replace(" ","",$avance)=="")
		$avance=0;
	$dateInput = explode('/',$date);
	$date = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
	//modifis le code suivant pour enregistrer les differents champs de chaque route, n'oublis pas de faire le test pour verifier si un champs obligatoire
	//est vide ou non, chaque champs doit etre ecrit selon les normes de son type, le nom du chauffeur ne doit pas contenir de chiffre par example
	// remplace les variables tableaux par des variables simples, au lieu d'ecrire $_POST["nom_chauffeur"] ecrit $nom_chauffeur c'est deja pret utilise ou ma thawesch tefhem
	$si_projet_existe=$bdd->get_var("SELECT COUNT(*) FROM projets WHERE projet='$projet' ");
	if($si_projet_existe==0)
		if(isset($client))
		{
			if($bdd->query("INSERT INTO projets(client,projet,date,observation)
				VALUES('$client','$projet','$date','$observation')"))
			{		
				$idprojet=$bdd->insert_id;
				if(!$bdd->query("insert INTO itineraires(depart,destination,prix,idprojet) VALUES('$depart','$destination','$prix','$idprojet')")){
					echo "erreur connexion";
					exit;
				}
				if($avance>0)
					if(!$bdd->query("INSERT INTO avances_projets(valeur,date,idprojet) VALUES(0,'$date','$idprojet')")){
						echo "erreur connexion";
						exit;
					}
					if($bdd->query("INSERT INTO avances_projets(valeur,date,idprojet) VALUES('$avance','$date','$idprojet')"))
					{		
						echo 1; 
					}
					else echo "erreur connexion";
				}
				else echo "erreur connexion"; 
			}
			else 
				echo "le formulaire n'a pas pu etre envoyé correctement. veuillez réessayer";
			else
				echo "ce nom de projet existe déja. veuillez en choisir un autre";
		}
		else
			echo "votre session a expirée. actualisez la page et reconnectez vous";

		?>