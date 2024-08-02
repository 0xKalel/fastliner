<div id="cadre_factures" class="fond_noir" style="">
	<base href="">
	<div id="conteneur_facture" class="conteneur_lightbox">
		<form action="" method="post">
			<input type="hidden" name="id">
			<a href="javascript:" class="bouton_fermer" title="<?php echo MESSAGE_FERMER_FENETRE;?>"></a>
			<h3 style="text-align: left;color:rgb(200,200,200);display:block">
				<span>
					factures du projet <span class="nom_projet"></span>
				</span>
				<span style="float:right">
				</span>
			</h3>
			<table id="factures_precedents"></table>
			<div class="nouvel_facture">
				<h3 style="text-align: center;">Nouvelle facture:</h3>
				<table>
					<tr>
						<td><input type="text" placeholder="nom facture" name="nom" class="input" autocomplete="off" ></td>
						<td><input type="text" placeholder="date" name="date" class="input date" value="<?php echo date("d/m/Y");?>" title="<?php echo MESSAGE_DATE_FACTURE;?>"></td>
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
function ouvrir_fenetre(url)
{
    var thePopCode = window.open(url,'rrrr','height='+screen.height+',width='+screen.width+',fullscreen=yes, top=0, left=0, scrollable=yes, menubar=no, resizable=yes');
    if (window.focus) 
    {
        thePopCode.focus();
    }
}
function recharger_factures(id_element){
	var param={idprojet:id_element,cle_actuelle:Cle_actuelle};
	$.post("ajax/chargement/charger_factures.php",param,function(resultat){
		if(resultat!="null"){

			var resultat = jQuery.parseJSON(resultat);
			factures="<center>aucun facture.</center>";
			if((resultat!=-1)&&(resultat.length>0)){
				factures="<thead><th>nom</th><th>date</th><th title='<?php echo MESSAGE_NOMBRE_FRS;?>'>FRS</th><th title='<?php echo MESSAGE_TOTAL_PRIX_FACTURE;?>'>total prix</th></thead><tbody>";
				for(i=0;i<resultat.length;i++)
					factures+="<tr cle='"+resultat[i].id+"'><td>"+resultat[i].nom+"</td><td>"+resultat[i].date+"</td><td>"+resultat[i].nombre_frs+"</td><td>"+resultat[i].total_prix+"<span class='bouton_selection_frs' title='<?php echo MESSAGE_ASSIGNER_FRS;?>'></span></td></tr>";
			}
		}
		else
			factures="<span>aucune facture.</span>"
		$factures=$(factures);
		$($factures).find(".bouton_selection_frs").each(function(){
			
			$(this).click(function(){
				ouvrir_fenetre("facturation/"+$("#cadre_factures input[name='id']").val()+"/"+$(this).parent().parent().attr("cle"))
			})
		}
		)
		$("#cadre_factures #factures_precedents").html($factures)
	})
	cacher_loader()
}
$(document).ready(function(){
	$("#cadre_factures").hide().css("visibility","visible");
	$("#cadre_factures input[name='date']").datepicker();
	$("#cadre_factures .bouton_fermer").click(function(){
		charger_elements(Sort,Ordre,Filtre,Interval_date,Page)
		$("#cadre_factures").fadeOut(200)
	});
	$("#cadre_factures input[name='valeur']").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
	$("#cadre_factures form").submit(function(){
		
		var param=$(this).serialize();
		afficher_loader("#conteneur_factures")
		$.post("ajax/enregistrement/ajouter_facture.php",param,function(resultat){
			var resultat = jQuery.parseJSON(resultat);
			switch(resultat){
				case(1):
				recharger_factures($("#cadre_factures input[name='id']").val())
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