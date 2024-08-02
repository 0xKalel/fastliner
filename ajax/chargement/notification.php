<?php	
	$reference="../../php/";
	include("../../php/config.php");
	$datelocal=date("Y-m-d");
	$debut=date("Y-m-d");

	$secondes=strtotime($datelocal);
	$secondes-=$delai_assurance*24*60*60;
	$fin_assurance = date('Y-m-d', $secondes);
	
	$secondes=strtotime($datelocal);
	$secondes-=$delai_scanner*24*60*60;
	$fin_scanner = date('Y-m-d', $secondes);

	$secondes=strtotime($datelocal);
	$secondes-=$delai_assurance_chauffeur*24*60*60;
	$fin_assurance_chauffeur = date('Y-m-d', $secondes);

	$secondes=strtotime($datelocal);
	$secondes-=$delai_vignette*24*60*60;
	$fin_vignette = date('Y-m-d', $secondes);

	$secondes=strtotime($datelocal);
	$secondes-=$delai_controle_technique*24*60*60;
	$fin_controle_technique= date('Y-m-d', $secondes);

	$secondes=strtotime($datelocal);
	$secondes-=$delai_paye_chauffeur*24*60*60;
	$fin_paye_chauffeur = date('Y-m-d', $secondes);

	$tabs["date_assurance"]=0;
	$tabs["date_scanner"]=0;
	$tabs["controle_technique"]=0;
	$tabs["date_vignette"]=0;
	$tabs["date_assurance_chauffeur"]=0;
	$tabs["date_chauffeur"]=0;
	$i=0;
	$donnees_notifications=$bdd->get_results("SELECT 
		(SELECT COUNT(id) FROM vehicules WHERE date_assurance <= '$fin_assurance') date_assurance,
		(SELECT COUNT(id) FROM vehicules WHERE date_scanner <= '$fin_scanner') date_scanner,
		(SELECT COUNT(id) FROM vehicules WHERE controle_technique <= '$fin_controle_technique') controle_technique,
		(SELECT COUNT(id) FROM vehicules WHERE date_vignette <= '$fin_vignette') date_vignette,
		(SELECT COUNT(id) FROM vehicules WHERE date_assurance_chauffeur <= '$fin_assurance_chauffeur') date_assurance_chauffeur,
		(SELECT COUNT(id) FROM vehicules WHERE date_chauffeur  <= '$fin_paye_chauffeur') date_chauffeur"
		);
	// $notifications=array();
	// if(count($donnees_notification))
	// 	foreach($donnees_notification as $r)
	// 	{ $i++;
	// 		$notification=array();
	// 		foreach($r as $cle=>$valeur)
	// 		{   $$cle=securiser($valeur);
	// 		}
	// 		if($date_assurance <= $fin){
	// 			$notification["date_assurance".$i]=securiser($date_assurance);
	// 			array_push($notifications,$notification);
			
	// 			$tabs["date_assurance"]+=1;
	// 		}
	// 		if($date_scanner<=$fin){
	// 			$notification["date_scanner".$i]=securiser($date_scanner);
	// 			array_push($notifications,$notification);
			
	// 			$tabs["date_scanner"]+=1;
	// 		}
	// 		if( $controle_technique<=$finc){
	// 			$notification["controle_technique".$i]=securiser($controle_technique);
	// 			array_push($notifications,$notification);
				
	// 			$tabs["controle_technique"]+=1;
	// 		}
	// 		if( $date_vignette<=$fin){
	// 			$notification["date_vignette".$i]=securiser($date_vignette);
	// 			array_push($notifications,$notification);
				
	// 			$tabs["date_vignette"]+=1;
	// 		}
	// 		if( $date_assurance_chauffeur<=$finc){
	// 			$notification["date_assurance_chauffeur".$i]=securiser($date_assurance_chauffeur);
	// 			array_push($notifications,$notification);
				
	// 			$tabs["date_assurance_chauffeur"]+=1;
	// 		}
	// 		if( $date_chauffeur<=$find){
	// 			$notification["date_chauffeur".$i]=securiser($date_chauffeur);
	// 			array_push($notifications,$notification);
			
	// 			$tabs["date_chauffeur"]+=1;
	// 		}
			
	// 		}
	// 		array_push($notifications,$tabs);
			echo json_encode($donnees_notifications);
	 	?>