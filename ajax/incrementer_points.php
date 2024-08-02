<?php
	
	$reference="../php/";
	include("../php/config.php");
	if(isset($_POST["points"]))
	{
		$points=$_POST['points']+1;
		$pseudo=$_SESSION["pseudo"];
		$idp=$_POST["idp"];
		$idu=$bdd->get_var("SELECT id FROM utilisateurs WHERE pseudo='$pseudo'");
		$bdd->query("UPDATE utilisateurs SET points=$points WHERE pseudo='$pseudo'");
		$points_proprietaire=$bdd->get_var("SELECT points FROM utilisateurs WHERE idpage=$idp");
		$bdd->query("INSERT INTO visites(idpage,idutilisateur) VALUES($idp,$idu)");
		$bdd->query("UPDATE pages SET visites=visites+1 WHERE id=$idp ");
	}
	else
		echo -1; // variable points inexistante
?>