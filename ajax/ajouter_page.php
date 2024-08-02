<?php
$reference="../php/";
include("../php/config.php");
if(isset($_POST["titre"]))
{
	$titre=$_POST["titre"];
	$url=$_POST["url"];
	$pseudo=$_SESSION["pseudo"];
	$idu=$bdd->get_var("SELECT id FROM utilisateurs WHERE pseudo='$pseudo'");
	if($bdd->query("INSERT INTO pages(titre,url,idutilisateur) VALUES('$titre','$url',$idu)"))
	{	
		$idp=$bdd->insert_id;
		if($bdd->query("UPDATE utilisateurs SET idpage=$idp WHERE pseudo='$pseudo'"));
			echo 1; // succès
		}
		else echo -3; //informations incorrectes
	}
	else echo -1; //titre vide
	?>