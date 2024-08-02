<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/messages_fr.js"></script>
	
<script>
$(document).ready(function() {
	
	$("#ouvrir_formulaire").click(function(){$("#formulaire").slideToggle(500)});
	  $("#form").validate({
      rules: {
         "nom":{
            "required": true,
            "minlength": 5,
         },
         "date": {
            "required": true,
            "maxlength": 255
         },
         "somme": {
            "required": true
         },  
                 
		 },
 
  submitHandler: function (){		
		$.post("ajax/enregistrement/nouveau_debit.php",$('#form').serialize(),function(resultat)
		{
			afficher_nouvelle_ligne(resultat)
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
						<td><label for="client">Nom (Personne/chauffeur)</label></td>
						<td><input type="text" name="nom" id="nom"  placeholder="" /></td>
						</tr>	
							
						<tr>
						<td><label for="date">date</label></td>
						<td><input type="text" name="date" id="date" placeholder="EX : 1983-12-17" class="date"/></td>
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