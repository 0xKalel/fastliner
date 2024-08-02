<?php

$reference="../../php/";
include("../../php/config.php");
foreach($_POST as $key=>$value)
{
	$$key=securiser($value);
}
if(isset($_POST["nom"]))
{
	if(isset($date))
	{			
		$date_string= DateTime::createFromFormat('d/m/Y', $date);
		$date = $date_string->format('Y-m-d');
		if($bdd->query("UPDATE routes SET nom='$nom',date='$date',matricule='$matricule',destination='$destination',nfr='$nfr',poids='$poids',ndocument='$n_document',observation='$observation',idproduit='$idproduit',depart='$depart',projet='$projet',prix='$prix' WHERE id='$id'"))
		{		
			echo 0; //informations correctes
		}
		else echo -3;//informations incorrectes
	}
	else echo -2;
}
else echo -1; //

?>