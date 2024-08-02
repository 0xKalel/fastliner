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
	$dateInput = explode('/',$controle_technique);
	$controle_technique = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
	$dateInput = explode('/',$date_assurance);
	$date_assurance = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
	$dateInput = explode('/',$date_vignette);
	$date_vignette = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
	$dateInput = explode('/',$date_scanner);
	$date_scanner = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
	$path = "../../elements/fichiers_vehicules/";
	$valid_formats = array("pdf", "PDF","jpg", "png", "gif", "bmp","jpeg");
	header('Content-type: text/html; charset=ANSI');
	if(isset($_FILES['fichier']))
	{
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{

			$name = $_FILES['fichier']['name'];
			$size = $_FILES['fichier']['size'];
			if(strlen($name))
			{
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				{
					if($size<(3*1024*1024)) // Image size max 3 MB
					{
					$actual_image_name = $nom_chauffeur."_".time().".".$ext;
					$tmp = $_FILES['fichier']['tmp_name'];
					$actual=$actual_image_name;
						if((move_uploaded_file($tmp, $path.$actual_image_name)) && isset($nom_chauffeur) )
						{
							if($bdd->query("INSERT INTO vehicules (type,matricule,date_assurance,date_vignette,date_scanner,controle_technique,prix_assurance,prix_vignette,prix_scanner,prix_controle,nom_chauffeur,paye_chauffeur,fichier) VALUES('$type','$matricule','$date_assurance','$date_vignette','$date_scanner','$controle_technique','$prix_assurance','$prix_vignette','$prix_scanner','$prix_controle','$nom_chauffeur','$paye_chauffeur','$actual')  "))
								echo 1;
							else{
								echo "erreur connexion";
								exit;
							}
						}
						else
						echo "le fichier n'a pas pu etre sauvegardé";
					}
				else
					echo "le fichier ne doit pas dépasser 3 MB";
				}
				else
					echo "format invalide..";
			}
		else
			echo "le nom du fichier est incorrect. renomez le puis réessayez";
		} 

	}
	else 
	{
		if(isset($nom_chauffeur))
		{
			if($bdd->query("INSERT INTO vehicules(nom_chauffeur,type,matricule,date_assurance,date_vignette,date_scanner,controle_technique,prix_assurance,prix_vignette,prix_scanner,prix_controle,paye_chauffeur)
				VALUES('$nom_chauffeur','$type','$matricule','$date_assurance','$date_vignette','$date_scanner','$controle_technique','$prix_assurance','$prix_vignette','$prix_scanner','$prix_controle','$paye_chauffeur')"))
			{		
				echo 1; 
			}
			
			else echo "erreur connexion";
		}
		else echo "les informations n'ont pas pu etre envoyées. réessayez"; 

	}
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>