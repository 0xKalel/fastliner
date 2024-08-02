var Champs={<?php 
foreach($liste_champs[$cle_actuelle] as $cle=>$valeur){
	echo "'$cle':'$valeur',";
}?>}
var Champs_prix=[<?php 
foreach($champs_prix as $cle){
	echo "'$cle',";
}
?>]

var Champs_complets=[<?php 
	foreach($liste_champs[$cle_actuelle] as $cle=>$valeur){
		echo "'$cle',";
	}?>]
var K=0,Champs_omis=["id"],Champs_a_afficher,Filtres_choisis,Filtres_caches=Array(),Champ="",champs="",Page=1,Lettre="",Filtre=[];
Limite=<?php echo $limite; ?>;
Sort="id",Ordre="DESC",
Interval_date={min:"0",max:"0"};var ordre_prec;i=0,Prix_actuel=0,Suffixe='<?php echo $parametres["suffixe"];?>';
