<?php
	session_start();
	$reference="php/";
	include("php/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>home</title>
	 <meta charset="ANSI">
	<meta http-equiv="Content-Type" content="ANSI" />
	<meta name="author" content="mondersky" />
	<link rel="stylesheet" href="css/design.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script>
		var ordre_prec;
		var Sort="id",Ordre="DESC",Filtre;
		function ordre_routes(champs,ordre)
		{
			Sort=champs;
			Ordre=ordre;
			charger_routes(champs,ordre,Filtre);
		}
		function voir_feuille(id)
		{
			window.open('route/'+id);
		}
		function filtrer_routes(filtre)
		{
			Filtre=filtre;
			charger_routes(Sort,Ordre,Filtre);
		}
		function reglage(elem,elem1){
				$(elem).toggleClass(elem);
				$(elem1).toggleClass(elem);
			    elem=$(elem1).val();
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
		function charger_routes(sort,ordre,filtre){
			var param={sort:sort,ordre:ordre,filtre:filtre};
			$.post("ajax/chargement/charger_routes.php",param,function(resultat){
				var resultat = jQuery.parseJSON(resultat);
				var routes="";
				for(var i=0;i<resultat.length;i++)
				{
					routes+="<tr  onClick='voir_feuille("+resultat[i].id+")'><td>"+resultat[i].id+"</td> <td>"+resultat[i].nfr+"</td> <td> "+resultat[i].date+"</td> <td> "+resultat[i].nom+"</td> <td> "+resultat[i].matricule+"</td> <td> "+resultat[i].destination+"</td> <td> "+resultat[i].idproduit+"</td> <td> "+resultat[i].poids+"</td> <td> "+resultat[i].ndocument+"</td> <td> "+resultat[i].idavance+"</td><td> "+resultat[i].observation+"</td></tr>"; 
				}
				$("#tableau_routes tbody").html(routes);
			})
		}
		$(document).ready(function(){
			$("#tableau_routes th.d").one("click",function(){
				fleche_decroissant(this)
			})
			$("#form_filtre").submit(function(){
				var filtre=[]
				var champs_remplis=0;
				$("#form_filtre input:text").each(function(){
					var valeur=$(this).val();
					if(valeur!="")
					{
						var element={};
						var champ=$(this).next("select").find("option:selected").val();
						element[champ]=valeur;
						filtre.push(element)
					} 
				})
				filtrer_routes(filtre)	
				return false;
			})
			$(".plus").one("click",function(){	
				affiche(1);
			});
			$(".selection_1 option").click(function(){
			   elem=$(this).parent().find(".option_initiale");
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".selection_2 option").click(function(){
			   elem=$(this).parent().find(".option_initiale");
			   console.log($(elem).attr("class"));
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".C option").click(function(){
			   elem=$(this).parent().find(".option_initiale");
			   console.log($(elem).attr("class"));
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".D option").click(function(){
			   elem=$(this).parent().find(".option_initiale");
			   console.log($(elem).attr("class"));
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".E option").click(function(){
			   elem=$(this).parent().find(".option_initiale");
			   console.log($(elem).attr("class"));
			   var c=$(this);
			   reglage(elem,c);
			});$(".F option").click(function(){
			   elem=$(this).parent().find(".option_initiale");
			   console.log($(elem).attr("class"));
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".selection_1 #nfr").attr("selected","selected");
			$(".selection_2 #date").attr("selected","selected");
			$(".C #nom").attr("selected","selected");
			$(".D #matricule").attr("selected","selected");
			$(".E #destination").attr("selected","selected");
			$(".F #idproduit").attr("selected","selected");
		});
	</script>

</head> 
<body>
	<div id="moteur">
		<form method="post" onSubmit="return false" id="form_filtre">
			<div class="bloc_fitres">
				<div class="filtres">
					
					<input type="text" placeholder="Filtre 1" name="filtre_1" id="filtre_1"/>
					<select name="selection1" class="selections  selection_1">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>" id="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="option_initiale A1" value="0"></option>
					</select>
				</div>
				<div class="filtres">
					
					<input type="text" placeholder="Filtre 2" name="filtre_2" id="filtre_2"/>
					<select name="selection2" class="selections selection_2">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="option_initiale B2" value="0"></option>
					</select>
				</div>
				<div class="filtres">
					
					<input type="text" placeholder="Filtre 3" name="filtre_3" id="filtre_3"/>
					<select name="selection3" class="selections C">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="option_initiale C3"value="0"></option>
					</select>
				</div>
				<div class="ajous1" style="display:none">
					
					<input type="text" placeholder="Filtre 4" name="filtre_4" id="filtre_4"/>
					<select name="selection4" class="selections  D">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="option_initiale D4" value="0"></option>
					</select>
				</div>
				
				
				<div  class="ajous2" style="display:none">
				
					<input type="text" name="filtre_5" placeholder="Filtre 5" id="filtre_5"/>
					<select name="selection5" class="selections E">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="option_initiale E5" value="0"></option>
					</select>
				</div>
				<div class="ajous3" style="display:none">
					
					<input type="text" name="filtre_6" placeholder="Filtre 6"id="filtre_3"/>
					<select name="selection6" class="selections F">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="option_initiale F6"value="0"></option>
					</select>
				</div>
			</div>
			<div class="bloc_bouttons">
				<input type="submit" value="Filtrer" />
				<button type="button" class="plus">+ajouter un filtre</button>
			</div>
		</form>
	    
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
			foreach($champs as $cle=>$valeur)
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
						<td><?php
							echo $id;
						?></td>
						<td><?php
							echo $nfr;
						?></td>
							<td><?php
							echo $date;
						?></td>
							<td><?php
							echo $nom;
						?></td>
							<td><?php
							echo $matricule;
						?></td>
							<td><?php
							echo $destination;
						?></td>
							<td><?php
							echo $idproduit;
						?></td>
							<td><?php
							echo $poids;
						?></td>
							<td><?php
							echo $ndocument;
						?></td>
							<td><?php
							echo $idavance;
						?></td>
							<td><?php
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