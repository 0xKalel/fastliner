<div id="cadre_modification" class="fond_noir">
	<div id="conteneur_modification" class="conteneur_lightbox">
		<form id="form_modif" method="post" action='ajax/enregistrement/modifier_element.php' >

			<a href="javascript:" class="bouton_fermer" title="<?php echo MESSAGE_FERMER_FENETRE;?>"></a>
			<?php 
			switch ($cle_actuelle) {
				case 'projets':
				{
					$titre="Modifications pour le projet ";
					break;
				}
				case 'routes':
				{
					$titre="Modifications pour la &nbsp Nfr° ";
					break;
				}
				case 'vehicules':
				{
					$titre="Modifications pour le vehicule ";
					break;
				}
				case 'chauffeurs':
				{
					$titre="Modifications pour le chauffeur ";
					break;
				}
				case 'dettes_personnel':
				{
					$titre="Modifications pour la dette ";
					break;
				}
				case 'creances_personnel':
				{
					$titre="Modifications pour la créance ";
					break;
				}
			}
			?>
			<h3 style="text-align: center;color:rgb(200, 200, 200)"><?php echo $titre ?><span class="valeur_nfr"></span></h3>
			<br>
			<input type="hidden" name="id">
			<input type="hidden" name="cle_actuelle" value="<?php echo $cle_actuelle ?>">
			<table>
				<?php 
				switch ($cle_actuelle) {
					case 'projets':
					{
						?>
						<tr>
							<td><label for="projet">Nom du projet</label></td>
							<td>
								<input class="input"  type="text" name="projet" placeholder="" />
								<input type="hidden" name="ancien_projet" />
							</td>
						</tr>	

						<tr>
							<td><label for="client">Nom du client</label></td>
							<td><input class="input"  type="text" name="client" placeholder="" /></td>
						</tr>
<!-- 
						<tr>
							<td><label for="depart">Depart</label></td>
							<td><input class="input"  type="text" name="depart"  placeholder="" /></td>
						</tr>	

						<tr>
							<td><label for="destination">Destination</label></td>
							<td><input class="input"  type="text" name="destination"  placeholder="" /></td>
						</tr> -->

						<tr>	
							<td><label for="prix">Prix</label></td>
							<td><input class="input"  type="text" name="prix" placeholder=" " /></td>
						</tr>

						<tr>	
							<td><label for="date">Date</label></td>
							<td><input class="input"  type="date" name="date" placeholder=" " /></td>
						</tr>

						<tr>	
							<td><label for="observation">observation</label></td>
							<td><textarea name="observation" class="input"></textarea></td>
						</tr>
						<?php
			    		# code...
						break;
					}
					case 'chauffeurs':
					{
						?>
						<tr>
							<td><label for="nom_chauffeur">Nom Chauffeur</label></td>
							<td><input type="text" name="nom_chauffeur"  placeholder="" class="input"/>
								<input type="hidden" name="ancien_nom" /></td>
							</tr>	
							
							<tr>
								<td><label for="paye_chauffeur">Paye</label></td>
								<td><input type="text" name="paye_chauffeur" placeholder=""  class="input"/></td>
							</tr>	

							<tr>
								<td><label for="date_chauffeur">date paye</label></td>
								<td><input type="date" name="date_chauffeur" class="date input" /></td>
							</tr>

							<tr>
								<td><label for="assurance">Assurance</label></td>
								<td><input type="text" name="assurance_chauffeur"  class="input"/></td>
							</tr>

							<tr>
								<td><label for="date_assurance">date Assurance</label></td>
								<td><input type="date" name="date_assurance_chauffeur" class="date input" /></td>
							</tr>
							<?php
							break;
						}
						case 'routes':
						{
							?>
							<tr>
								<td>
									<label for="fichier">fichier</label>
								</td>
								<td style="position:relative;line-height:37px">
									<span class="nom_fichier elements_fichier"></span>
									<a href="javascript:" class="icone_changer"></a>
									<input autocomplete="off" name="fichier" type="file" class="fichier elements_fichier cache" autocomplete="off" style="border:none;width:125px" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="idprojet">Nom du projet</label>
								</td>
								<td id ="idprojet">
									<select name="idprojet" id="idprojets" class="input idprojets"><option value=""></option> </select>
									<input type="hidden" name="ancien_nfr" />
									<input type="hidden" name="ancien_idprojet" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="iditineraire">Itineraire</label>
								</td>
								<td id ="iditineraire">
									<select name="iditineraire" id="iditineraires" class="input iditineraires"><option value=""></option> </select>
									<input type="hidden" name="ancien_nfr" />
									<input type="hidden" name="ancien_idprojet" />
								</td>
							</tr>	
							<tr>
								<td>
									<label for="date">Date</label>
								</td>
								<td>
									<input autocomplete="off" type="text" name="date" class="date input" value=""/>
								</td>
							</tr>

							<tr>
								<td>
									<label for="nom">Nom chauffeur</label>
								</td>
								<td>
									<input autocomplete="off" type="text" name="nom" class="input" placeholder=" EX :gharbi ali" />
								</td>
							</tr>

							<tr>
								<td>
									<label for="matricule">Matricule</label>
								</td>
								<td>
									<input autocomplete="off" type="text" name="matricule" class="input" placeholder=" EX :55201-512-36" required/>
								</td>
							</tr>	


							<tr>
								<td>
									<label for="nfr">N°FR</label>
								</td>
								<td id="nfrs">
									<input autocomplete="off" type="text" name="nfr"  class="input" placeholder=" EX :367" />
								</td>
							</tr>

							<tr>
								<td>
									<label for="prix">Prix</label>
								</td>
								<td id="prix">
									<input autocomplete="off" type="text" name="prix"  class="input" placeholder= />
								</td>
							</tr>	

							<tr>
								<td>
									<label for="id_produit">N°Produit</label>
								</td>
								<td>
									<input autocomplete="off" type="text" name="idproduit"  class="input" placeholder=" EX :32" />
								</td>
							</tr>	

							<tr>
								<td>
									<label for="poids">Poids</label>
								</td>
								<td>
									<input autocomplete="off" type="text" name="poids"  class="input" placeholder=" EX :40T"/>
								</td>
							</tr>	

							<tr>
								<td>
									<label for="ndocument">N°document</label>
								</td>
								<td>
									<input autocomplete="off" type="text" name="ndocument" class="input" placeholder=" EX :89379838" />
								</td>
							</tr>	

							<tr>
								<td>
									<label for="observation">observation</label>
								</td>
								<td>
									<textarea autocomplete="off" name="observation" class="input" ></textarea>
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
										<input type="radio" value="0" name="receptionne" >
									</span>
								</td>
							</tr>
							<?php
							break;
						}
						case 'vehicules':
						{
							?>
							<tr>
								<td>
									<label for="nom">Marque</label>
								</td>
								<td>
									<input class="input" type="text" name="marque"  placeholder="EX :gharbi ali" />
									<input type="hidden" name="ancien_matricule" />
								</td>
							</tr>

							<tr>
								<td>
									<label for="type">Type</label>
								</td>
								<td>
									<input class="input" type="text" name="type" placeholder=" EX :6/4" />
								</td>
							</tr>

							<tr>
								<td>
									<label for="matricule">Matricule</label>
								</td>
								<td>
									<input class="input" type="text" name="matricule"placeholder=" EX :55201-512-36" />
								</td>
							</tr>	

							<tr>
								<td>
									<label for="date_assurance">Date assurance</label>
								</td>
								<td>
									<input class="input date" type="text" name="date_assurance" class="date"/>
								</td>
							</tr>

							<tr>
								<td>
									<label for="date_vignette">Date vignette</label>
								</td>
								<td>
									<input class="input date" type="text" name="date_vignette" class="date"/>
								</td>
							</tr>

							<tr>
								<td>
									<label for="date_scanner">Date scanner</label>
								</td>
								<td>
									<input class="input date" type="text" name="date_scanner" class="date"/>
								</td>
							</tr>	

							<tr>
								<td>
									<label for="controle_technique">Controle technique</label>
								</td>
								<td>
									<input class="input date" type="text" name="controle_technique" class="date"/></td>
								</tr>

								<tr>
									<td>
										<label for="prix_assurance">Prix assurance</label>
									</td>
									<td>
										<input class="input" type="text" name="prix_assurance" />
									</td>
								</tr>	

								<tr>
									<td>
										<label for="prix_vignette">Prix vignette</label>
									</td>
									<td>
										<input class="input" type="text" name="prix_vignette"  />
									</td>
								</tr>	

								<tr>
									<td>
										<label for="Prix_scanner">Prix scanner</label>
									</td>
									<td>
										<input class="input" type="text" name="prix_scanner" />
									</td>
								</tr>

								<tr>
									<td>
										<label for="prix_controle">Prix controle</label>
									</td>
									<td>
										<input class="input" type="text" name="prix_controle"  />
									</td>
								</tr>


								<?php
								break;
							}
							default:
							break;
							case 'dettes_personnel':
							{
								?>
								<tr>
									<td><label for="client">Nom</label></td>
									<td><input type="text" name="nom"   class="input" placeholder="" /></td>
								</tr>	

								<tr>
									<td><label for="objet">Objet</label></td>
									<td><input type="text" name="objet"   class="input" placeholder="" /></td>
								</tr>	


								<tr>
									<td><label for="date">date</label></td>
									<td><input type="text" name="date"   class="input date" placeholder="EX : 1983-12-17" /></td>
								</tr>	

								<tr>
									<td><label for="somme">somme </label></td>
									<td><input type="text" name="somme"  class="input" placeholder="" /></td>
								</tr>	
								<?php
							}
							break;
							case 'creances_personnel':
							{
								?>
								<tr>
									<td><label for="client">Nom </label></td>
									<td><input type="text" name="nom" class="input" placeholder="" /></td>
								</tr>	

								<tr>
									<td><label for="objet">Objet</label></td>
									<td><input type="text" name="objet" class="input" placeholder="" /></td>
								</tr>	


								<tr>
									<td><label for="date">date</label></td>
									<td><input type="text" name="date"  class="input" placeholder="EX : 1983-12-17" class="date"/></td>
								</tr>	

								<tr>
									<td><label for="somme">somme </label></td>
									<td><input type="text" name="somme" class="input" placeholder="" /></td>
								</tr>	
								<?php
							}
							break;
						}
						?>

						<tr>
							<td></td>
							<td><input style="vertical-align:top;width:100%" type="submit" value="modifier" class="bouton_orange" /></td>
						</tr>	
					</table>
				</form>
			</div>
		</div>		
		<script type="text/javascript">
		function charger_anciennes_informations(id_element){
			var param={id:id_element,cle_actuelle:Cle_actuelle};
			$.post("ajax/chargement/charger_anciennes_informations.php",param,function(resultat){
				var resultat = jQuery.parseJSON(resultat);
				if(Champs_complets.length>0){
					if((Cle_actuelle=="creances_personnel")||(Cle_actuelle=="dettes_personnel"))
					{
						avances=resultat["avances"];
					}else
					if((Cle_actuelle=="routes")||(Cle_actuelle=="projets"))
					{
						avances=resultat["avances"];
					}
					for(j=0;j<Champs_complets.length;j++){
						$("#cadre_modification [name='"+Champs_complets[j]+"']").val(resultat[Champs_complets[j]])
					}
					switch(Cle_actuelle){
						case("routes"):
						{
							$("#cadre_modification .td_receptionne input[value='"+resultat["receptionne"]+"']").attr("checked","")
							$("#cadre_modification [name='ancien_nfr']").val(resultat["nfr"]);
							$("#cadre_modification [name='ancien_idprojet']").val(resultat["idprojet"]);
							charger_itineraires(resultat['idprojet'],function(){
								$("#cadre_modification [name='iditineraire']").val(resultat["iditineraire"])
							})
							break;
						}
						case("projets"):
						{
							$("#cadre_modification [name='ancien_projet']").val(resultat["projet"]);
							break;
						}
						case("vehicules"):
						{
							$("#cadre_modification [name='ancien_nom']").val(resultat["nom_chauffeur"]);
							$("#cadre_modification [name='ancien_matricule']").val(resultat["matricule"]);
							break;
						}
						case("chauffeurs"):
						{
							$("#cadre_modification [name='ancien_nom']").val(resultat["nom_chauffeur"]);
							break;
						}
					}
				}
				else
					switch(Cle_actuelle){
						case("routes"):
						{
							alert("Impossible de charger la feuille de route")
							break;
						}
						case("projets"):
						{
							alert("Impossible de charger les informations du projet")
							break;
						}
						case("vehicules"):
						{
							alert("Impossible de charger les informations du camion")
							break;
						}
						case("chauffeurs"):
						{
							alert("Impossible de charger les informations du chauffeur")
							break;
						}
					}
				})
}

$(document).ready(function(){
	switch(Cle_actuelle){
		case("routes"):{
			$("#form_modif").validate({
				rules: {
					"idprojet":{
						"required": true,
					},
					"iditineraire":{
						"required":true,
					},
					"prix":{
						"required": true,
						"number":true,
						"test_avance":true,
					},
					"nfr": {
						"required" : true,
						"number":true
					},
					"date":{
						exactlength: 10,
						"required" : true,
					}
				},
				messages:{
					"date" : {
						exactlength: "veuillez saisir une date valide."
					}
				}
			})
			$(".icone_changer").click(function(){
				$(".elements_fichier").toggleClass("cache");
			})
		}
		break;
		case("chauffeurs"):{
			$("#form_modif").validate({
				rules: {
					"nom_chauffeur":{
						"required": true,
						"minlength": 4,
					},
					"paye_chauffeur": {
						"required": true,
						"maxlength": 55,
						'number':true,
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
						"required": true,
						"number":true
					},  

				},
			})
		}
		break;
		case("vehiules"):{
			$("#form_modif").validate({
				rules: {
					"nom":{
						"required": true,
						"minlength": 4,
					},
					"matricule": {
						"required": true,
						"maxlength": 55
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
					"prix_assurance": {
						"required": true,
						"number":true,
					},
					"prix_scanner": {
						"required": true,
						"number":true,
					},
					"prix_vignette": {
						"required": true,
						"number":true,
					},
					"prix_controle": {
						"required": true,
						"number":true,
					},
					

				},
			})
		}
		break;
		case("projets"):{
			$("#form_modif").validate({
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
						"test_avance":true,
					},  
					"projet": {
						"required": true
					},  
					"date": {
						"required": true,
						exactlength: 10
					},         

				},
				messages:{
					"date":{
						exactlength: "veuillez fournir une date valide"
					}
				},
				errorPlacement: function(error, element) {
					error.insertBefore(element);
				}
			})
		}
		break;
		case("dettes_personnel"):{
			$("#form_modif").validate({
				rules: {
					"nom":{
						"required": true,
						"minlength": 4,
					},
					"date":{
						"exactlength": 10,
						"required":true,
					},
					"somme":{
						"number": true,
						"required":true,
						"test_avance":true,
					},
				}
			})
		}
		break;
		case("creances_personnel"):{
			$("#form_modif").validate({
				rules: {
					"nom":{
						"required": true,
						"minlength": 4,
					},
					"date":{
						"exactlength": 10,
						"required":true,
					},
					"somme":{
						"number": true,
						"required":true,
						"test_avance":true,
					},

				}
			})
		}
		break;
	}
	$("#conteneur_modification #idprojets").change(function(){
		val=$("#conteneur_modification .idprojets").val()
		charger_nfr(val);
		charger_prix(val);
		idprojet=$("#conteneur_modification #idprojets option:selected").attr("value");
		charger_itineraires(idprojet);
	});
	$("#cadre_modification").hide().css("visibility","visible");
	$("#cadre_modification input[name='date'],#cadre_modification input.date").datepicker();
	$("#cadre_modification .bouton_fermer").click(function(){
		$("#cadre_modification").fadeOut(200)
		$("#form_modif").get(0).reset()
		// $("#cadre_modification input[typr=g")
	});
	$("#cadre_modification form").ajaxForm({
		beforeSubmit: function () {
			return $("#formulaire #form").valid();  	
		},
		success: function (resultat) {
			if(resultat==1){
				$("#cadre_modification").fadeOut(200);
				$("#form_modif").get(0).reset()
				afficher_page(Page);
			}
			else
				alert(resultat);
		}
	})
})
</script>