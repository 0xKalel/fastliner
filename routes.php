<?php SESSION_start();
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
			<title>Liste de routes</title>
			<?php include("php/header.php");?>
			<script>
			var Cle_actuelle='<?php echo $cle_actuelle; ?>',chemin_fichiers="<?php echo $chemin_fichiers;?>";
			<?php include("php/variables.php") ?>;
			var Champs_omis=["id","idavance","idproduit","poids","ndocument","idprojet"],
			Champs_omis_selection=["date","poids","observation","ndocument","idproduit"];
			function ouvrir_modification(element){
			// cette ligne sert a réinitialiser les boutons de la modificatin d'un fichier
			$(".fichier.elements_fichier:not('.cache'),.nom_fichier.elements_fichier.cache,.icone_changer.cache").toggleClass("cache")
			$("#cadre_modification").fadeIn(400).find("label.error").remove();
			$("#formulaire:visible").slideToggle(500)
			$("#cadre_modification form input[name='id']").val($(element).parent().parent().attr("id"));
			$("#cadre_modification .valeur_nfr").html($(element).parent().parent().find(".nfr").text());
			nom_fichier=$(element).parent().parent().find(".fichier").attr("fichier");
			if(nom_fichier!="")
				$("#cadre_modification .nom_fichier").html($(element).parent().parent().find(".fichier").attr("fichier"));
			else{
				$(".icone_changer").toggleClass("cache")
				$(".elements_fichier").toggleClass("cache")
			}
		}
		function charger_elements(sort,ordre,filtre,interval_date,page,fonction_supplementaire){
			var param={cle_actuelle:Cle_actuelle,sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
			afficher_loader()
			$.post("ajax/chargement/charger_elements.php",param,function(resultat){
				cacher_loader()
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
					elements+="<th class='colonne_boutons'></th></thead>";
					if(!(resultat<0)){
						for(var i=0; i<resultat.length; i++) {
							etat_fichier="";
							etat_receptionne="";
							etat_facture="";
							fichier="javascript:";
							cible_fichier="";
							if(resultat[i].idfacture!=0){
								etat_facture="etat_facture'"
							}
							if(resultat[i].receptionne==1){
								etat_receptionne="etat_receptionne";
							}
							elements+="<tr id='"+resultat[i].id+"' class='"+etat_receptionne+" "+etat_facture+"'>";
							for(j=0;j<Champs_a_afficher.length;j++){
								valeur=eval("resultat[i]."+Champs_a_afficher[j]);
								if(Champs_prix.indexOf(Champs_a_afficher[j])>-1)
									valeur=f(valeur)
								elements+="<td class='"+Champs_a_afficher[j]+"' >"+valeur+'</td>';
							}
							elements+="<td class='actions'><a href='javascript:' class='plus' title='<?php echo MESSAGE_AJOUTER_AVANCE ;?>'></a>"
							elements+="<a href='javascript:' class='imprimante' title='<?php echo MESSAGE_IMPRIMER_FR;?>'></a>";
							elements+="<a href='javascript:' class='modifier' title='<?php echo MESSAGE_MODIFIER;?>'></a>";
							if(resultat[i].fichier==""){
								etat_fichier=" vide";
								title="<?php echo MESSAGE_FICHIER_VIDE;?>";
							}
							else{
								fichier=chemin_fichiers+resultat[i].fichier;
								cible_fichier="target='_blank'";
								title="<?php echo MESSAGE_AFFICHER_FICHIER;?>";
							}
							elements+="<a href='"+fichier+"' class='fichier"+etat_fichier+"' "+cible_fichier+" fichier='"+resultat[i].fichier+"' title=\""+title+"\"></a></td>";
							elements+="<td class='colonne_boutons'><div style='position:absolute;width:50px;margin-top:-10px'><a href='javascript:' class='icone_receptionne'title='<?php echo MESSAGE_RECEPTIONNE;?>'></a><a href='javascript:' class='icone_facture'title='<?php echo MESSAGE_RECEPTIONNE;?>'></a></div></td></tr>";
						}
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
					<?php require_once('ajouter_route.php'); ?>
				</div>
				<div id="space">
				</div>
				<div id="ouvrir_formulaire" title="<?php echo MESSAGE_AJOUTER_FR;?>" title1="<?php echo MESSAGE_AJOUTER_FR;?>" title2="<?php echo MESSAGE_FERMER_FORMULAIRE;?>">
					Ajouter FR
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
					<form style="position: relative;">
						<center>
							<table id="tableau_elements" >
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
