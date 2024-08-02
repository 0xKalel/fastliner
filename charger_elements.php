<?php 
	$reference="php/";
	include("php/config.php");

$parametres=array();
	$parametre=$bdd->get_results("SELECT * FROM parametres");
	foreach($parametre as $p)
					{
						$parametres[$p->etiquette]=$p->valeur;
				 	}
				 	var_dump($parametres);

	