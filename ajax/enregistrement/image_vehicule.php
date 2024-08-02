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
	$path = "../../elements/carte_grise/";
	$path2 = "elements/carte_grise/";
	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
	header('Content-type: text/html; charset=ANSI');
	if(isset($_FILES["photoimg"]))
	{
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{

			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			if(strlen($name))
			{
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				{
				if($size<(1024*1024)) // Image size max 1 MB
				{
					$actual_image_name = time().$var.".".$ext;
					$tmp = $_FILES['photoimg']['tmp_name'];
					$actual=$path2.$actual_image_name;
					if(move_uploaded_file($tmp, $path.$actual_image_name))
					{
						$produits= $bdd->query("INSERT INTO vehicules (image_vehicule) VALUES('$actual')  ");
					}
					else
						echo "erreur image invalide";
				}
				else
					echo "l'image ne doit pas dépasser 1MB";
			}
			else
				echo "format invalide..";
		}
		else
			echo "veuillez selectionner une image..!";
		exit;
	} 
}else
echo "veuillez selectionner une image..!";
}
else
	echo "votre session a expirée. actualisez la page et reconnectez vous";

?>