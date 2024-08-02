<?php	
	$reference="../../php/";
	include("../../php/config.php");
	foreach($_POST as $key=>$value)
		$$key=$value;
	/*$donnees_factures=$bdd->get_results("SELECT SUM(tt.prix),COUNT(tt.ids) 
										FROM(SELECT x.nom,x.date,SUM(p.prix) AS prix,COUNT(cible.id) AS ids
											FROM(SELECT f.id,f.nom,f.date,idprojet 
												FROM factures AS f ) AS x,routes AS cible,projets AS p 
												WHERE x.id=cible.id AND p.id=$idprojet AND x.idprojet=$idprojet GROUP BY cible.id,p.id) AS tt ");
*/	
$count="(SELECT COUNT(cible.id) FROM routes AS cible WHERE cible.idfacture=f.id ) AS nombre_frs";
$sum="(SELECT SUM(it.prix) FROM itineraires AS it WHERE cible.iditineraire=it.id AND cible.idfacture=f.id )";
$donnees_factures=$bdd->get_results("SELECT f.id,f.nom,f.date,$count,SUM($sum)AS total_prix
									 FROM factures AS f
									 INNER JOIN projets p ON p.id=$idprojet
									 INNER JOIN routes cible ON cible.idprojet=p.id
									 INNER JOIN itineraires it ON cible.iditineraire=it.id
									 WHERE f.idprojet=$idprojet
									 GROUP BY f.id 
									 ");
foreach($donnees_factures AS $d){
if (is_null($d->total_prix)){$d->total_prix=0;}
	if (is_null($d->nombre_frs)){$d->nombre_frs=0;}
}
echo json_encode($donnees_factures);
?>
