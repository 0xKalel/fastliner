<?php session_start();
$cle_actuelle="projets";
$reference="php/";
include("php/config.php");
if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){

	if($_SESSION["connecter"]){
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
		<head>	
			<title>Liste de projets</title>
			<?php include("php/header.php");?>
			<script>
			var Cle_actuelle='<?php echo $cle_actuelle; ?>';
			<?php include("php/variables.php") ?>;
			var Champs_omis=["id","idavance"];Champs_omis_selection=["date","poids","observation","ndocument","idproduit"];

			function ouvrir_modification(element){
				$("#cadre_modification").fadeIn(400);
				$("#formulaire:visible").slideToggle(500)
				$("#cadre_modification form input[name='id']").val($(element).parent().parent().attr("id"));
				$("#cadre_modification .valeur_nfr").html($(element).parent().parent().find(".projet").text());
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
						elements+="<th class='actions'>actions</th>"
						elements+="</thead>";
						if(resultat.length>0)
							for(var i=0; i<resultat.length; i++) {
								elements+="<tr  id='"+resultat[i].id+"'>";
								for(j=0;j<Champs_a_afficher.length;j++){
									valeur=eval("resultat[i]."+Champs_a_afficher[j]);
									if(Champs_prix.indexOf(Champs_a_afficher[j])>-1)
										valeur=f(valeur)
									elements+="<td class='"+Champs_a_afficher[j]+"'>"+valeur+'</td>';
								}
								elements+="<td class='actions'>"
								elements+="<a href='javascript:' class='facture' title='<?php echo MESSAGE_GERER_FACTURE ;?>'></a>"
								// elements+="<a href='javascript:' class='plus' title='<?php echo MESSAGE_AJOUTER_AVANCE ;?>'></a>"
								elements+="<a href='javascript:' class='itineraire' title='<?php echo MESSAGE_GERER_ITINERAIRES;?>'></a>"
								elements+="<a href='javascript:' class='liste' title='<?php echo MESSAGE_LISTE_ETATS_PROJET;?>'></a>";
								elements+="<a href='javascript:' class='modifier' title='<?php echo MESSAGE_MODIFIER;?>'></a></td></tr>";
							}
							else
								elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
							$elements=$(elements)
							var $elements=$(elements)
							$($elements).find("th").one("click",function(){
								fleche($(this))
							})
							$($elements).find(".plus").click(function(){
								id=$(this).parent().parent().attr("id");
								recharger_avances(id)
								ouvrir_avances(this)
							})
							$($elements).find(".facture").click(function(){
								id=$(this).parent().parent().attr("id");
								recharger_factures(id)
								ouvrir_factures(this)
							})
							$($elements).find(".itineraire").click(function(){
								id=$(this).parent().parent().attr("id");
								recharger_itineraires(id)
								ouvrir_itineraires(this)
							})
							$($elements).find(".modifier").click(function(){
								id=$(this).parent().parent().attr("id");
								charger_anciennes_informations(id);
								ouvrir_modification(this);
							})
							$($elements).find(".liste").click(function(){
								voir_etats_projet(this)
							})
							$("#tableau_elements").html($elements);
							$('.conteneur.elements').show();
							if(fonction_supplementaire)
								fonction_supplementaire()
							cacher_loader()
						}).error(function(){
							alert("erreur serveur")
							cacher_loader()
						})
					}
					function ouvrir_itineraires(element){
						$("#cadre_itineraires").fadeIn(400);
						$("#cadre_itineraires form input[name='id']").val($(element).parent().parent().attr("id"));
						$("#cadre_itineraires .nom_projet").html($(element).parent().parent().find(".projet").text());
						Prix_actuel=f_($(element).parent().parent().find(".prix").text());
					}

					function ouvrir_factures(element){
						$("#cadre_factures").fadeIn(400);
						$("#cadre_factures form input[name='id']").val($(element).parent().parent().attr("id"));
						$("#cadre_factures .nom_projet").html($(element).parent().parent().find(".projet").text());
						Prix_actuel=f_($(element).parent().parent().find(".prix").text());
					}
					</script>
				</head> 
				<body>
					<div id="conteneur">
						<?php include("php/entete.php"); ?>
						<div id="formulaire_ajout" >
							<?php require_once('ajouter_projet.php'); ?>
						</div>
						<div id="space">
						</div>
						<div id="ouvrir_formulaire" title="<?php echo MESSAGE_AJOUTER_PROJET;?>" title1="<?php echo MESSAGE_AJOUTER_PROJET;?>" title2="<?php echo MESSAGE_FERMER_FORMULAIRE;?>">
							Ajouter projet
						</div>
						<div id="entete_recherche" ></div>	
						<div class="conteneur projets">			
							<form>
								<table id="tableau_elements">

								</table>
								<?php include("php/pagination.php") ?>
							</form>
						</div>
						<?php 
						// include("php/fenetre_avances.php") ;
						include("php/fenetre_factures.php") ;
						include("php/fenetre_modification.php") ; 
						include("php/fenetre_itineraires.php") ; 
						?>

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