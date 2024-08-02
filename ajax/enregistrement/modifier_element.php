<?php
session_start();
if(isset($_SESSION["nom"])){
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	if(isset($cle_actuelle))
	{
		if($cle_actuelle=="routes"){
			$date_string= DateTime::createFromFormat('d/m/Y', $date);
			$date = $date_string->format('Y-m-d');
			$si_nfr_existe=0;
			if($ancien_idprojet!=$idprojet || $ancien_nfr!=$nfr)
				$si_nfr_existe=$bdd->get_var("SELECT COUNT(*) FROM routes WHERE nfr='$nfr' AND idprojet=$idprojet ");	
			if($si_nfr_existe==0){
				$fichier_bdd="";
				$path = "../../".$chemin_fichiers;
				$valid_formats = array("pdf", "PDF","png","jpeg","jpg");
				if(isset($_FILES["fichier"]["name"]) && $_FILES["fichier"]["name"]!="")
				{
					$name = $_FILES['fichier']['name'];
					$size = $_FILES['fichier']['size'];
					if(strlen($name))
					{
						list($txt, $ext) = explode(".", $name);
						if(in_array($ext,$valid_formats))
						{
							if($size<(3*1024*1024)) 
							{
								$actual_image_name = $nom."_".time().".".$ext;
								$tmp = $_FILES['fichier']['tmp_name'];
								$actual=$actual_image_name;
								if((move_uploaded_file($tmp, $path.$actual_image_name)) && isset($nom))
								{
									$fichier_bdd=",fichier='$actual'";
								}
								else{
									echo "le fichier n'a pas pu etre sauvegardé";
									break;
								}
							}
							else{
								echo "le fichier ne doit pas dépasser 3 MB";
								break;
							}
						}
						else{
							echo "le fichier doit etre du format pdf ou image";
							break;
						}
					}
					else{
						echo "le nom du fichier est incorrect. renomez le puis réessayez";
						break;
					}
				} 
				$bdd->query("UPDATE routes SET nom='$nom',date='$date',matricule='$matricule',nfr='$nfr',poids='$poids',idproduit='$idproduit',idprojet='$idprojet',prix='$prix',ndocument='$ndocument',observation='$observation',receptionne='$receptionne',iditineraire=$iditineraire $fichier_bdd WHERE id=$id ");
			// $bdd->query("UPDATE routes SET nom='$nom',date='$date',matricule='$matricule',destination='$destination',nfr='$nfr',poids='$poids',idproduit='$idproduit',depart='$depart',idprojet='$idprojet',prix='$prix',ndocument='$ndocument',observation='$observation',receptionne='$receptionne' WHERE id=$id ");
				echo 1; //informations correctes
			}
			else
				echo "ce Nfr existe déja pour ce projet, veuillez en choisir un autre";
		}
		elseif($cle_actuelle=="projets"){
			$date_string= DateTime::createFromFormat('d/m/Y', $date);
			$date = $date_string->format('Y-m-d');
			$si_projet_existe=0;
			if($ancien_projet!=$projet)
				$si_projet_existe=$bdd->get_var("SELECT COUNT(*) FROM projets WHERE projet='$projet' ");	
			if($si_projet_existe==0){
				$bdd->query("UPDATE projets SET client='$client',projet='$projet',date='$date',prix='$prix',observation='$observation' WHERE id=$id ");
				echo 1; //informations correctes
			}
			else
				echo "ce nom de projet existe déja. veuillez en choisir un autre";
		}
		elseif($cle_actuelle=="vehicules"){
			$date_string= DateTime::createFromFormat('d/m/Y', $date_assurance);$date_assurance = $date_string->format('Y-m-d');
			$date_string= DateTime::createFromFormat('d/m/Y', $date_vignette);$date_vignette = $date_string->format('Y-m-d');
			$date_string= DateTime::createFromFormat('d/m/Y', $date_scanner);$date_scanner = $date_string->format('Y-m-d');
			$date_string= DateTime::createFromFormat('d/m/Y', $controle_technique);$controle_technique = $date_string->format('Y-m-d');
			$si_matricule_existe=0;
			if($ancien_matricule!=$matricule)
				$si_matricule_existe=$bdd->get_var("SELECT COUNT(*) FROM vehicules WHERE matricule='$matricule' ");	
			if($si_matricule_existe==0){
				$bdd->query("UPDATE vehicules SET marque='$marque',type='$type',matricule='$matricule',date_assurance='$date_assurance',date_vignette='$date_vignette',date_scanner='$date_scanner',controle_technique='$controle_technique',prix_assurance='$prix_assurance',prix_vignette='$prix_vignette',prix_scanner='$prix_scanner',prix_controle='$prix_controle' WHERE id=$id ");
				echo 1; //informations correctes
			}
			else
				echo "ce matricule existe déja. veuillez en choisir un autre";
		}
		elseif($cle_actuelle=="chauffeurs"){
			$date_string= DateTime::createFromFormat('d/m/Y', $date_assurance_chauffeur);$date_assurance_chauffeur = $date_string->format('Y-m-d');
			$date_string= DateTime::createFromFormat('d/m/Y', $date_chauffeur);$date_chauffeur = $date_string->format('Y-m-d');
			$si_nom_existe=0;
			if($ancien_nom!=$nom_chauffeur)
				$si_nom_existe=$bdd->get_var("SELECT COUNT(*) FROM vehicules WHERE nom_chauffeur='$nom_chauffeur' ");	
			if($si_nom_existe==0){
				$bdd->query("UPDATE vehicules SET nom_chauffeur='$nom_chauffeur',paye_chauffeur='$paye_chauffeur',date_assurance_chauffeur='$date_assurance_chauffeur',date_chauffeur='$date_chauffeur',assurance_chauffeur='$assurance_chauffeur' WHERE id=$id ");
				echo 1; //informations correctes
			}
			else
				echo "ce chauffeur occupe déja un autre véhicule veuillez en choisir un autre";
		}
		elseif($cle_actuelle=="dettes_personnel"){
			$date_string= DateTime::createFromFormat('d/m/Y', $date);
			$date = $date_string->format('Y-m-d');
			$bdd->query("UPDATE debits SET nom='$nom',objet='$objet',somme='$somme',date='$date' WHERE id=$id ");
			echo 1;
		}
		elseif($cle_actuelle=="creances_personnel"){
			$date_string= DateTime::createFromFormat('d/m/Y', $date);
			$date = $date_string->format('Y-m-d');
			$bdd->query("UPDATE creances SET nom='$nom',objet='$objet',somme='$somme',date='$date' WHERE id=$id ");
			echo 1;
		}
	}
	else echo "le formulaire n'a pas pu etre envoyé correctement";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";


?>