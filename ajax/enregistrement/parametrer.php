<?php
$reference="../../php/";
include("../../php/config.php");
foreach($_POST as $key=>$value){
	$test=$bdd->query("UPDATE parametres SET valeur='$value' WHERE etiquette='$key'");
}
echo 1;
?>
