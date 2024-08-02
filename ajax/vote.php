<?php
	
	$reference="../php/";
	include("../php/config.php");
	if(isset($_POST["vote"]))
	{
		$idp=$_POST["idp"];
		$vote=$_POST["vote"];
		$pseudo=$_SESSION["pseudo"];
		$compteur=0;
		$moyenne=0;
		$idu=$bdd->get_var("SELECT id FROM utilisateurs WHERE pseudo='$pseudo' ");
		if($bdd->query("INSERT INTO votes(idutilisateur,idpage,vote) VALUES($idu,$idp,$vote) "))
		{
			$votes=$bdd->get_results("SELECT vote FROM votes WHERE idpage=$idp ");
			if(count($votes))
			{
				foreach($votes as $v)
				{
					$compteur++;
					$moyenne+=$v->vote;
				}
				if($compteur!=0)
					$moyenne/=$compteur;
			}
			else
			{
				$moyenne=0;
			}
			echo round($moyenne,1); //succès
		}
	}
	else echo -1; //aucun vote
?>