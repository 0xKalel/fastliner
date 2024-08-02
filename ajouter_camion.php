	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/messages_fr.js"></script>
	<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
	<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" >
	<script type="text/javascript" src="js/date_fr.js"></script>
	<script>    
	$(document).ready(function(){
		$("input.date").datepicker();
		$("#form").validate({
			rules: {
				"nom":{
					"required": true,
					"minlength": 4,
				},
				"matricule": {
					"required": true,
					"maxlength": 255
				},
				"type": {
					"required": true
				},         
				"date_assurance": {
					"required": true,
					exactlength: 10
				},
				"date_vignette": {
					"required": true,
					exactlength: 10
				},
				"date_scanner": {
					"required": true,
					exactlength: 10
				},
				"controle_technique": {
					"required": true,
					exactlength: 10
				},
				"date_chauffeur": {
					"required": true,
					exactlength: 10
				},
				"date_assurance_chauffeur": {
					"required": true,
					exactlength: 10
				},
				"prix_assurance": {
					"number" : true,
					"required": true
				},
				"prix_scanner": {
					"number" : true,
					"required": true
				},
				"prix_vignette": {
					"number" : true,
					"required": true
				},
				"prix_controle": {
					"number" : true,
					"required": true
				},
			},
			messages:{
				"date_assurance":{
					exactlength: "veuillez fournir une date valide"
				},
				"date_vignette":{
					exactlength: "veuillez fournir une date valide"
				},
				"date_scanner":{
					exactlength: "veuillez fournir une date valide"
				},
				"controle_technique":{
					exactlength: "veuillez fournir une date valide"
				},
				"date_chauffeur":{
					exactlength: "veuillez fournir une date valide"
				},
				"date_assurance_chauffeur":{
					exactlength: "veuillez fournir une date valide"
				},
			}
		})
	$("#form").ajaxForm({
		beforeSubmit: function () {
			afficher_loader("#formulaire")
			return $("#form").valid();
		},
		success: function (resultat) {
			afficher_nouvelle_ligne(resultat);
			$('#nom').val('');
			$('#type').val('');
			$('#matricule').val('');
			// $('#date_assurance1').val('');
			// $('#date_vignette1').val('');
			// $('#date_scanner1').val('');
			$('#controle_technique1').val('');
			$('#prix_assurance').val('');
			$('#prix_vignette').val('');
			$('#prix_scanner').val('');
			$('#prix_controle').val('');
			$('#nom_chauffeur').val('');
			$('#paye_chauffeur').val('');
			$('#date_chauffeur').val('');
			$('#assurance_chauffeur').val('');
			$('#date_assurance_chauffeur').val('');
		}
	})
})
	</script>


	<div id="formulaire" >
		<form id="form" class="cmxform" method="post" enctype="multipart/form-data" action='ajax/enregistrement/nouveau_camion.php' >
			<table id="ajout_projets">
				
				<tr>
					<td>
						<label for="fichier">fichier</label>
					</td>
					<td>
						<input name="fichier" id="fichier" type="file" autocomplete="off" style="border:none;width:125px;color:white" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="nom">Marque</label>
					</td>
					<td>
						<input type="text" name="marque" id="nom"  placeholder="EX :gharbi ali" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="type">Type</label>
					</td>
					<td>
						<input type="text" name="type" id="type" placeholder=" EX :6/4" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="matricule">Matricule</label>
					</td>
					<td>
						<input type="text" name="matricule" id="matricule" placeholder=" EX :55201-512-36" />
					</td>
				</tr>	

				<tr>
					<td>
						<label for="date_assurance">Date assurance</label>
					</td>
					<td>
						<input type="date" name="date_assurance" id="date_assurance1" class="date"/>
					</td>
				</tr>
				
				<tr>
					<td>
						<label for="date_vignette">Date vignette</label>
					</td>
					<td>
						<input type="date" name="date_vignette" id="date_vignette1" class="date"/>
					</td>
				</tr>

				<tr>
					<td>
						<label for="date_scanner">Date scanner</label>
					</td>
					<td>
						<input type="date" name="date_scanner" id="date_scanner1" class="date"/>
					</td>
				</tr>	

				<tr>
					<td>
						<label for="controle_technique">Controle technique</label>
					</td>
					<td>
						<input type="date" name="controle_technique" id="controle_technique1" class="date"/>
					</td>
				</tr>

				<tr>
					<td>
						<label for="prix_assurance">Prix assurance</label>
					</td>
					<td>
						<input type="text" name="prix_assurance" id="prix_assurance"/>
					</td>
				</tr>	

				<tr>
					<td>
						<label for="prix_vignette">Prix vignette</label>
					</td>
					<td>
						<input type="text" name="prix_vignette" id="prix_vignette" />
					</td>
				</tr>	

				<tr>
					<td>
						<label for="Prix_scanner">Prix scanner</label>
					</td>
					<td>
						<input type="text" name="prix_scanner" id="prix_scanner"/>
					</td>
				</tr>

				<tr>
					<td>
						<label for="prix_controle">Prix controle</label>
					</td>
					<td>
						<input type="text" name="prix_controle" id="prix_controle" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="nom_chauffeur">Nom chauffeur</label>
					</td>
					<td>
						<input type="text" name="nom_chauffeur" id="nom_chauffeur" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="paye_chauffeur">Paye chauffeur</label>
					</td>
					<td>
						<input type="text" name="paye_chauffeur" id="paye_chauffeur" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="paye_chauffeur">Date paye chauffeur</label>
					</td>
					<td>
						<input type="date" name="date_chauffeur" id="date_chauffeur" class="date" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="assurance_chauffeur">Prix assurance chauffeur</label>
					</td>
					<td>
						<input type="text" name="assurance_chauffeur" id="assurance_chauffeur" />
					</td>
				</tr>

				<tr>
					<td>
						<label for="date_assurance_chauffeur">Date assurance chauffeur</label>
					</td>
					<td>
						<input type="date" name="date_assurance_chauffeur" id="date_assurance_chauffeur" class="date" />
					</td>
				</tr>
				<tr>
					<td>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input class= "conex" style="vertical-align:top;" type="submit" value="enregistrer"/></td>
				</tr>	
				<tr>
					<td></td>
					<td><div class="reussi"></div></td>
				</tr>
			</table>
		</form>
	</div>

