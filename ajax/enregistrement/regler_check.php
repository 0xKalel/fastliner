<?php
session_start();

$reference="../../php/";
include("../../php/config.php");
foreach($_POST as $key=>$value)
	$$key=$value;
$aujourdhui=date("Y-m-d");
if(isset($tableau_reglage))
{
	if(($Cle_actuelle=="etats")||($Cle_actuelle=="dettes"))
	{
		for($i=0;$i<count($tableau_reglage);$i++)
		{
			$r=$tableau_reste[$i];
			$t=$tableau_reglage[$i];
			$bdd->query("INSERT INTO avances(valeur,idroute,date) VALUES($r,$t,$aujourdhui) ");
		}
		echo 1;
	}
	else
		if($Cle_actuelle=="creances")
		{
			for($i=0;$i<count($tableau_reglage);$i++)
			{
				$r=$tableau_reste[$i];
				$t=$tableau_reglage[$i];
				$bdd->query("INSERT INTO avances_projets(valeur,idprojet,date) VALUES($r,$t,$aujourdhui) ");
			}
			echo 1;
		}
		else
			if($Cle_actuelle=="creances_personnel")
			{
				for($i=0;$i<count($tableau_reglage);$i++)
				{
					$r=$tableau_reste[$i];
					$t=$tableau_reglage[$i];
					$bdd->query("INSERT INTO avances_creances(valeur,id_creance,date) VALUES($r,$t,$aujourdhui) ");
				}
				echo 1;
			}
			else
				if($Cle_actuelle=="dettes_personnel")
				{
					for($i=0;$i<count($tableau_reglage);$i++)
					{
						$r=$tableau_reste[$i];
						$t=$tableau_reglage[$i];
						$bdd->query("INSERT INTO avances_debits(valeur,id_debit,date) VALUES($r,$t,$aujourdhui) ");
					}
					echo 1;
				}
			else
				if($Cle_actuelle=="routes")
				{
					$bdd->query("UPDATE routes SET idfacture=0");
					for($i=0;$i<count($tableau_reglage);$i++)
					{	
						$r=$tableau_reglage[$i];
						$bdd->query("UPDATE routes SET idfacture=$idfacture WHERE id=$r");
					}
				}
	}
else echo -1;