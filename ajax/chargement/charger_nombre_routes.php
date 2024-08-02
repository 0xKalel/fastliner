<?php 
	$reference="../../php/";
	include("../../php/config.php");
	if(isset($_POST["id"])){
		$id=$_POST["id"];
		$nombre_routes=$bdd->get_var("SELECT COUNT(*) FROM routes WHERE idprojet=$id");
		if($nombre_routes==0)
			$nombre_routes=-2;
		echo $nombre_routes;
	}
	else
		echo -1;
?>
