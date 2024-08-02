<?php SESSION_start();
$facturation="facturation";
$cle_actuelle="routes";
$reference="php/";
include("php/config.php");
	// debut du test de la session
if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){

	if($_SESSION["connecter"]){

		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
		<head>	
			<title>Facturation</title>
			<base href="../../"></base>
			<?php include("php/header.php");?>
			<script>
			var Cle_actuelle='<?php echo $cle_actuelle; ?>',chemin_fichiers="<?php echo $chemin_fichiers;?>";
			<?php include("php/variables.php")  ?>;
			var idfacture= <?php echo $_GET["idfacture"];?>;
			var idprojet= <?php echo $_GET["idprojet"];?>;
			<?php $idprojet=$_GET["idprojet"];?>;
			var tableau_facturation=[];
			var tableau_reste=[];
			var tableau_reglage=[];
			var Test_facturation=0;
			var Montant=0;
			var prix=0;
			var Champs_omis=["id","idavance","idproduit","poids","ndocument","idprojet","projet"],
			Champs_omis_selection=["date","poids","observation","ndocument","idproduit"];
			<?php $projet=$bdd->get_var("SELECT projet FROM projets WHERE id=$idprojet"); 
					$facture_check=$bdd->get_var("SELECT id FROM factures WHERE idprojet=$idprojet");?>;
			var projet="<?php echo $projet;?>";
			var facture_check="<?php echo $facture_check?>;";
			<?php $idfacture=$_GET["idfacture"]; ?>
			var idfacture="<?php echo $idfacture; ?>"
			$(document).ready(function() {
				$("span.nom_projet").html("Projet: "+projet+" facture N°"+<?php echo $_GET["idfacture"]?>)
			})
        function charger_elements(sort,ordre,filtre,interval_date,page,fonction_supplementaire){
        	var param={cle_actuelle:Cle_actuelle,sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page,idprojet:idprojet,idfacture:idfacture};

			var etat_facture="etat_facture";
        	afficher_loader();
        	$.post("ajax/chargement/charger_elements.php",param,function(resultat){
        		cacher_loader()
        		var resultat = jQuery.parseJSON(resultat);
        		var elements="";
        		Test_facturation=1;
        		a_regler="";
        		Filtres_choisis="";
        		Filtres_choisis=extraire_filtres_choisis(Filtre);
        		Champs_a_afficher=arr_diff(Object.keys(Champs),Filtres_choisis)
        		Champs_a_afficher=arr_diff(Champs_a_afficher,Champs_omis)
        		elements="<thead>";
        		if(Test_facturation==1)
        			elements+="<th class='check_box'></th>"
        		for(j=0;j<Champs_a_afficher.length;j++){
        			if(Sort==Champs_a_afficher[j])
        			{	
        				if(Ordre=='DESC')
        					class_suplementaire="decroissant "
        				else
        					if(ordre=='ASC')
        						class_suplementaire="croissant "
        				}
        				else
        					class_suplementaire="";
        				elements+="<th champ='"+Champs_a_afficher[j]+"' class='"+class_suplementaire+"' title='<?php echo MESSAGE_ORDRE_TABLEAU;?>'>"+Champs[Champs_a_afficher[j]]+'</th>';
        			}
        			elements+="</thead>";
        			if(!(resultat<0)){
        				for(var i=0; i<resultat.length; i++) {
        					etat_fichier="";
        					etat_receptionne="";
        					fichier="javascript:";
        					cible_fichier="";
        					if(resultat[i].idfacture!=0){
        						etat_facture="etat_facture";
        						tableau_reglage.push(resultat[i].id)
        						a_regler="a_regler";
        					}
        					else{
        						a_regler="";etat_facture="";
        					}
        					if(resultat[i].receptionne==1)
        						etat_receptionne="etat_receptionne";
        					elements+="<tr id='"+resultat[i].id+"' class='"+etat_receptionne+" "+etat_facture+" "+a_regler+"'>";
        					console.log(a_regler)
        					if((Test_facturation==1)&&(resultat[i].idfacture!=0))
        					{
        						elements+="<td class='check_box'><input type='checkbox' checked class='checkbox' id='"+resultat[i].id+"' name='"+resultat[i].id+"' value='"+resultat[i].id+"'></td>";
        					} else
        					if(Test_facturation==1)
        						elements+="<td class='check_box'><input type='checkbox' class='checkbox' id='"+resultat[i].id+"' name='"+resultat[i].id+"' value='"+resultat[i].id+"'></td>";
        					for(j=0;j<Champs_a_afficher.length;j++){
        						valeur=eval("resultat[i]."+Champs_a_afficher[j]);
        						if(Champs_prix.indexOf(Champs_a_afficher[j])>-1)
        							valeur=f(valeur)
        						elements+="<td class='"+Champs_a_afficher[j]+"' >"+valeur+'</td>';
        					}
        					elements+="<td class='colonne_boutons'><div style='position:absolute;width:50px;margin-top:-10px'><a href='javascript:' class='icone_receptionne'title='<?php echo MESSAGE_RECEPTIONNE;?>'></a><a href='javascript:' class='icone_facture'title='<?php echo MESSAGE_RECEPTIONNE;?>'></a></div></td></tr>";
        				}
        			}
        			else
        				elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
        			var $elements=$(elements)
        			$($elements).find("th").one("click",function(){
        				fleche($(this))
        			})
        			$($elements).find(".plus").click(function(){
        				id=$(this).parent().parent().attr("id");
        				recharger_avances(id)
        				ouvrir_avances(this)
        			})
        			$($elements).find(".modifier").click(function(){
        				id=$(this).parent().parent().attr("id");
        				charger_anciennes_informations(id);
        				ouvrir_modification(this);
        			})
        			$($elements).find(".imprimante").click(function(){
        				voir_feuille(this)
        			})
        			$("#tableau_elements").html($elements);
        			$('.conteneur.elements').show();
        			if(fonction_supplementaire)
        				fonction_supplementaire()
        			charger_totaux();
        						}).error(function(){
        			alert("erreur serveur")
        			cacher_loader()
        		})
        		function charger_totaux(){
        			var param={cle_actuelle:Cle_actuelle,sort:Sort,filtre:Filtre,interval_date:Interval_date,idprojet:idprojet,idfacture:idfacture};
        			var restant=0
        			$.post("ajax/chargement/charger_totaux.php",param,function(resultat){
        				var resultat = jQuery.parseJSON(resultat);
        				var elements="";
        				var elements_facturation="";
        				if(resultat.total_avances!=-1){
        					prix=(parseFloat(resultat.total_prix));
        					elements+="<tr>";
        					elements_facturation+="<tr>";
        							if(Test_facturation==1){
        								if(tableau_reglage.length>0) 
        									var cliquable="" 
        								else cliquable="non_cliquable";
        								elements+="<td id='boutons_actions'><button type='button' class='bouton_noir' id='bouton_annuler'>Annuler</button><button id='confirmation' class='bouton_noir "+cliquable+"' style='maring-left:5px'>confirmer</button></td>";
        								elements_facturation+="<td id='prix'>"+f(prix)+"</td><td id='montant_reglage'>"+f(Montant)+"</td><td id='restant'>"+f(f_(prix)-f_(Montant))+"</td><td id='boutons_actions'><button type='button' class='bouton_noir' id='bouton_annuler'>Annuler</button><button id='confirmation' class='bouton_noir "+cliquable+"' style='maring-left:5px'>confirmer</button></td>";
        							}
        							elements+="</tr>";
        							elements_facturation+="</tr>";
        						}
        						else
        							elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
        						$elements=$(elements)
        						$elements_facturation=$(elements_facturation)
        						$($elements).find("#bouton_regler").click(regler_tout)
        						$($elements_facturation).find("#bouton_regler").click(regler_tout)
        						$("#tableau_reglage tbody").html($elements_facturation);
        						cacher_loader()
        						function regler_tout(){
        							$("#cadre_facturation").css({"display": "table","visibility": "visible"});
        							$("#tout_regler").click(function(){
        								if (confirm("Etes vous sûr de vouloir facturer le total de "+$("#restant").text()+" à toute la liste courante?")) {
        									var param={cle_actuelle:Cle_actuelle,sort:Sort,filtre:Filtre,interval_date:Interval_date};
        									$.post("ajax/enregistrement/regler_tout.php",param,function(resultat){
        										var resultat = jQuery.parseJSON(resultat);
        										if(resultat==1)
        											filtrer();
        										else
        											alert(resultat)
        									}).error(function(){
        										alert("erreur serveur")
        										cacher_loader()
        									})
        								}
        							})
        						}

        					}).error(function(){
        						alert("erreur serveur")
        						cacher_loader()

        					})
        				}
        				$("#tableau_elements:not(.mode_facturation").toggleClass("mode_facturation");
        			}
        			</script>

        		</head> 
        		<body>
        			<div id="conteneur">
        				<?php $facturation=true; include("php/entete.php"); ?>
        				<div id="formulaire_ajout" >
        					<?php require_once('ajouter_route.php'); ?>
        				</div>
        				<div id="space">
        				</div>
        				<div id="entete_recherche"></div>
        				<div class="conteneur elements">			
        					<?php
				//la boucle suivante prepare les variables et les securise
        					foreach($_POST as $key=>$value)
        					{
        						$$key=securiser($value);
        					}
        					?>
        					<form style="position: relative;" onSubmit='return false'>
        						<center>
        							<table id="tableau_elements" >
        							</table>
        							<table id="tableau_reglage">
        								<thead>
        									<th>Prix</th>
        									<th width=250>Sélection</th>
        									<th>Restant</th>
        									<th>Actions</th>
        								</thead>
        								<tbody></tbody>	
        							</table>
        							<?php include("php/pagination.php") ; ?>
        						</center>
        					</form>
        					<?php include("php/fenetre_avances.php") ; ?>
        					<?php include("php/fenetre_modification.php") ; ?>
        				</div>
        			</div>
        			<?php require_once("notification/notification.php"); ?>
        		</body>
        		</html>
        		<?php 
        	}
    // redirection de des non cnecter ver la page login
        	else{
        		header("location:index.php");
        	}
        }else{
        	header("location:index.php");
        }
        ?>
