<?php session_start();
$cle_actuelle="vehicules";
$reference="php/";
include("php/config.php");
if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){
	if($_SESSION["connecter"]){
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
		<head>	
			<title>Liste de vehicules</title>
			<meta charset="UTF-8">
			<meta http-equiv="Content-Type" content="UTF-8" />
			<meta name="author" content="mondersky" />
			<link rel="stylesheet" href="css/design.css?<?php echo date('l jS /of F Y h:i:s A'); ?>" type="text/css" />
			<script type="text/javascript" src="js/jquery.js"></script>
			<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" />
			<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
			<script type="text/javascript" src="js/autocomplete/js/jquery-ui-1.10.4.custom.js"></script>
			<script type="text/javascript" src="js/date_fr.js"></script>
			<script type="text/javascript" src="js/notification/notification.js"></script>
			<script type="text/javascript" src="js/showHide.js" ></script>
			<script type="text/javascript" src="js/scripts.js"></script>
			<script type="text/javascript" src="js/jquery-form.js"></script>

			<script>
			var Cle_actuelle='<?php echo $cle_actuelle; ?>',chemin_fichiers="<?php echo $chemin_fichiers_vehicules; ?>";
			<?php include("php/variables.php") ?>;
			var K=0,Champs_omis=["id","idavance"];
			Champs_omis_selection=["poids","observation","ndocument","idproduit,prix_assurance,prix_vignette,prix_scanner,prix_controle"];
			function ouvrir_modification(element){
				$("#cadre_modification").fadeIn(400).find("label.error").remove();;
				$("#formulaire:visible").slideToggle(500)
				$("#cadre_modification form input[name='id']").val($(element).parent().parent().attr("id"));
				$("#cadre_modification .valeur_nfr").html($(element).parent().parent().find(".matricule").text());
			}
			function charger_elements(sort,ordre,filtre,interval_date,page,fonction_supplementaire){
				var param={cle_actuelle:Cle_actuelle,sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
				afficher_loader()
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
							elements+="<th champ='"+Champs_a_afficher[j]+"' class='"+class_suplementaire+"'>"+Champs[Champs_a_afficher[j]]+'</th>';
						}
						elements+="<th class='actions'>actions</th>"
						elements+="</thead>";
						if((resultat!=-1)&&(resultat!=-2))
							for(var i=0; i<resultat.length; i++) {
								etat_fichier="";
								fichier="javascript:";
								cible_fichier="";
								elements+="<tr id='"+resultat[i].id+"'>";

								for(j=0;j<Champs_a_afficher.length;j++){

									elements+="<td class='"+Champs_a_afficher[j]+"'>"+eval("resultat[i]."+Champs_a_afficher[j])+'</td>';
								}
								if(resultat[i].fichier=="")
									etat_fichier=" vide";
								else{
									fichier=chemin_fichiers+resultat[i].fichier;
									cible_fichier="target='_blank'";
								}
								elements+="<td class='actions'><a href='javascript:' class='modifier'></a>";
								elements+="<a href='"+fichier+"' class='fichier"+etat_fichier+"' "+cible_fichier+" fichier='"+resultat[i].fichier+"'></a></td></tr>";
							}
							else
								elements="<tr><td>Il n'y a aucun résultat pour cette recherche</td></tr>";
							$elements=$(elements)
							var $elements=$(elements)
							$($elements).find("th").one("click",function(){
								fleche($(this))
							})
							$($elements).find(".modifier").click(function(){
								id=$(this).parent().parent().attr("id");
								charger_anciennes_informations(id);
								ouvrir_modification(this);
							})
							$("#tableau_elements").html($elements);
							$('.conteneur.elements').show();
							cacher_loader()
							if(fonction_supplementaire)
								fonction_supplementaire()
						}).error(function(){
							alert("erreur serveur")
							cacher_loader()
						})
					}
					</script>

				</head> 
				<body>
					<div id="conteneur">
						<?php include("php/entete.php"); ?>
						<div id="formulaire_ajout" >
							<?php require_once('ajouter_camion.php'); ?>

						</div>
						<div id="space">
						</div>
						<div id="ouvrir_formulaire" >
							Ajouter
						</div>
						<div id="entete_recherche" ></div>	
						<div class="conteneur elements">
							<div id="entete_tableau"></div>
							<form>
								<table id="tableau_elements">

								</table>
								<?php include("php/pagination.php"); ?>
							</form>
						</div>
						<?php include("php/fenetre_modification.php") ; ?>
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