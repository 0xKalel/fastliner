<?php session_start();

$cle_actuelle="etats";
$reference="php/";
include("php/config.php");
if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){
	if($_SESSION["connecter"]){
		if(isset($_GET['projet']))
			$_GET['projet']=str_replace("__"," ",$_GET['projet'])
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
		<head>	
			<title>Liste d'états</title>
			<?php 
			if (isset($_GET["projet"])) {
				?>
				<base href="../" />
				<?php 
			}
			include("php/header.php");?>
			<script>
			var Cle_actuelle='etats';
			<?php include("php/variables.php") ?>;
			Champs_omis=[];Champs_omis_selection=["date","poids","observation","ndocument","idproduit"];
			var tableau_reglage=[];
			var tableau_reste=[];
			var Test_reglage=0;
			var Montant=0;
			var reglage=1;
			function charger_elements(sort,ordre,filtre,interval_date,page,fonction_supplementaire){
				if($(".mode_reglage").length>0)
					reglage=0
				else
					reglage=1;
				var param={cle_actuelle:Cle_actuelle,sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page,reglage:reglage};
				afficher_loader()
				$.post("ajax/chargement/charger_elements.php",param,function(resultat){
					var resultat = jQuery.parseJSON(resultat);
					var elements="";
					Filtres_choisis="";
					Filtres_choisis=extraire_filtres_choisis(Filtre);
					Champs_a_afficher=arr_diff(Object.keys(Champs),Filtres_choisis)
					Champs_a_afficher=arr_diff(Champs_a_afficher,Champs_omis)
					elements="<thead>";
					if(fonction_supplementaire)
						fonction_supplementaire()
					if(Test_reglage==1)
					elements+="<th class='check_box'></th>"
					else
						tableau_reglage=[];
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
							elements+="<th champ='"+Champs_a_afficher[j]+"' class='"+class_suplementaire+"'>"+Champs[Champs_a_afficher[j]]+'</th>';
						}
						elements+="<th class='actions'>actions</th>"
						elements+="<th class='colonne_boutons'></th></thead>";
						if((resultat!=-1)&&(resultat!=-2))
							for(var i=0; i<resultat.length; i++) {
								if(resultat[i].reste<=0){
									infobulle="<?php echo MESSAGE_ETAT_REGLE;?>"
									etat="etat_regle";
								}
								else
									if(resultat[i].avances>0){

										infobulle="<?php echo MESSAGE_ETAT_NON_REGLE;?>"
										etat="etat_non_regle";
									}
									else{
										infobulle="<?php echo MESSAGE_ETAT_SANS_AVANCE;?>"
										etat="etat_aucune_avance";
										
									}
									elements+="<tr   id='"+resultat[i].id+"' class='tr_etat "+etat+"'>";
									if(fonction_supplementaire)
										fonction_supplementaire()
									if(Test_reglage==1)
									elements+="<td class='check_box'><input type='checkbox' class='checkbox' id='"+resultat[i].id+"' name='"+resultat[i].id+"' value='"+resultat[i].id+"'></td>";
									for(j=0;j<Champs_a_afficher.length;j++){
										valeur=eval("resultat[i]."+Champs_a_afficher[j]);
										if(Champs_prix.indexOf(Champs_a_afficher[j])>-1)
											valeur=f(valeur)
										elements+="<td class='"+Champs_a_afficher[j]+"'>"+valeur+'</td>';
									}
									elements+="<td class='actions'><a href='javascript:' class='plus' title='<?php echo MESSAGE_AJOUTER_AVANCE ;?>'></a><a href='javascript:' class='liste'></a></td>";
									elements+="<td class='colonne_boutons'><div><a href='javascript:' class='icone_etat' title='"+infobulle+"'></a></div></td></tr>";
									}
								else
									elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
								var $elements=$(elements)
								$($elements).find(".liste").click(function(){
									voir_feuille(this)
								})
								$($elements).find(".plus").click(function(){
									id=$(this).parent().parent().attr("id");
									recharger_avances(id)
									ouvrir_avances(this)
								})
								$($elements).find("th").one("click",function(){
									fleche($(this))
								})
								$("#tableau_elements").html($elements);
								$('.conteneur.elements').show();
								if(fonction_supplementaire)
									fonction_supplementaire()
								charger_totaux();
								if($(".mode_reglage").length>0){
									for(var i=0;i<tableau_reglage.length;i++)
									{
										$("#tableau_elements #"+tableau_reglage[i]).toggleClass("a_regler").find('.checkbox').attr("checked","checked")
									}
								}
							}).error(function(){
								alert("erreur serveur")
								cacher_loader()
							})
						}
						function charger_totaux(){
							var param={cle_actuelle:Cle_actuelle,sort:Sort,filtre:Filtre,interval_date:Interval_date};
							$.post("ajax/chargement/charger_totaux.php",param,function(resultat){
								var resultat = jQuery.parseJSON(resultat);
								var elements="";
								var elements_reglage="";
								if(resultat.total_avances!=-1){
									var restant=(parseFloat(resultat.total_prix)-parseFloat(resultat.total_avances));
									elements+="<tr>";
									elements_reglage+="<tr>";
									elements+="<td>"+f(resultat.total_prix)+'</td>';
									elements+="<td>"+f(resultat.total_avances)+'</td>';
									if((restant<=0)&&(resultat.total_avances!=0)&&(resultat.total_prix!=0))
										elements+="<td>réglé</td>";
									else
										elements+="<td id='restant'>"+f(restant)+"</td>";
									console.log("ee")
									if(restant<=0)
										elements+="<td></td>";
									else
										if(Test_reglage==0)
										{
											console.log("reglage=0");
											elements+="<td id='boutons_actions'><button type='button' class='bouton_noir' id='bouton_regler'>Régler</button></td>";
											elements_reglage+="<td id='montant_reglage'>veuillez selectionner les feuilles de routes</td><td></td>";
										}
										else
											if(Test_reglage==1){
												console.log("mreglage=1")
											if(tableau_reglage.length>0) 
												var cliquable="" 
											else cliquable="non_cliquable";
											elements+="<td id='boutons_actions'><button type='button' class='bouton_noir' id='bouton_annuler'>Annuler</button><button id='confirmation' class='bouton_noir "+cliquable+"' style='maring-left:5px'>confirmer</button></td>";
											elements_reglage+="<td id='montant_reglage'>"+f(Montant)+"</td><td id='boutons_actions'><button type='button' class='bouton_noir' id='bouton_annuler'>Annuler</button><button id='confirmation' class='bouton_noir "+cliquable+"' style='maring-left:5px'>confirmer</button></td>";
										}
										elements+="</tr>";
										elements_reglage+="</tr>";
										console.log(elements_reglage)
								}
								else
									elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
								$elements=$(elements)
								$elements_reglage=$(elements_reglage)
								$($elements).find("#bouton_regler").click(regler_tout)
								$($elements_reglage).find("#bouton_regler").click(regler_tout)
								$("#tableau_totaux tbody").html($elements);
								$("#tableau_reglage tbody").html($elements_reglage);
								cacher_loader()
								function regler_tout(){
									$("#cadre_reglage").css({"display": "table","visibility": "visible"});
									$("#tout_regler").click(function(){
										if (confirm("Etes vous sûr de vouloir distribuer le total de "+$("#restant").text()+" à toute la liste courante?")) {
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
								if(Test_reglage==1)
								{
									$("#tableau_reglage").show();
									$("#tableau_totaux").hide()
								}
								else
								{
									$("#tableau_reglage").hide();
									$("#tableau_totaux").show();
								}

							}).error(function(){
								alert("erreur serveur")
								cacher_loader()

							})
						}
						<?php 
						if (isset($_GET["projet"])) {
							?>
							$(document).ready(function(){
								$("#cadre_reglage .bouton_fermer").click(function(){
									charger_elements(Sort,Ordre,Filtre,Interval_date,Page)
									$("#cadre_reglage").fadeOut(200)
								})
								var projet="<?php echo $_GET["projet"];?>";
								$(".filtre").val(projet);
								filtrer();
								$("tableau_elements.mode_reglage tr").on("click",function(){
								})

							})
							<?php
						}
						?>

						</script>
					</head> 
					<body>
						<div id="conteneur">
							<?php $cle_actuelle="etats"; 
							include("php/entete.php"); ?>
							<div id="space"></div>
							<div id="entete_recherche" ></div>
							<div class="conteneur elements">
								<div id="cadre_reglage" class="fond_noir">
									<div class="conteneur_lightbox">
										<form>
											<a class="bouton_fermer" href="javascript:"></a>
											<center><p>Quel type de reglage voulez-vous utiliser ?</p></center>
											<center>
												<div id="tout_regler" class="bouton_orange"style="vertical-align:top;width:80px;display:inline-block;text-align:center">tout regler</div>
												<div id="check_box" class="bouton_orange" style="vertical-align:top;width:80px;display:inline-block;text-align:center">selection</div>
											</center>
										</form>
									</div>
								</div>
								<div id="entete_tableau"></div>
								<form><table id="tableau_elements"></table></form>
								<script>
								</script>
								<table id="tableau_totaux">
									<thead>
										<th>Prix</th>
										<th>Avances</th>
										<th>Restant</th>
										<th>Actions</th>
									</thead>
									<tbody></tbody>	
								</table>
								<table id="tableau_reglage" style="display:none">
									<thead>
										<th>Montant</th>
										<th>Actions</th>
									</thead>
									<tbody></tbody>	
								</table>
								<?php include("php/pagination.php") ?>
								<?php include("php/fenetre_avances.php") ; ?>
							</div>
						</div>
						<?php include("notification/notification.php");  ?>
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