<?php session_start();
$cle_actuelle="creances";
$reference="php/";
include("php/config.php");
if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){
	if($_SESSION["connecter"]){
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
		<head>	
			<title>Liste des creances</title>
			<?php include("php/header.php");?>
			<script>
			var Cle_actuelle='<?php echo $cle_actuelle; ?>';
			var tableau_reglage=[];
			var tableau_reste=[];
			var Test_reglage=0;
			var Montant=0;
			<?php include("php/variables.php") ?>;
			var Champs_omis=["id","idavance"];Champs_omis_selection=["date","poids","observation","ndocument","idproduit"];
			function ouvrir_avances(element){
				$("#cadre_avances").fadeIn(400);
				$("#cadre_avances form input[name='id']").val($(element).parent().parent().attr("id"));
				$("#cadre_avances .valeur_nfr").html($(element).parent().parent().attr("id"));
			}
			function charger_elements(sort,ordre,filtre,interval_date,page,fonction_supplementaire){
				afficher_loader()
				var param={cle_actuelle:Cle_actuelle,sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
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
							elements+="<th champ='"+Champs_a_afficher[j]+"' class='"+class_suplementaire+"'  title='<?php echo MESSAGE_ORDRE_TABLEAU;?>'>"+Champs[Champs_a_afficher[j]]+'</th>';
						}
						elements+="</thead>";
						if(resultat.length>0)
							for(var i=0; i<resultat.length; i++) {
								elements+="<tr  id='"+resultat[i].id+"'>";
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
							}
							else
								elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
							$elements=$(elements)
							var $elements=$(elements)
							$($elements).find("th").one("click",function(){
								fleche($(this))
							})
							$("#tableau_elements").html($elements);
							$('.conteneur.elements').show();
							if(fonction_supplementaire)
								fonction_supplementaire()
							cacher_loader();
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
							if(resultat.total_avances!=-1){
								var restant=(parseFloat(resultat.total_prix)-parseFloat(resultat.total_avances));
								elements+="<tr>";
								elements+="<td>"+f(resultat.total_prix)+'</td>';
								elements+="<td>"+f(resultat.total_avances)+'</td>';
								if((restant<=0)&&(resultat.total_avances!=0)&&(resultat.total_prix!=0))
									elements+="<td>réglé</td>";
								else
									elements+="<td id='restant'>"+f(restant)+"</td>";
								if(restant<=0)
									elements+="<td></td>";
								else
									elements+="<td><button type='button' class='bouton_noir' id='bouton_regler'>régler</button><button type='button' class='bouton_noir' id='bouton_annuler' style='display:none'>annuler</button></td>";
								elements+="</tr>";
							}
							else
								elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
							$elements=$(elements)
							$("#tableau_totaux tbody").html($elements);
							$($elements).find("#bouton_regler").click(regler_tout)
							cacher_loader()
							if($(".mode_reglage").length>0){
								$("#bouton_regler").hide();
								$("#bouton_annuler").show();
							}
							function regler_tout(){
								$("#cadre_reglage").css({"display": "table","visibility": "visible"});
								$("#bouton_regler").hide();
								$("#bouton_annuler").show();
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
						})
}

</script>
</head> 
<body>

	<div id="conteneur" class="page_creances">
		<?php $cle_actuelle="creances"; 
		include("php/entete.php"); ?>
		<div id="entete_recherche" ></div>
		<div id="space">
		</div>	
		<div class="conteneur elements">
			<div id="cadre_reglage" class="fond_noir">
				<div class="conteneur_lightbox">
					<form>
						<a class="bouton_fermer" href="javascript:"></a>
						<center><p>Quel type de reglage voulez-vous utiliser ?</p></center>
						<center>
							<div id="tout_regler" class="bouton_orange"style="vertical-align:top;width:80px;display:inline-block;text-align:center">tout regler</div>
							<div id="check_box" class="bouton_orange" style="vertical-align:top;width:80px;display:inline-block;text-align:center">checkbox</div>
						</center>
					</form>
				</div>
			</div>
			<div class="conteneur projets">	
				<ul id="type_creance">
					<li id="entreprise" class="active" ><a href="#">Entreprise</a></li>
					<li id="personnel"><a href="creances_personnel.php">Personnel</a></li>
				</ul>		
				<form>
					<table id="tableau_elements">			
					</table>
				</form>
				<form>
					<table id="tableau_totaux">
						<thead>
							<th>prix</th>
							<th>avances</th>
							<th>créances</th>
							<th>actions</th>
						</thead>
						<tbody></tbody>	
					</table>
					<?php include("php/pagination.php") ?>
				</form>
			</div>
		</div>
	</div>
	<?php include("notification/notification.php"); ?>
</body>
<script>
</script>
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