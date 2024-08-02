<?php 
	$reference="php/";
	include("php/config.php");
	$avances=("SELECT SUM(alucard.uu) as total_prix,SUM(alucard.vv) as total_avances FROM(
									SELECT ultimate.id,SUM(ultimate.prix) as uu,SUM(ultimate.valeur) as vv FROM(
										SELECT e.id,e.prix,e.idprojet,e.valeur FROM(
											SELECT cible.id,cible.prix,cible.idprojet,a.valeur=4 AS valeur FROM avances AS a
												INNER JOIN routes cible ON a.idroute=cible.id 
												INNER JOIN projets p ON p.id=cible.idprojet AND cible.nom = 'okb'  
												WHERE a.date BETWEEN '2014-06-01' AND '2014-07-15'  
												GROUP BY a.id
										) AS e
										UNION 
											SELECT cible.id,cible.prix=4,cible.idprojet,SUM(a.valeur) FROM avances as a
												INNER JOIN routes cible ON a.idroute=cible.id 
												INNER JOIN projets p ON p.id=cible.idprojet AND cible.nom = 'okb'  
												WHERE a.date BETWEEN '2014-05-01' AND '2014-05-15'  
												GROUP BY a.id 
									) AS ultimate
									GROUP BY ultimate.id
									HAVING SUM(ultimate.prix)>SUM(ultimate.valeur) 
				) 
	AS alucard");
	$donnees_chargement=$bdd->get_results($avances);
	
	var_dump($donnees_chargement);