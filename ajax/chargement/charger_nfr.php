<?php	
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
	{
		$$key=securiser($value);
	}
	$donnees_nfrs=$bdd->get_var("SELECT MAX(nfr) FROM routes WHERE idprojet=$valeur ");
	$nfr=$donnees_nfrs;
	if($nfr==null)
		$nfr=0;
	echo json_encode($nfr);
?>
