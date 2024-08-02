<?php
	$cle_actuelle="debits";
	$reference="php/";
	include("php/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>Liste de debits</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="UTF-8" />
	<meta name="author" content="mondersky" />
	<link rel="stylesheet" href="css/design.css?<?php echo date('l jS /of F Y h:i:s A'); ?>" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" />
	<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/autocomplete/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/date_fr.js"></script>
	<script type="text/javascript" src="js/notification/notification.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script>
		var changement=0, k=0,champs=" ",champs_slectionne=" ",str="",ordre_prec;
		var Cle_actuelle='<?php echo $cle_actuelle; ?>',Sort="id",Ordre="DESC",Filtre,Interval_date={min:"0",max:"0"},Page=1;Lettre="";Champ="";filtres_cache=Array();	
		function charger_elements(sort,ordre,filtre,interval_date,page){
			var param={cle_actuelle:Cle_actuelle,sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
			afficher_loader()
			$.post("ajax/chargement/charger_elements.php",param,function(resultat){
				var resultat = jQuery.parseJSON(resultat);
				var chauffeurs="";
				Champ=$("input").next("select").find("option:selected").val();
				filtres_cache.push(Champ); 
				for(var i=0; i<resultat.length; i++) {
					chauffeurs+="<tr  onClick='voir_feuille("+resultat[i].id+")'>";
							var id="<td id='id' style='display: none;'>"+resultat[i].id+"</td>";
							var nom="<td id='nom'> "+resultat[i].nom+"</td>";
							var avance="<td id='date'> "+resultat[i].date+"</td>";
							var date="<td id='somme'> "+resultat[i].somme+"</td>";
								if($(filtre_1).val().length>0){
	                        	for(var j=0;j<filtres_cache.length;j++)  {
						
						if( filtres_cache[j]=="name")				nom="<td style='display: none' id='name'> "+resultat[i].nom+"</td>";
						if( filtres_cache[j]=="avance")				avance="<td style='display: none' id='avance'> "+resultat[i].date+"</td>";
						if( filtres_cache[j]=="date")			date="<td style='display: none' id='matricule'> "+resultat[i].somme+"</td>"
								}
						}
							chauffeurs+=id+nom+avance+date
						chauffeurs+="</tr>";
				}
				$("#tableau_routes tbody").html(chauffeurs);
				cacher_loader()
			})
		}
		function afficher_pagination(nombre_pages)
		{ 
			var P=[""];
			var a=5;
			var n=1;
			Nbr_page=nombre_pages;
			for(var i=parseInt(-(a/2));i<=(a/2);i++)
				{	
					if(((Page + i)>0)&&((Page + i) <= Nbr_page)) 
					{
						var t=Page+i;
						P[n]=t;
						n++;
					}
				}
			$("#pagination_page thead").html("");
				$("#pagination_page thead").append("<td id='1'><span ids='1'>Premier</span></td>");
			for (var i=1;i<P.length;i++)
			{
				$("#pagination_page thead").append("<td id='"+P[i]+"'><span ids='"+P[i]+"'>"+P[i]+"</span></td>");	
			}
			$("#pagination_page thead").append("<td id='"+Nbr_page+"'><span ids='"+Nbr_page+"'>Dernier</span></td>");
			$("#pagination_page thead span").click(function(){
				PAGE=parseInt($(this).attr("ids"));
				afficher_page(PAGE);
			})			
		}
	    
		function recharger_autocomplete(Lettre){
			var champ=$("input").next("select").find("option:selected").val();
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:champ,table:Cle_actuelle},function(results){
				results=jQuery.parseJSON(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		function recharger_autocomplete_chauffeur(Lettre){
			var nom="nom_chauffeur";
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:nom,table:Cle_actuelle},function(results){
				results=jQuery.parseJSON(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		/*function afficher_page(page){
			Page=page;
			charger_elements(Sort,Ordre,Filtre,Interval_date,page);
		}*/
		function cacher_filtre(){
			var champ2=$("table #"+Champ);
			champ2.hide();
			var nom=$('#filtre_1').val()
			$(".filtres input").html(
				$("#filtre_1").val()
				)
			if( champs_slectionne==" " ){champs_slectionne+=Champ+" : "+nom;
			}else{
			
			champs_slectionne+=" et "+Champ+" : "+nom;}
			$("#entete_tableau").html("<h2 style='text-align: center; width: 100%;' >listes des prets pour "+champs_slectionne+"</h2>")
		}

		

		$(document).ready(function(){
			$("#filtre_1").autocomplete().keyup(function(){
				Lettre=$(this).val();
				recharger_autocomplete(Lettre);
			})
		});
	</script>


</head> 
<body>
<div id="conteneur">
		
	<?php include("php/entete.php"); ?>
	<div id="moteur" class="etats">
		<form method="post" onSubmit="return false" id="form_filtre">
			<div class="bloc_fitres">
				<table id="Table-filter">
					<tr>
						<td>
						</td>
						<td>
							<div class="filtres">
								<input type="text" placeholder="Filtre" name="filtre_1" id="filtre_1"/>
								<select name="selection1" class="selections  A">
								<option id="defaut"></option>
								<?php
									foreach($liste_champs[$cle_actuelle] as $cle=>$valeur)
									{
									?>
										<option id="<?php echo $cle ?>" value="<?php echo $cle ?>" id="<?php echo $cle ?>"><?php echo $valeur ?></option>
									<?php
									}
								?>
								</select>
							</div>
						</td>
					</tr>	
						<tr>
							<td>
								<div class="bloc_bouttons">
									<input id="btnFiltrer" type="submit" value="Filtrer" class="important"/>
								</div>
								<?php include("php/filtre_date.php"); ?>
							</td>
						</tr>
				</table>
			</div>			
		</form>
	</div>
	<div id="formulaire_ajout">
		<?php require_once('ajouter_debits.php'); ?>
	</div>
	<div id="space">
	</div>
	<div id="ouvrir_formulaire" >
		Ajouter
	</div>



	
	<div class="conteneur Routes" >
		
		<?php
		//la boucle suivante prepare les variables et les securis
		foreach($_POST as $key=>$value)
		{
			$$key=securiser($value);
		}
		?>
		<form>
		<table id="tableau_routes">
		<thead>
		       
		<?php
			foreach($liste_champs[$cle_actuelle] as $cle=>$valeur)
				{
				?>
					<th class="d" id="<?php echo $cle ?>"><?php echo $valeur ?></th>
				<?php
				}
		?>
			<!-- champs observation a pr?voir -->
		</thead>
		<tbody id="tab">
		<?php
		/*$routes=$bdd->get_results('SELECT * FROM Chauffeurs ORDER BY id DESC');
		if(count($routes))
			foreach($routes as $r)
			{
					foreach($r as $cle=>$valeur)
					{
						$$cle=securiser($valeur);
					}
			?>
			<tr >	
						<td id="nom"><?php
							echo $nom;
						?></td>						
						<td id="paye"><?php
							echo $paye;
						?></td>
							<td id="matricule"><?php
							echo $matricule;
						?></td>
							
							
			<?php
			}*/
			?>
			</tr>
		</tbody>
		</table>
		<?php include("php/pagination.php"); ?>
		</form>
	</div>

</div>
	<?php include("notification/notification.php"); ?>
</body>
<script>
</script>
</html>