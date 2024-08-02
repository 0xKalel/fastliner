<?php
$reference="../../php/";
include("../../php/config.php");
	//la boucle suivante prepare les variables et les securise
foreach($_POST as $key=>$value)
{
	$$key=$value;
}
$donnees_avances=$bdd->get_results("SELECT * FROM routes WHERE id='$id' ORDER BY date ASC");
if(count($donnees_avances))
	echo json_encode($donnees_avances);
else
	echo 1;
?>
