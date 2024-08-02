<?php
	
$reference="php/";
include("php/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>Liste de routes</title>
	<meta charset="ANSI">
	<meta http-equiv="Content-Type" content="ANSI" />
	<meta name="author" content="mondersky" />
	<link rel="stylesheet" href="css/design.css?<?php echo date('l jS /of F Y h:i:s A'); ?>" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" />
	<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/date_fr.js"></script>
	<script type="text/javascript" src="js/autocomplete/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/notification/notification.js"></script>
	<script>
		var ordre_prec;
		var Sort="id",Ordre="DESC",Filtre,Interval_date={min:"0",max:"0"},Page=1,Nbr_page=15;
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
				var retour=true;  // l'utilisateur a cliqu?ur le meme titre
			else
				var retour=false; // l'utilisateur a cliqu?ur un titre different du titre pr?dent et donc r?nitialiser la fleche a d?oissant
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
		function charger_routes(sort,ordre,filtre,interval_date,page,fonction_supplementaire=0){
			var param={sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
			$.post("ajax/chargement/charger_routes.php",param,function(resultat){
				var resultat = jQuery.parseJSON(resultat);
				var routes="";
				for(var i=0;i<resultat.length;i++)
				{
					routes+="<tr  onClick='voir_feuille("+resultat[i].id+")'><td>"+resultat[i].nfr+"</td> <td> "+resultat[i].date+"</td> <td> "+resultat[i].nom+"</td> <td> "+resultat[i].matricule+"</td> <td> "+resultat[i].destination+"</td> <td> "+resultat[i].idproduit+"</td> <td> "+resultat[i].poids+"</td> <td> "+resultat[i].ndocument+"</td> <td> "+resultat[i].idavance+"</td><td> "+resultat[i].observation+"</td></tr>"; 
				}
				$("#tableau_routes tbody").html(routes);
				if(fonction_supplementaire!=0)
					fonction_supplementaire()
				$('.conteneur.Routes').show()
			})
			
		}
		function recharger_autocomplete(element,Lettre){
			var table="routes"
			var champ=$(element).next("select").find("option:selected").val();
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:champ,table:table},function(results){
				results=jQuery.parseJSON(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		function afficher_page(page){
		Page=page;
		var nom_table="routes"
			$.post("ajax/chargement/nbr_page.php",{nom_table:nom_table},function(resultat)
				{	var nbr_page = parseInt(jQuery.parseJSON(resultat));
					var test=parseFloat(jQuery.parseJSON(resultat)%15);
					if (test>0)
					{
					Nbr_page=parseInt(nbr_page/15)+1;
					}
					else Nbr_page=parseInt(nbr_page/15);
					afficher_pagination(Nbr_page);
					$("#pagination_page td[id="+page+"]").toggleClass("active")
					charger_routes(Sort,Ordre,Filtre,Interval_date,page);

				})
		}
	$(document).ready(function(){
notification();
		afficher_page(1);
			$("#filtre_1,#filtre_2,#filtre_3,#filtre_4,#filtre_5,#filtre_6").autocomplete().keyup(function(){
				Lettre=$(this).val();
				recharger_autocomplete(this,Lettre);
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
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".B option").click(function(){
			   var elem="B2";
			   var c=$(this);
			   reglage(elem,c);
			});
			$(".C option").click(function(){
			   var elem="C3";
			   var c=$(this);
			   reglage(elem,c);
			});$(".D option").click(function(){
			   var elem="D4";
			   var c=$(this);
			   reglage(elem,c);
			});$(".E option").click(function(){
			   var elem="E5";
			   var c=$(this);
			   reglage(elem,c);
			});$(".F option").click(function(){
			   var elem="F6";
			   var c=$(this);
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
			<a href="" class="lien_page active">Routes</a>
			<a href="etats" class="lien_page">Etats</a>
			<a href="projets" class="lien_page">Projets</a>
			<a href="camions" class="lien_page">Camions</a>
			<a href="chauffeurs" class="lien_page ">Chauffeurs</a>
			 <a href="#" id="notification" rel="#fond"></a>
		</div>
	</div>
	<div id="moteur">
		<form method="post" onSubmit="return false" id="form_filtre">
			<div class="bloc_fitres">
				<table id="Table-filter">
			<tr>
				<td>
				<div class="filtres">
					
					<input type="text" placeholder="Filtre 1" name="filtre_1" id="filtre_1"/>
					<select name="selection1" class="selections  A">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>" id="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
					}
						
					?>
					<option class="A1" value="0"></option>
					</select>
				</div>
				</td>
				<td>
				<div class="filtres">
					
					<input type="text" placeholder="Filtre 2" name="filtre_2" id="filtre_2"/>
					<select name="selection2" class="selections B">
					<?php
						foreach($champs as $cle=>$valeur)
						{
					?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>"><?php echo $valeur ?></option>
					<?php
						}
					?>
					<option class="B2" value="0"></option>
					</select>
				</div>
				</td>
				<td>
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
					<option class="C3"value="0"></option>
					</select>
				</div>
				</td>
				</tr>
				<tr>
				<td>
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
					<option class="D4" value="0"></option>
					</select>
				</div>
				</td>
				<td>
				
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
					<option class="E5"value="0"></option>
					</select>
				</div>
				</td>
				<td>
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
					<option class="F6"value="0"></option>
					</select>
				</div>
				</td>
				</tr>
			</table>
			</div>
			<div class="bloc_bouttons">
				<input type="text" id="date_min" name="date_min" placeholder="Date min" />
				<input type="text" id="date_max" name="date_max" placeholder="Date max" style="margin-right:100px" />
				<input type="submit" value="Filtrer" class="important"/>
				<button type="button" class="plus">+ajouter un filtre</button>
			</div>
		</form>
		<div id="ouvrir_formulaire">Ajouter<div></div></div>
	</div>
	<div id="formulaire_ajout">
		<?php require_once('ajouter_route.php'); ?>
	</div>
	<span id="cadre_pagination">
	<table id="pagination_page" style="float:top;color:black;padding:3px;">
			<thead>
			</thead>
	</table>
	</span>				
	<div class="conteneur Routes" style="display:none">			
	<?php
		//la boucle suivante prepare les variables et les securise
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
		</thead>
		<tbody>
		<?php
		/*$routes=$bdd->get_results('SELECT * FROM routes ORDER BY id DESC');
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
			}*/
			?>
			</tr>
		</tbody>
		</table>
		</form>
			<?php
		?>
	</div>
	<?php include("notification/notification.php"); ?>
</body>
<script>
</script>
</html>