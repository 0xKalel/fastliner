<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/messages_fr.js"></script>
<script>    
$(document).ready(function(){
	charger_projets();	
	$("#idprojets").change(function(){
		val=$("#idprojets").val()
		idprojet=$("#idprojets option:selected").attr("value");
		charger_nfr(val);
		charger_itineraires(idprojet)
	});
	$("#iditineraires").change(function(){
		iditineraire=$("#iditineraires option:selected").attr("value");
		charger_prix(iditineraire);
	})
	var Test_succee=false;
	$.validator.addMethod(
		"superieur",function(){
			var avance = $('#avance').val();
			var prix = $('#prix input').val();
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
			"idprojet":{
				"required": true,
			},
			"prix":{
				"number":true,
				"required": true,
			},
			"avance": {
				"number" : true,
				"superieur" : true,
			},
			"nfr": {
				"number" : true,
				"required" : true
			},
			"date": {
				exactlength: 10,
				"required": true
			},
			"matricule": {
				"required": true
			}
		},
		messages:{
			"date":{
				exactlength: "veuillez fournir une date valide"
			}
		}})
	$("#formulaire form").ajaxForm({
		beforeSubmit: function () {
			afficher_loader("#formulaire")
			return $("#formulaire #form").valid();
		},
		success: function (resultat) {
			if(resultat==1){
				afficher_nouvelle_ligne(resultat)
				charger_nfr(val);
				$("#nom").val('');
				$("#fichier").val('');
				$("#matricule").val('');
				$("#idproduit").val('');
				$("#n_document").val('');
				$("#observation").val('');
			}
			else
				alert(resultat)
			cacher_loader()
		}
	})
}) 
</script>
<div id="formulaire" >
	<form id="form" class="cmxform" method="post" enctype="multipart/form-data" action='ajax/enregistrement/ajaxpdf.php' >
		<table id="ajout_projets">
			<tr>
				<td>
					<label for="fichier">fichier</label>
				</td>
				<td>
					<input autocomplete="off" name="fichier" id="fichier" type="file" autocomplete="off" style="border:none;width:125px" title="<?php echo MESSAGE_FICHIER_ROUTES;?>" />
				</td>
			</tr>
			<tr>
				<td><label for="idprojet">Nom du projet</label></td>
				<td id ="idprojet"><select name="idprojet" id="idprojets"><option value=""></option> </select></td>
			</tr>
			<tr>
				<td><label for="iditineraire">Itineraire</label></td>
				<td id ="iditineraire"><select name="iditineraire" id="iditineraires" title="<?php echo MESSAGE_SELECTION_ITINERAIRE ;?>"><option value=""></option> </select></td>
			</tr>	
			<tr>
				<td>
					<label for="date">Date</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="date" id="date" class="date" value="<?php echo date("d/m/Y");?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="nom">Nom chauffeur</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="nom" id="nom" placeholder=" EX :gharbi ali" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="matricule">Matricule</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="matricule" id="matricule" placeholder="matricule du camion" />
				</td>
			</tr>	
			<tr>
				<td>
					<label for="nfr">N°FR</label>
				</td>
				<td id="nfrs">
					<input autocomplete="off" type="text" name="nfr" id="nfr" placeholder="numero de la feuille de route" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="prix">Prix</label>
				</td>
				<td id="prix">
					<input autocomplete="off" type="text" name="prix" id="prix" class="prix" placeholder="prix chauffeur de la rotation" />
				</td>
			</tr>	
			<tr>
				<td>
					<label for="id_produit">N°Produit</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="idproduit" id="idproduit" placeholder="numero du produit" />
				</td>
			</tr>		
			<tr>
				<td>
					<label for="poids">Poids</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="poids" id="poids" placeholder="poids chargé"/>
				</td>
			</tr>	
			<tr>
				<td>
					<label for="n_document">N°document</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="n_document" id="n_document" placeholder="EX: 89379838" />
				</td>
			</tr>	
			<tr>
				<td>
					<label for="avance">Avance</label>
				</td>
				<td>
					<input autocomplete="off" type="text" name="avance" id="avance" placeholder="avance versé au chauffeur" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="observation">observation</label>
				</td>
				<td>
					<textarea autocomplete="off" name="observation" id="observation" placeholder="remarques à propos de la feuille de route" ></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="observation">Réceptionné</label>
				</td>
				<td class="td_receptionne">
					<span>
						<label for="receptionne">Oui</label>
						<input type="radio" value="1" name="receptionne">
					</span>
					<span>
						<label for="receptionne">Non</label>
						<input type="radio" value="0" name="receptionne" checked>
					</span>
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
