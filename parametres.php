<?php session_start();
$cle_actuelle="parametres";
$reference="php/";
include("php/config.php");
if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){

	if($_SESSION["connecter"]){
		?>

		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
		<head>	
			<title>Parametres</title>
			<meta charset="UTF-8">
			<meta http-equiv="Content-Type" content="UTF-8" />
			<meta name="author" content="mondersky" />
			<link rel="stylesheet" href="css/design.css?<?php echo date('l jS /of F Y h:i:s A'); ?>" type="text/css" />
			<script type="text/javascript" src="js/jquery.js"></script>
			<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" />
			<script type="text/javascript" src="js/jquery.validate.min.js"></script>
			<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
			<script type="text/javascript" src="js/autocomplete/js/jquery-ui-1.10.4.custom.js"></script>
			<script type="text/javascript" src="js/date_fr.js"></script>
			<script type="text/javascript" src="js/jquery.form.js"></script>
			<script type="text/javascript" src="js/jquery.validate.js"></script>
			<script type="text/javascript" src="js/notification/notification.js"></script>
			<script type="text/javascript" src="js/showHide.js" ></script>

			<script type="text/javascript" src="js/messages_fr.js"></script>
			<script>
			Cle_actuelle="parametres";
			var i=0;
			
			if(window.location.hash=="") window.location.hash="#comptes"
				function afficher_comptes(){
					charger_comptes();
					$("#ajouter").show();
					$("#parametres").hide();
					if(i==1){
						$('#ajout').toggleClass("parametres-active");
						$('#supp').toggleClass("parametres-active");
						i=0;
					}	
				}
				function afficher_parametres(){
					$("#parametres").show();
					$("#ajouter").hide();
					if(i==0){
						$('#ajout').toggleClass("parametres-active");
						$('#supp').toggleClass("parametres-active");
						i=1;
					}
				}
				function supprimer_compte(nom){
					$.post("ajax/enregistrement/supprimer_utilisateur.php",{nom:nom},function(resultat){
						var resultat = jQuery.parseJSON(resultat);
						if(resultat==1){
							charger_comptes();
						}
					})
				}
				function charger_comptes(){
					$.post("ajax/chargement/liste_comptes.php",function(resultat){
						var resultat = jQuery.parseJSON(resultat);
						var elements="";
						for(var i=0;i<resultat.length;i++)
						{
							elements+=("<tr id="+resultat[i].nom+"><td>"+resultat[i].nom+"</td><td>"+resultat[i].type+"</td>");	
							elements+="<td class='actions'><span class='supp' title=\"<?php echo MESSAGE_SUPPRIMER_UTILISATEUR;?>\"></span></td></tr>";
						}
						$("#tableau tbody").html(elements)
						$("#tableau .supp").click(function(){
							nom=$(this).parent().parent().attr("id");
							if(confirm("<?php echo CONFIRMATION_SUPPRIMER_UTILISATEUR;?>")){
								supprimer_compte(nom)
							}
						})
					}).error(function(){
				alert("erreur serveur")
				cacher_loader()
			})	

				}

				$(document).ready(function(){
					$("#type_compte input[type=radio]").each(function(){
					$(this).click(function(){
						if($(this).val()=="prestataire")
							$(".presta.cacher").toggleClass("cacher")
						else
							$(".presta:not(.cacher)").toggleClass("cacher")
					})
					})

					<?php 
					if($parametres["type"]=="prestataire")
					{
						?>
						<?php 
					} else { ?> $("#form_gestion .presta").toggleClass("cacher");
					$(".cacher td input").attr("disabled", "disabled"); 
					<?php } ?>
					$("#form_gestion").submit(function(){
						$.post("ajax/enregistrement/parametrer.php",$("#form_gestion").serialize(),function(resultat){
							document.location="routes.php";
						}).error(function(){
				alert("erreur serveur")
				cacher_loader()
			})
						return false;
					})
					eval("afficher_"+window.location.hash.replace("#","")+"()");
					$("#ajout").click(afficher_comptes)
					$("#supp").click(afficher_parametres)
					$("#parametres #general").click(function(){
						$('#general').toggleClass("active");
						$('#gestion_notification').toggleClass("active");
					})
					$("#parametres #gestion_notification").click(function(){
						$('#general').toggleClass("active");
						$('#gestion_notification').toggleClass("active");
					})
					charger_comptes();
					var Test_succee=false;
					$.validator.addMethod(
						"existant",function(){
							var nom = $('#nom').val();
							$.ajax({
								type: "POST",
								url: "ajax/chargement/verification.php",
								data:"nom="+nom,
								async: false,
								success:function(resultat) { 
									if (resultat == 1) 
									{
										Test_succee= false;
									} 
									else
									{
										Test_succee= true;
									}
								}

							})
							return (Test_succee);
						}, "Nom d'utilisateur existant"); 
					$(".ajout_comptes").validate({
						rules: {
							"nom":{
								"required": true,
								"minlength": 4,
								"existant": true,
							},
							"mdp": {
								"required": true,
								"maxlength": 255,
								"minlength":5
							},
							"type": {
								"required": true
							},         
							"mdp1": {
								"required": true,
								"minlength":5,
								equalTo: "#mdp",

							},
						},

						messages: {
							mdp: {
								required: "S'il vous plais entrez un mot de pass valide",
								minlength: "Votre mot de passe doit contenir au minimum 5 characteres"
							},
							mdp1: {
								required: "S'il vous plais entrez un mot de pass valide",
								minlength: "Votre mot de passe doit contenir au minimum 5 characteres",
								equalTo: "Entrez le meme mot de passe"
							},
						}
					})
					$(".ajout_comptes").ajaxForm({
						beforeSubmit: function () {
							charger_comptes();
							return $(".ajout_comptes").valid();
						},
						success: function (returnData) {
							charger_comptes();
						}
					})

				})

</script>
<style type="text/css">

</style>
</head> 
<body style="height:100%">
	<div id="conteneur"> 
		<div id="notif">
			<div id="notifh">
				<a href="#" id="notification" rel="#fond"></a>
			</div>
		</div>
		<img src="elements/logo.png" alt="fastliner" />

		<div id="entete">
			<nav>
				
				<ul style="height: 30px;">
					<?php	foreach($liste_pages as $cle=>$valeur){
						?>
						<li class="lien_page <?php if($cle==$cle_actuelle) echo 'active'; ?>"><a href="<?php echo $cle; ?>"><?php echo $valeur; ?></a></li>
						<?php
					} ?>
					<li style="width: auto;" class="active"><div><a href="parametres" ><img src="elements/index_blanche.png" alt="parametres" /></a></div></li>
				</ul>

			</nav>	
		</div>
		<div id="moteur" style="height: 30px;" >
		</div>
		<div id="formulaire_ajout"></div>
		<div id="entete" style="display:block;" class="entete_parametres">
			<nav>
				<span id="nom_utilisateur" style="float:left;margin-top:20px!important;" title="<?php echo MESSAGE_NOM_UTILISATEUR;?>"><?php echo $_SESSION["nom"]; ?></span>
				<ul style="top: 13px !important; height: 30px; ">
					<li id="ajout" class="parametres-active" style="top: 15px ! important;margin-top: 0px !important"><a href="#comptes" class="lien_page" style="font-size:12px;">Comptes</a></li>
					<li id="supp" style="top: 15px ! important;margin-top: 0px !important"><a href="#parametres" class="lien_page"style="font-size:12px;">Parametres </a></li>
					<li style="top: 15px ! important;margin-top: 0px !important">
						<form action="php/deconnexion.php"method="post">
							<div id="deconnexion">
								<input name="deconnexion"type="submit" value="" title="<?php echo MESSAGE_DECONNEXION;?>" class="lien_page deconnexion"></input>
							</div>
						</form>
					</li>	
				</ul>
			</nav>
		</div>
		<div id="ajouter">
			<div>
				<center><h1>Liste des comptes</h1><hr style="width:500px;color:#FEC655;"></center>
				<table id="tableau">
					<thead >
						<tr>
							<th>nom</th>
							<th>Type</th>
							<th class='actions'>actions</th>
							<th class='colonne_boutons'></th>
						</tr>
					</thead>
					<tbody style="text-align:center;">
					</tbody>
				</table>
			</br>
			<center>
				<hr style="width:500px;color:#FEC655;">
				<h1>Ajouter un compte</h1>
				<hr style="width:130px;color:#FEC655;">
			</center>
		</br>
		<form id="form" class="cmxform ajout_comptes" method="post" enctype="multipart/form-data" action='ajax/enregistrement/ajouter_utilisateur.php' >
			<table id="ajout_comptes ajout_projets">
				<tr>
					<td class="tabletd">
						<label for="nom">Nom d'utilisateur </label>
					</td>
					<td>
						<input class="input" type="text" id="nom" autocomplete="off" name="nom"/>
					</td>
				</tr>
				<tr>
					<td class="tabletd">
						<label for="mdp">Mot de passe </label>
					</td>
					<td>
						<input class="input"type="password" name="mdp" id="mdp"/>
					</td>
				</tr>
				<tr>
					<td class="tabletd">
						<label for="mdp1">retapez le mot de passe </label>
					</td>
					<td >
						<input class="input" type="password" name="mdp1" id="mdp1" />
					</td>
				</tr>
				<tr>
					<td class="tabletd">
						<label for="type">Type de compte </label>
					</td>
					<td>
						<select class="input"style="color: black;" name="type">
							<option value="administrateur" >administrateur</option>
							<option  value="super-administrateur">super-administrateur</option>
						</select>
					</td>
				</tr>
			</table>
			<center><input class= "ajout" style="vertical-align:top;margin-top:15px;padding:5px 43px;width:auto" type="submit" value="enregistrer " /></center>
			<br>
		</form>	
	</div>
</div>
<div id="parametres" style="display:none;">
	<div>
		<center>
			<h1>Parametres de l'application</h1>
			<hr style="width:500px;color:#FEC655;">
		</center>

		<form id="form_gestion" class="parametrer_compte" method="post" enctype="multipart/form-data" >
			<table class="all">
				<tr>
					<td>
						<label for="type">type d'entreprise </label>
					</td>
					<td style="margin-left:-40px;text-align:center;" id="type_compte" >
						<input type="radio" name="type" value="sous-traitant" style="margin-right:-4px;margin-left:-20px" title="<?php echo MESSAGE_TYPE_ENTREPRISE;?>" <?php if($parametres["type"]=="sous-traitant") echo "checked='checked'";?>/><span style="margin-top:-3px;" class="blanc"  title="<?php echo MESSAGE_TYPE_ENTREPRISE;?>">Sous-traitant</span>
						<input type="radio" name="type" value="prestataire" style="margin-right:-4px" <?php if($parametres["type"]=="prestataire") echo "checked='checked'";?>  title="<?php echo MESSAGE_TYPE_ENTREPRISE;?>"/><span class="blanc"  title="<?php echo MESSAGE_TYPE_ENTREPRISE;?>">Prestataire</span>
					</td>
				</tr>
				<tr>
					<td class="espace_tableau"></td>
					<td class="espace_tableau"></td>
				</tr>
				<tr>
					<td>
						<label for="nbr_page">nombre de lignes par tableau </label>
					</td>
					<td>
						<input type="number" name="elements_par_page" id="elements_par_page" value="<?php echo $parametres['elements_par_page'];?>" class="input" style="margin-left:7px" title="<?php echo MESSAGE_ELEMENTS_PAR_TABLEAU ;?>"/>lignes
					</td>
				</tr>
				<tr>
					<td>
						<label for="nbr_page">suffixe prix</label>
					</td>
					<td>
						<input type="text" name="suffixe" id="suffixe" value="<?php echo $parametres['suffixe'];?>" class="input" style="margin-left:7px" title="<?php echo MESSAGE_SUFFIXE;?>" />
					</td>
				</tr>
			</table>
			<br />
			<table class="presta">
				<tr>
					<td>
						<label for="delai_assurance">Notifier l'assurance avant </label>
					</td>
					<td>
						<input type="number" name="delai_assurance" id="delai_assurance"  value="<?php echo $parametres['delai_assurance'];?>" class="input" /><span class="blanc">jours</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="delai_vignette">Notifier la vignette avant </label>
					</td>
					<td>
						<input type="number" name="delai_vignette" id="delai_vignette"  class="input" value="<?php echo $parametres['delai_vignette'];?>"  /><span class="blanc">jours</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="delai_scanner">Notifier le scanner avant </label>
					</td>
					<td>
						<input type="number" name="delai_scanner" id="delai_scanner"  class="input" value="<?php echo $parametres['delai_scanner'];?>" /><span class="blanc">jours</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="delai_controle_technique">Notifier le controle technique avant </label>
					</td>
					<td>
						<input type="number" name="delai_controle_technique" id="delai_controle_technique"  class="input" value="<?php echo $parametres['delai_controle_technique'];?>" /><span class="blanc">jours</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="delai_assurance_chauffeur">Notifier l'assurance chauffeur avant </label>
					</td>
					<td>
						<input type="number" name="delai_assurance_chauffeur" id="delai_assurance_chauffeur"  class="input" value="<?php echo $parametres['delai_assurance_chauffeur'];?>" /><span class="blanc">jours</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="delai_paye_chauffeur">Notifier la paye des chauffeurs avant </label>
					</td>
					<td>
						<input type="number" name="delai_paye_chauffeur" id="delai_paye_chauffeur"  class="input" value="<?php echo $parametres['delai_paye_chauffeur'];?>" /><span class="blanc">jours</span>
					</td>
				</tr>
			</div>
		</table>
		<center><input class= "ajout" style="vertical-align:top;margin:20px 0;padding:5px 43px;width:auto;" type="submit" value="enregistrer " /></center>

	</form>
</div>	
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