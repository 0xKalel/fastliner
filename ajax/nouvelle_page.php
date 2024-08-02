<?php
	
	$reference="../php/";
	include("../php/config.php");
		$pseudo=$_SESSION['pseudo'];
		$idu=$bdd->get_var("SELECT id FROM utilisateurs WHERE pseudo='$pseudo'");
		
		if($nouvelle_page=$bdd->get_var("SELECT url FROM pages WHERE id NOT IN(SELECT idpage FROM visites WHERE idutilisateur=$idu) AND idutilisateur<>$idu ORDER BY RAND()"))
			echo $nouvelle_page;
		else
			echo -1; // plus aucune page n'est disponible
?>