	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/messages_fr.js"></script>
	
	<script>
	function charger_matricules(){
		$.post("ajax/chargement/charger_matricules.php",function(resultat){
			var resultat = jQuery.parseJSON(resultat);
			for(var i=0;i<resultat.length;i++)
			{
				$("#matricule select").append("<option value ='"+resultat[i].matricule+"'>"+resultat[i].matricule+"</option>");	
			}
		})			
	}
	$(document).ready(function() {
		charger_matricules()
		$("input.date").datepicker();
		$("#form").validate({
			rules: {
				"nom_chauffeur":{
					"required": true,
					"minlength": 4,
				},
				"paye_chauffeur": {
					"required": true,
					"maxlength": 25,
					"number" : true
				},
				"date_chauffeur": {
					"required": true,
					exactlength: 10
				},
				"matricule": {
					"required": true
				}, 
				"date_assurance_chauffeur": {
					"required": true,
					exactlength: 10
				},  
				"assurance_chauffeur": {
					"number" : true,
					"required": true
				},  
				
			},
			messages:{
				"date_chauffeur":{
					exactlength: "veuillez fournir une date valide"
				},
				"date_assurance_chauffeur":{
					exactlength: "veuillez fournir une date valide"
				},
			},
			submitHandler: function (){	
			afficher_loader("#formulaire")	
				$.post("ajax/enregistrement/nouveau_chauffeur.php",$('#form').serialize(),function(resultat)
				{
					if(resultat==1)
					{
						afficher_nouvelle_ligne(resultat);
						$('#nom').val('');
						$('#paye').val('');
						$('#date').val('');
						$('#assurance').val('');
						$('#date_assurance').val('');
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
					<tr>
						<td><label for="nom_chauffeur">Nom Chauffeur</label></td>
						<td><input type="text" name="nom_chauffeur" id="nom"  placeholder="" /></td>
					</tr>	
					
					<tr>
						<td><label for="paye_chauffeur">Paye</label></td>
						<td><input type="text" name="paye_chauffeur" id="paye" placeholder="" /></td>
					</tr>	
					
					<tr>
						<td><label for="matricule">Matricule</label></td>
						<td id ="matricule"><select name="matricule"><option value=""></option> </select></td>
					</tr>

					<tr>
						<td><label for="date_chauffeur">date paye</label></td>
						<td><input type="date" name="date_chauffeur" id="date" class="date" /></td>
					</tr>
					
					<tr>
						<td><label for="assurance">Assurance</label></td>
						<td><input type="text" name="assurance_chauffeur" id="assurance" /></td>
					</tr>
					
					<tr>
						<td><label for="date_assurance">date Assurance</label></td>
						<td><input type="date" name="date_assurance_chauffeur" id="date_assurance" class="date" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input class= "conex" style="vertical-align:top;" type="submit" value="enregistrer"/></td>
					</tr>	
					<tr>
						<td></td>
						<td><div class="reussi"></div></td>
					</tr>	
				</tbody>
			</table>
			<br>
		</form>	
	</div>