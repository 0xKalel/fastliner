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
	$date_string= DateTime::createFromFormat('d/m/Y', $date);
	$date = $date_string->format('Y-m-d');
	$path = "../../".$chemin_fichiers;
	$valid_formats = array("pdf", "PDF","jpg", "png", "gif", "bmp","jpeg");
	$error=-1;
	if(isset($_FILES["fichier"]))
	{
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['fichier']['name'];
			$size = $_FILES['fichier']['size'];
			if(strlen($name)){
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				{
				if($size<(3*1024*1024)) // Image size max 3 MB
				{
					$actual_image_name = $nom."_".time().".".$ext;
					$tmp = $_FILES['fichier']['tmp_name'];
					$actual=$actual_image_name;
					if((move_uploaded_file($tmp, $path.$actual_image_name)) && isset($nom))
					{
						if($produits= $bdd->query("INSERT INTO routes (nom,date,matricule,nfr,poids,ndocument,observation,idproduit,idprojet,iditineraire,fichier,prix,receptionne) VALUES('$nom','$date','$matricule','$nfr','$poids','$n_document','$observation','$idproduit','$idprojet',$iditineraire,'$actual',$prix,$receptionne)  "))
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
				echo "le fichier doit etre du format pdf ou image";
		}
		else
			echo "le nom du fichier est incorrect. renomez le puis réessayez";
	} 

}
else 
{
	if(isset($nom)){
		$si_nfr_existe=$bdd->get_var("SELECT COUNT(*) FROM routes WHERE nfr='$nfr' AND idprojet=$idprojet ");	
		if($si_nfr_existe==0)		
			if($bdd->query("INSERT INTO routes(nom,date,matricule,nfr,poids,ndocument,observation,idproduit,idprojet,iditineraire,prix,receptionne) VALUES('$nom','$date','$matricule','$nfr','$poids','$n_document','$observation','$idproduit','$idprojet',$iditineraire,$prix,$receptionne)"))
			{		
				$error=0; //informations correctes
				$idroute=$bdd->insert_id;
				if($avance>0)
					if(!$bdd->query("INSERT INTO avances(valeur,date,idroute) VALUES(0,'$date','$idroute')")){
						echo "erreur connexion";
						exit;
					}
					if($bdd->query("INSERT INTO avances(valeur,date,idroute) VALUES($avance,'$date','$idroute')")){		
						echo 1; 
					}
					else echo "erreur connexion";
				}
			else echo "erreur connexion";//informations incorrectes
			else
				echo "ce Nfr existe déja pour ce projet, veuillez en choisir un autre";
		}
		else echo "les informations n'ont pas pu etre envoyées. réessayez"; 
	}
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>