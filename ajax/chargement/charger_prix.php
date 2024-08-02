<?php	
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	$donnees_prix_1=$bdd->get_var("SELECT prix FROM itineraires WHERE id=$valeur");
	$prix=$donnees_prix_1;
	echo json_encode($prix);
?>
