<?php
	
	$reference="../php/";
	include("../php/config.php");
	if(isset($_POST["pseudo"]))
	{
		if(isset($_POST["pseudo"]))
		{
			$pseudo=$_POST["pseudo"];
			$mdp=$_POST["mdp"];
			$pseudo=str_replace(" ","",$pseudo);
			$mdp=str_replace(" ","",$mdp);
			if($pseudo!="")
			{
				if($mdp!="")
				{
					$req=$bdd->get_var("SELECT COUNT(*) FROM utilisateurs WHERE pseudo='$pseudo' AND mdp='$mdp'");
					if($req==1)
					{		
						$_SESSION["pseudo"]=$pseudo;
						echo 1; //informations correctes
					}
					else echo -3; //informations incorrectes
				}
				else echo -2;
			}
			else echo -1;
		}
		else echo -2; //mot de passe vide
	}
	else echo -1; //pseudo vide
?>