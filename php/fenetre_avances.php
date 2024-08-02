<div id="cadre_avances" class="fond_noir" style="">
	<div id="conteneur_avances" class="conteneur_lightbox">
		<form action="" method="post">
			<input type="hidden" name="id">
			<a href="javascript:" class="bouton_fermer" title="<?php echo MESSAGE_FERMER_FENETRE;?>"></a>
			<?php 
			switch($cle_actuelle){
				case("projets"):{
					?>
					<h3 style="text-align: left;color:rgb(200,200,200);display:block">
						<span>
							Avances pour le projet <span class="valeur_nfr"></span>
						</span>
						<span style="float:right">Prix calculé : <span class="valeur_prix"></span> <span class="valeur_nombre_routes"></span></span>
						<span style="float:right">
						</span>
					</h3>
					<?php
				}
				break;
				case("etats"):
				case("routes"):{
					?>
					<h3 style="text-align: left;color:rgb(200,200,200);display:block">
						<span>Avances pour la FR N°<span class="valeur_nfr"></span></span>
						<span style="float:right">Prix: <span class="valeur_prix"></span></span>
					</h3>
					<?php
				}
				break;
				case("dettes_personnel"):{
					?>
					<h3 style="text-align: left;color:rgb(200,200,200);display:block">
						<span>Avances pour la dette <span class="valeur_nfr"></span></span>
						<span style="float:right">Prix: <span class="valeur_prix"></span></span>
					</h3>
					<?php
				}
				break;
				case("creances_personnel"):{
					?>
					<h3 style="text-align: left;color:rgb(200,200,200);display:block">
						<span>Avances pour la créance <span class="valeur_nfr"></span></span>
						<span style="float:right">Prix: <span class="valeur_prix"></span></span>
					</h3>
					<?php
				}
				break;
			}
			?>
			
			<table id="avances_precedentes"></table>
			<div class="nouvelle_avance">
				<h3 style="text-align: center;">Nouvelle avance:</h3>
				<table>
					<tr>
						<td><input type="text" placeholder="valeur" name="valeur" class="input" autocomplete="off" title="<?php echo MESSAGE_VALEUR_NOUVELLE_AVANCE;?>" ></td>
						<td><input type="text" placeholder="date" name="date" class="input" autocomplete="off" value="<?php echo date("d/m/Y");?>" title="<?php echo MESSAGE_DATE_NOUVELLE_AVANCE;?>"></td>
					</tr>
				</table>
				<br>
				<input type="hidden" placeholder="valeur" name="cle_actuelle" value="<?php echo $cle_actuelle; ?>" autocomplete="off">
				<center><input style="vertical-align:top;" type="submit" value="ajouter" class="bouton_orange" /></center>
			</div>
			<div class="avances_regle">Réglé</div>
		</form>
	</div>
</div>		
<script type="text/javascript">
var Restant;
function recharger_avances(id_element){
	var param={id:id_element,cle_actuelle:Cle_actuelle};
	$.post("ajax/chargement/recharger_avances.php",param,function(resultat){
		var resultat = jQuery.parseJSON(resultat);
		var total_avances=0;
		avances="<center>aucune avance.</center>";
		restant=0;
		if((resultat!=-1)&&(resultat.length>0)){
			avances="<thead><th>avance</th><th>date</th></thead><tbody>";
			for(i=0;i<resultat.length;i++){
				if(resultat[i].valeur!=0)
					avances+="<tr cle='"+resultat[i].id+"'><td>"+f(resultat[i].valeur)+"</td><td>"+resultat[i].date+"<span class='bouton_supprimer'></span></td></tr>";
				
				total_avances+=parseFloat(resultat[i].valeur);
			}
			avances+="<tr><td class='espace_tableau'></td><td class='espace_tableau'></td></tr>";
			avances+="<tr><td class='orange'>total avances</td><td class='orange'>restant</td></tr>";
		}
		switch(Cle_actuelle){
			case("projets"):{
				var param={id:id_element};
				$.post("ajax/chargement/charger_nombre_routes.php",param,function(result){
					var result = jQuery.parseJSON(result);
					if(result==1)
						text_routes="1 FR";
					else{
						result=(result==-2)? 0:result;
						text_routes=result+" FRs";
					}
					if(result!=-1)
						$("#cadre_avances .valeur_nombre_routes").html("("+text_routes+")")
					else
						alert("erreur. actualisez la page.")
					result=(result==0)? 1:result;
					restant=(Prix_actuel*result)-total_avances;
					avances+="<tr><td>"+f(total_avances)+"</td><td>"+f(restant)+"</td></tr>";
					avances+="</tbody>";
					$("#cadre_avances .valeur_prix").html(f(Prix_actuel*result))
					Restant=restant;
					$("#cadre_avances input[name='valeur']").val(restant)
					$avances=$(avances);
					$($avances).find(".bouton_supprimer").click(function(){
						bouton_supprimer=$(this);
						afficher_loader("#conteneur_avances")
						var param={id:$(bouton_supprimer).parent().parent().attr("cle"),cle_actuelle:Cle_actuelle};
						$.post("ajax/enregistrement/supprimer_avance.php",param,function(result){
							var result = jQuery.parseJSON(result);
							if(result==1)
								recharger_avances(id_element)
							else
								alert(result)
						}).error(function(){
							alert("erreur serveur")
							cacher_loader()
						})
					})
					if(restant==0){
						$(".nouvelle_avance").hide()
						$(".avances_regle").show();
					}
					else{
						$(".nouvelle_avance").show()
						$(".avances_regle").hide();		
					}			
					if((resultat!=-1)&&(resultat.length>0)&&(total_avances>0))
						$("#cadre_avances #avances_precedentes").html($avances)
					else
						$("#cadre_avances #avances_precedentes").html("<center>aucune avance.</center>")

				}).error(function(){
					alert("erreur serveur")
					cacher_loader()
				})
			}
			break;
			case("etats"):
			case("routes"):{
				restant=Prix_actuel-total_avances;
				avances+="<tr><td>"+f(total_avances)+"</td><td>"+f(restant)+"</td></tr>";
				avances+="</tbody>";
				$("#cadre_avances input[name='valeur']").val(restant)
				Restant=restant;
				$avances=$(avances);
				$($avances).find(".bouton_supprimer").click(function(){
					bouton_supprimer=$(this);
					afficher_loader("#conteneur_avances")
					var param={id:$(bouton_supprimer).parent().parent().attr("cle"),cle_actuelle:Cle_actuelle};
					$.post("ajax/enregistrement/supprimer_avance.php",param,function(result){
						var result = jQuery.parseJSON(result);
						if(result==1)
							recharger_avances(id_element)
						else
							alert(result)
					}).error(function(){
						alert("erreur serveur")
						cacher_loader()
					})
				})
				if(restant==0){
					$(".nouvelle_avance").hide()
					$(".avances_regle").show();
				}
				else{
					$(".nouvelle_avance").show()
					$(".avances_regle").hide();		
				}
				$("#cadre_avances .valeur_prix").html(f(Prix_actuel))
				if((resultat!=-1)&&(resultat.length>0)&&(total_avances>0))
					$("#cadre_avances #avances_precedentes").html($avances)
				else
					$("#cadre_avances #avances_precedentes").html("<center>aucune avance.</center>")
			}
			break;
			case("dettes_personnel"):{
				restant=Prix_actuel-total_avances;
				avances+="<tr><td>"+f(total_avances)+"</td><td>"+f(restant)+"</td></tr>";
				avances+="</tbody>";
				$("#cadre_avances input[name='valeur']").val(restant)
				Restant=restant;
				$avances=$(avances);
				$($avances).find(".bouton_supprimer").click(function(){
					afficher_loader("#conteneur_avances")
					bouton_supprimer=$(this);
					var param={id:$(bouton_supprimer).parent().parent().attr("cle"),cle_actuelle:Cle_actuelle};
					$.post("ajax/enregistrement/supprimer_avance.php",param,function(result){
						var result = jQuery.parseJSON(result);
						if(result==1)
							recharger_avances(id_element)
						else
							alert(result)
					}).error(function(){
						alert("erreur serveur")
						cacher_loader()
					})
				})
				if(restant==0){
					$(".nouvelle_avance").hide()
					$(".avances_regle").show();
				}
				else{
					$(".nouvelle_avance").show()
					$(".avances_regle").hide();		
				}
				$("#cadre_avances .valeur_prix").html(f(Prix_actuel))
				if((resultat!=-1)&&(resultat.length>0)&&(total_avances>0))
					$("#cadre_avances #avances_precedentes").html($avances)
				else
					$("#cadre_avances #avances_precedentes").html("<center>aucune avance.</center>")
			}
			break;
			case("creances_personnel"):{
				restant=Prix_actuel-total_avances;
				avances+="<tr><td>"+f(total_avances)+"</td><td>"+f(restant)+"</td></tr>";
				avances+="</tbody>";
				$("#cadre_avances input[name='valeur']").val(restant)
				Restant=restant;
				$avances=$(avances);
				$($avances).find(".bouton_supprimer").click(function(){
					bouton_supprimer=$(this);
					afficher_loader("#conteneur_avances")
					var param={id:$(bouton_supprimer).parent().parent().attr("cle"),cle_actuelle:Cle_actuelle};
					$.post("ajax/enregistrement/supprimer_avance.php",param,function(result){
						var result = jQuery.parseJSON(result);
						if(result==1)
							recharger_avances(id_element)
						else
							alert(result)
					}).error(function(){
						alert("erreur serveur")
						cacher_loader()
					})
				})
				if(restant==0){
					$(".nouvelle_avance").hide()
					$(".avances_regle").show();
				}
				else{
					$(".nouvelle_avance").show()
					$(".avances_regle").hide();		
				}
				$("#cadre_avances .valeur_prix").html(f(Prix_actuel))
				if((resultat!=-1)&&(resultat.length>0)&&(total_avances>0))
					$("#cadre_avances #avances_precedentes").html($avances)
				else
					$("#cadre_avances #avances_precedentes").html("<center>aucune avance.</center>")
			}
		}
	})
cacher_loader()
}
$(document).ready(function(){
	$("#cadre_avances").hide().css("visibility","visible");
	$("#cadre_avances input[name='date']").datepicker();
	$("#cadre_avances .bouton_fermer").click(function(){
		charger_elements(Sort,Ordre,Filtre,Interval_date,Page)
		$("#cadre_avances").fadeOut(200)
	});
	$("#cadre_avances input[name='valeur']").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
	$("#cadre_avances form").submit(function(){
		if($("#cadre_avances input[name='valeur']").val()>Restant)
			alert("La nouvelle avance ne doit pas dépasser le restant");
		if($("#cadre_avances input[name='date']").val()=="")
			alert("Veuillez entrer une date");
		else
			if($("#cadre_avances input[name='valeur']").val()==0)
				alert("La nouvelle avance doit etre supperieur a 0");
			else
			{
				var param=$(this).serialize();
				afficher_loader("#conteneur_avances")
				$.post("ajax/enregistrement/ajouter_avance.php",param,function(resultat){
					var resultat = jQuery.parseJSON(resultat);
					switch(resultat){
						case(1):
						recharger_avances($("#cadre_avances input[name='id']").val())
						break;
						case(-1):
						alert("veuillez entrer une valeur");
						break;
						case(-2):
						alert("veuillez entrer une date");
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
			}
			return false;
		})
})
</script>