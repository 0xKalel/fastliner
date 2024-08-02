<?php
	session_start();
	$reference="php/";
	include("php/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>Liste d'états</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="UTF-8" />
	<meta name="author" content="mondersky" />
	<link rel="stylesheet" href="css/design.css?<?php echo date('l jS /of F Y h:i:s A'); ?>" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" />
	<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/autocomplete/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/date_fr.js"></script>
	<script>
		var ordre_prec;
		var Sort="id",Ordre="DESC",Filtre,Interval_date={min:"0",max:"0"},Page=1;Lettre="";Champ="";filtres_caché=Array();	
		var champss=[<?php 
			foreach($champs_etats as $cle=>$valeur){
				echo "'$cle',";
			}?>]
		function ordre_routes(champs,ordre)
		{
			Sort=champs;
			Ordre=ordre;
			charger_routes(champs,ordre,Filtre,Interval_date,Page);
		}
		function voir_feuille(id)
		{
			window.open('route/'+id);
		}
		function reglage(elem,elem1){
				 $("."+elem).toggleClass(elem);
				$(elem1).toggleClass(elem);
			    var elem=$(elem1).val();
				sow_all();
		}
		function cacher(elem){
			var valeur=elem;
			if(valeur!="0"){
				$(".selections option#"+valeur).hide();
			}
		}
		function sow_all(elem){
				$(".selections option").show();  
				var m=$(".A1").val();
				cacher(m);							
				$(".A1").show();
				cacher($(".B2").val());
				$(".B2").show();
				cacher($(".C3").val());
				$(".C3").show();
				cacher($(".D4").val());
				$(".D4").show();
				cacher($(".E5").val());
				$(".E5").show();
				cacher($(".F6").val());
				$(".F6").show();
		}
	    function initialisation(element){
			if(ordre_prec==element)
				var retour=true;  // l'utilisateur a cliqué sur le meme titre
			else
				var retour=false; // l'utilisateur a cliqué sur un titre different du titre précedent et donc réeinitialiser la fleche a décroissant
			ordre_prec=element;
			$( ".croissant").toggleClass( "croissant" );
			$( ".decroissant").toggleClass( "decroissant" );
				$("#tableau_routes th.d").one("click",function(){
			})
			return retour;
		} 
		   
		function affiche(num){
		   var element=".ajous"+num;
		   $(element).show();
		   $("div "+element).toggleClass( "filtres" );
		   $(".plus").one("click",function(){
				press(num);
		   });
		}
		function press(num){
			if(num < 3){
				num = num+1;
				affiche(num);
			};
		};   
		function fleche_croissant(element){
			if(initialisation(element))
			{
				ordre_routes($(element).attr('id'),"ASC");
				$(element).toggleClass( "croissant" ).one("click",function(){
					fleche_decroissant(element)
				})	
			}
			else
			{
				ordre_routes($(element).attr('id'),"DESC");
				$(element).toggleClass( "decroissant" ).one("click",function(){
					fleche_croissant(element)
				})
			}
		}
		function fleche_decroissant(element){ 
			initialisation(element)
				ordre_routes($(element).attr('id'),"DESC");
				$(element).toggleClass( "decroissant" ).one("click",function(){
					fleche_croissant(element)
				})
		}
		function recharger_autocomplete(Lettre){
			var champ=$("input").next("select").find("option:selected").val();
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:champ},function(results){
				results=jQuery.parseJSON(results);
				alert(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		function charger_routes(sort,ordre,filtre,interval_date,page){
			var param={sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
			$.post("ajax/chargement/charger_routes.php",param,function(resultat){
				
				var resultat = jQuery.parseJSON(resultat);
				var routes="";
				var champ=$("input").next("select").find("option:selected").val();
				filtres_caché.push(champ); 
				Champ=champ
				var routes="";
				for(var i=0;i<resultat.length;i++)
				{
					var nfr= "<td id='nfr'>"+resultat[i].nfr+"</td>";
					for(var j=0,n=filtres_caché.length; j<n; j++)  {
						var element=$( "#"+filtres_caché[j]);
						
						
						
					
				}
				routes+="<tr  onClick='voir_feuille("+resultat[i].id+")'><td id='id' style='display: none;'>"+resultat[i].id+"</td>  <td id='date'> "+resultat[i].date+"</td> <td id='nom'> "+resultat[i].nom+"</td> <td id='matricule'> "+resultat[i].matricule+"</td> <td id='destination'> "+resultat[i].destination+"</td> <td id='idproduit'> "+resultat[i].idproduit+"</td> <td id='poids'> "+resultat[i].poids+"</td> <td id='ndocument'> "+resultat[i].ndocument+"</td> <td id='idavance'> "+resultat[i].idavance+"</td><td id='prix'> "+resultat[i].prix+"</td><td id='observation'> "+resultat[i].observation+"</td></tr>"; 
			}
				$("#tableau_routes tbody").html(routes);
				cacher_filtre()
              
			})
		}
		function afficher_page(page){
			Page=page;
			charger_routes(Sort,Ordre,Filtre,Interval_date,page);
		}

		function cacher_filtre(){
			var i=1;
			if(i==1)
			{
			var champ=Champ
			var champ2=$("table #"+champ);
			champ2.hide();
			
			var num=$(".filtres input").val()
			  
			$("#formulaire_ajout").append("<h2 style='position:absolute;height:80px;width:200px;float:bottom;margin-left:600px'>listes d'etats pour "+champ+"-"+num+"</h2>")
			i++;
			
			}else
			{
			i=i+1;
			cacher_filtre();
			}
		}
		$(document).ready(function(){
		$("input").autocomplete().keyup(function(){
				Lettre=$("input").val();
				recharger_autocomplete(Lettre);
			})
		$("#pagination-flickr span").click(function(){
				page=$(this).attr("ids");
				afficher_page(page);
				
				})
		
			$(".bloc_bouttons input:text").datepicker();
			$("#tableau_routes th.d").one("click",function(){
				fleche_decroissant(this)
			})
			$("#form_filtre").submit(function(){
				var filtre=[]
				var champs_remplis=0;
				$(".bloc_fitres input:text").each(function(){
					var valeur=$(this).val();
					if(valeur!="")
					{
						var element={};
						var champ=$(this).next("select").find("option:selected").val();
						element[champ]=valeur;
						filtre.push(element)
					} 
				})
				Filtre=filtre;
				page=Page;
				Interval_date={min:$("#date_min").val(),max:$('#date_max').val()}
				charger_routes(Sort,Ordre,Filtre,Interval_date,page);
				
				return false;
			})
			$(".plus").one("click",function(){	
				affiche(1);
			});
			$(".A option").click(function(){
			   var elem="A1";
			   c=$(this);
			   reglage(elem,c);
			});
			$(".B option").click(function(){
			   var elem="B2";
			   c=$(this);
			   reglage(elem,c);
			});
			$(".C option").click(function(){
			   var elem="C3";
			   c=$(this);
			   reglage(elem,c);
			});$(".D option").click(function(){
			   var elem="D4";
			   c=$(this);
			   reglage(elem,c);
			});$(".E option").click(function(){
			   var elem="E5";
			   c=$(this);
			   reglage(elem,c);
			});$(".F option").click(function(){
			   var elem="F6";
			   c=$(this);
			   reglage(elem,c);
			});
			$(".A #nfr").attr("selected","selected");
			$(".B #date").attr("selected","selected");
			$(".C #nom").attr("selected","selected");
			$(".D #matricule").attr("selected","selected");
			$(".E #destination").attr("selected","selected");
			$(".F #idproduit").attr("selected","selected");
		});
	</script>

</head> 
<body>
	<div id="entete">
		<div id="entete_contenu">
			<a href="routes" class="lien_page">Routes</a>
			<a href="" class="lien_page active">Etats</a>
			<a href="projets" class="lien_page">Projets</a>
		</div>
	</div>
	<div id="moteur" class="etats">
		<form method="post" onSubmit="return false" id="form_filtre">
			<div class="bloc_fitres">
				<div class="filtres">
					<input type="text" placeholder="Filtre" name="filtre_1" id="filtre_1"/>
					<select name="selection1" class="selections  A">
					<?php
						foreach($champs_etats as $cle=>$valeur)
						{
						?>
							<option id="<?php echo $cle ?>" value="<?php echo $cle ?>" id="<?php echo $cle ?>"><?php echo $valeur ?></option>
						<?php
						}
					?>
					</select>
				</div>
				
			<div class="bloc_bouttons">
				<input type="text" id="date_min" name="date_min" placeholder="Date min" />
				<input type="text" id="date_max" name="date_max" placeholder="Date max" style="margin-right:100px" />
				<input type="submit" value="Filtrer" class="important"/>
			</div>
			</div>
		</form>
		<div id="ouvrir_formulaire">Ajouter<div></div></div>
	</div>
	<div id="formulaire_ajout">
		<?php require_once('ajouter_projet.php'); ?>
	</div>
	<div class="conteneur Routes">
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
			foreach($champs_etats as $cle=>$valeur)
				{
				?>
					<th class="d" id="<?php echo $cle ?>"><?php echo $valeur ?></th>
				<?php
				}
		?>
			<!-- champs observation a prévoir -->
		</thead>
		<tbody>
		<?php
		$routes=$bdd->get_results('SELECT * FROM routes ORDER BY id DESC');
		if(count($routes))
			foreach($routes as $r)
			{
					foreach($r as $cle=>$valeur)
					{
						$$cle=securiser($valeur);
					}
			?>
			<tr onClick="voir_feuille(<?php echo $id ?>)">	
						<td id="nfr"><?php
							echo $nfr;
						?></td>
							<td id="date"><?php
							echo $date;
						?></td>
							<td id="nom"><?php
							echo $nom;
						?></td>
							<td id="matricule"><?php
							echo $matricule;
						?></td>
							<td id="destination"><?php
							echo $destination;
						?></td>
							<td id="idproduit"><?php
							echo $idproduit;
						?></td>
							<td id="poids"><?php
							echo $poids;
						?></td>
							<td id="ndocument"><?php
							echo $ndocument;
						?></td>
							<td id="idavance"><?php
							echo $idavance;
						?></td>
							<td id="prix"><?php
							echo $prix;
						?></td>
							<td id="observation"><?php
							echo $observation;
						?></td>
			<?php
			}
			?>
			</tr>
		</tbody>
		</table>
		</form>
			<?php
		?>
	</div>
</body>
<script>
</script>
</html>