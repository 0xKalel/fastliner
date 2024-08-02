	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/messages_fr.js"></script>
	
<script>
$(document).ready(function() {
	var Test_succee=false;
	$.validator.addMethod(
		"superieur",function(){
			var avance = $('#avance').val();
			var prix = $('#prix input').val();
			avance=parseInt(avance);
			prix=parseInt(prix);
			if (avance>prix)
			{	
				Test_succee=false;
			}
			else  
				Test_succee=true;
			return (Test_succee);
		}, "avance superieur au prix de la route"); 
	$("#form").validate({
		rules: {
			"client":{
				"required": true,
				"minlength": 4,
			},
			"depart":{
				"required": true,
				"minlength": 4,
			},
			"destination": {
				"required": true,
				"maxlength": 50,
			},
			"prix": {
				"required": true,
				"number":true,
			},  
			"projet": {
				"required": true
			},  
			"date": {
				"required": true,
				exactlength: 10
			},    
			"avance":{
				"number":true,
				"superieur" : true,
			},     
		},
		messages:{
			"date":{
				exactlength: "veuillez fournir une date valide"
			}
		}
	})
	$("#formulaire form").ajaxForm({
		beforeSubmit: function () {
			afficher_loader("#formulaire")
			return $("#formulaire #form").valid();
			
		},
		success: function (resultat) {
			if(resultat==1){
				afficher_nouvelle_ligne(resultat);
				$('#projet').val('');
				$('#client').val('');
				$('#depart').val('');
				$('#Destination').val('');
				$('#prix').val('');
				$('#avance').val('');
				$('#date').val('');
				$('#observation').val('');
			}
			else
				alert(resultat)
		}
	})
})
	
</script>
		<div id="formulaire" >
			<form id="form" class="cmxform" method="post" enctype="multipart/form-data" action='ajax/enregistrement/nouveau_projet.php'>
			<br>
				<table>
					<tbody>
							
						<tr>
						<td><label for="projet">Nom du projet</label></td>
						<td><input type="text" name="projet" id="projet" placeholder="le nom doit etre unique" /></td>
						</tr>	
						<tr>
						<td><label for="client">Nom du client</label></td>
						<td><input type="text" name="client" id="client"  placeholder="" /></td>
						</tr>
						<tr>
						<td><label for="depart">Depart</label></td>
						<td><input type="text" name="depart" id="depart"  placeholder="adresse du départ" /></td>
						</tr>	
							
						<tr>
						<td><label for="destination">Destination</label></td>
						<td><input type="text" name="destination" id="Destination" placeholder="adresse de la destination" /></td>
						</tr>
						<tr>	
						<td><label for="prix">Prix</label></td>
						<td id="prix"><input type="text" name="prix" placeholder="prix approximatif de la rotation" /></td>
						</tr>
						<tr>	
						<td><label for="avance">Avance</label></td>
						<td><input type="text" name="avance" id="avance" placeholder="avance si versée par le client" /></td>
						</tr>
						<tr>	
						<td><label for="date">Date</label></td>
						<td><input type="text" name="date" id="date" placeholder="date du commencement du projet" /></td>
						</tr>
						<tr>	
						<td><label for="observation">observation</label></td>
						<td><textarea name="observation" id="observation" placeholder="remarque à propos du projet" cols="17" rows="4"></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><input class= "conex" style="vertical-align:top;" type="submit" value="enregistrer " /></td>
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