<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/messages_fr.js"></script>

<script>
$(document).ready(function() {
	$("td #nom_pers").autocomplete().keyup(function(){
		Lettre=$(this).val();
		recharger_autocomplete_chauffeur(this,Lettre);
	})
	$("input.date").datepicker();
	$("#form").validate({
		rules: {
			"nom":{
				"required": true,
				"minlength": 5,
			},
			"paye": {
				"required": true,
				"maxlength": 255
			},
			"matricule": {
				"required": true
			},  
		},
		submitHandler: function (){		
			$.post("ajax/enregistrement/nouvelle_avance.php",$('#form').serialize(),function(resultat)
			{
				if(resultat==1)
				{	
					$( ".reussi" ).show().html("chargement réussi").fadeOut(3000);
					Sort="id";Ordre="DESC";Filtre;Interval_date={min:"0",max:"0"};Page=1;
					charger_routes(Sort,Ordre,Filtre,Interval_date,Page,function(){
						$("#tableau_projets tr").eq(1).find("td").css("background-color","#AACB21");
						setTimeout(function(){
							$("#tableau_projets tr").eq(1).find("td").toggleClass("dernier_ajoute");
						},700)
					})
				}
			}).error(function(){
				alert("erreur serveur")
				cacher_loader()
			})
		}
	})
})


</script>
<div id="formulaire" >
	<form id="form" class="cmxform" method="post" >
		<br>
		<table>
			<tbody>
				<div class="reussi" style="float:right;margin-right:50px;color:red;position:absolute;"></div>
				
				<tr>
					<td><label for="client">Nom (Personne/chauffeur)</label></td>
					<td><input type="text" name="nom" id="#nom_pers"  placeholder="" autocomplete="off"/></td>
				</tr>	
				
				<tr>
					<td><label for="date">date</label></td>
					<td><input type="text" name="date" id="date" placeholder="" class="date"/></td>
				</tr>	
				
				<tr>
					<td><label for="Avance">Avance </label></td>
					<td><input type="text" name="avance" id="avance" placeholder="" /></td>
				</tr>	
			</tbody>
		</table>
		<center><input class= "conex" style="vertical-align:top;" type="submit" value="enregistrer " /></center>
		<br>
	</form>	
</div>