<?php
	$reference="../../php/";
	include("../../php/config.php");
	$nbr_routes="(SELECT COUNT(DISTINCT routes.id) FROM routes WHERE routes.idprojet=projets.id)";
	$creances=$bdd->get_results("SELECT SUM(p.prix)  ");
	echo json_encode($creances);
?>
