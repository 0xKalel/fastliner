<div id="cadre_itineraires" class="fond_noir" style="">
	<div id="conteneur_itineraire" class="conteneur_lightbox">
		<form action="" method="post">
			<input type="hidden" name="id">
			<a href="javascript:" class="bouton_fermer" title="<?php echo MESSAGE_FERMER_FENETRE;?>"></a>
					<h3 style="text-align: left;color:rgb(200,200,200);display:block">
						<span>
							Itineraires du projet <span class="nom_projet"></span>
						</span>
						<span style="float:right">
						</span>
					</h3>
			<table id="itineraires_precedents"></table>
			<div class="nouvel_itineraire">
				<h3 style="text-align: center;">Nouvel itineraire:</h3>
				<table>
					<tr>
						<td><input type="text" placeholder="depart" name="depart" class="input" autocomplete="off" ></td>
						<td><input type="text" placeholder="destination" name="destination" class="input" autocomplete="off"></td>
						<td><input type="text" placeholder="prix" name="prix" class="input" autocomplete="off"></td>
					</tr>
				</table>
				<br>
				<input type="hidden" placeholder="valeur" name="cle_actuelle" value="<?php echo $cle_actuelle; ?>" autocomplete="off">
				<center><input style="vertical-align:top;" type="submit" value="ajouter" class="bouton_orange" /></center>
			</div>
		</form>
	</div>
</div>		
<script type="text/javascript">
var Restant;
function recharger_itineraires(id_element){
	var param={idprojet:id_element,cle_actuelle:Cle_actuelle};
	$.post("ajax/chargement/charger_itineraires.php",param,function(resultat){
		var resultat = jQuery.parseJSON(resultat);
		itineraires="<center>aucun itineraire.</center>";
		if((resultat!=-1)&&(resultat.length>0)){
			itineraires="<thead><th>depart</th><th>destination</th><th>prix</th></thead><tbody>";
			for(i=0;i<resultat.length;i++)
					itineraires+="<tr cle='"+resultat[i].id+"'><td>"+resultat[i].depart+"</td><td>"+resultat[i].destination+"</td><td>"+f(resultat[i].prix)+"</td></tr>";
		}
		$("#cadre_itineraires #itineraires_precedents").html(itineraires)
	})
cacher_loader()
}
$(document).ready(function(){
	$("#cadre_itineraires").hide().css("visibility","visible");
	$("#cadre_itineraires input[name='date']").datepicker();
	$("#cadre_itineraires .bouton_fermer").click(function(){
		charger_elements(Sort,Ordre,Filtre,Interval_date,Page)
		$("#cadre_itineraires").fadeOut(200)
	});
	$("#cadre_itineraires input[name='valeur']").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
	$("#cadre_itineraires form").submit(function(){
		
				var param=$(this).serialize();
				afficher_loader("#conteneur_itineraires")
				$.post("ajax/enregistrement/ajouter_itineraire.php",param,function(resultat){
					var resultat = jQuery.parseJSON(resultat);
					switch(resultat){
						case(1):
						recharger_itineraires($("#cadre_itineraires input[name='id']").val())
						break;
						case(-1):
						alert("veuillez entrer un depart");
						break;
						case(-2):
						alert("veuillez entrer une destination");
						break;
						case(-3):
						alert("erreur connexion");
						break;
						default:
						alert(resultat);
						break;

					}
				}).error(function(){
				alert("erreur serveur")
				cacher_loader()
			})
			return false;
		})
})
</script>