<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/messages_fr.js"></script>
<script>
$(document).ready(function() {
	$("#form").validate({
		rules: {
			"nom":{
				"required": true,
				"minlength": 5,
			},
			"date": {
				"required": true,
				exactlength: 10
			},
			"somme": {
				"number":true,
				"required": true
			},  
		},
		messages:{
			"date":{
				exactlength: "veuillez fournir une date valide"
			}
		},
		submitHandler: function (){	
			afficher_loader("#formulaire")	
			$.post("ajax/enregistrement/nouvelle_creance.php",$('#form').serialize(),function(resultat)
			{
				if(resultat==1){
				afficher_nouvelle_ligne(resultat)
				$("#form").get(0).reset();
			}
			else
				alert(resultat)
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
					<td><label for="client">Nom </label></td>
					<td><input type="text" name="nom" id="nom"  placeholder="" /></td>
				</tr>	
				
				<tr>
					<td><label for="objet">Objet</label></td>
					<td><input type="text" name="objet" id="objet"  placeholder="" /></td>
				</tr>	
				
				<tr>
					<td><label for="date">date</label></td>
					<td><input type="text" name="date" id="date" placeholder="" class="date"/></td>
				</tr>	
				<tr>
					<td><label for="somme">somme </label></td>
					<td><input type="text" name="somme" id="somme" placeholder="" /></td>
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