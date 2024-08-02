<?php
	
	$reference="php/";
	include("php/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>Liste des chauffeurs</title>
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
	<script>
	var changement=0;
	var k=0;
	var champ;
	    var champs=" ";

	var champs_slectionné=" ";
	var str="";
		var ordre_prec;
		var Sort="id",Ordre="DESC",Filtre,Interval_date={min:"0",max:"0"},Page=1;Lettre="";Champ="";filtres_caché=Array();Page=1,Nbr_page=5;	

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
		
		function ordre_routes( champs,ordre )
		{
			Sort=champs;
			Ordre=ordre;
			charger_routes(champs,ordre,Filtre,Interval_date,Page);
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
			var table="avances"
			var champ=$("input").next("select").find("option:selected").val();
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:champ,table:table},function(results){
				results=jQuery.parseJSON(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		function recharger_autocomplete_chauffeur(Lettre){
			var table="chauffeurs";
			var nom="nom";
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:nom,table:table},function(results){
				results=jQuery.parseJSON(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		function charger_routes(sort,ordre,filtre,interval_date,page){
			var param={sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
			$.post("ajax/chargement/charger_avances.php",param,function(resultat){
				
				var resultat = jQuery.parseJSON(resultat);
				var chauffeurs="";
				Champ=$("input").next("select").find("option:selected").val();
				filtres_caché.push(Champ); 
				for(var i=0; i<resultat.length; i++) {
					chauffeurs+="<tr  onClick='voir_feuille("+resultat[i].id+")'>";
							
							var id="<td id='id' style='display: none;'>"+resultat[i].id+"</td>";
							var nom="<td id='nom'> "+resultat[i].nom+"</td>";
							var avance="<td id='type'> "+resultat[i].avance+"</td>";
							var date="<td id='matricule'> "+resultat[i].date+"</td>";
								if($(filtre_1).val().length>0){
	                        	for(var j=0;j<filtres_caché.length;j++)  {
						
						if( filtres_caché[j]=="name")				nom="<td style='display: none' id='name'> "+resultat[i].nom+"</td>";
						if( filtres_caché[j]=="avance")				avance="<td style='display: none' id='avance'> "+resultat[i].avance+"</td>";
						if( filtres_caché[j]=="date")			date="<td style='display: none' id='matricule'> "+resultat[i].date+"</td>"
								}
						}
							chauffeurs+=id+nom+date+avance
						
							

						chauffeurs+="</tr>";
				}
				
				$("#tableau_routes tbody").html(chauffeurs);
				$('.conteneur.Routes').show()

			})
		}
		function afficher_page(page){
			Page=page;
			charger_routes(Sort,Ordre,Filtre,Interval_date,page);
		}
		function cacher_filtre(){
			console.log(champ)
			var champ2=$("table #"+Champ);
			champ2.hide();
			var nom=$('#filtre_1').val()
			$(".filtres input").html(
				$("#filtre_1").val()
				)
			console.log(nom)
			if( champs_slectionné==" " ){champs_slectionné+=Champ+" : "+nom;
			}else{
			
			champs_slectionné+=" et "+Champ+" : "+nom;}
			$("#entete_tableau").html("<h2 style='text-align: center; width: 100%;' >listes des camions pour "+champs_slectionné+"</h2>")
		}

		function afficher_page(page){
		Page=page;
		var nom_table="chauffeurs"
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
			afficher_page(1);
			 notification();	
		
            
			
			
		$("#filtre_1").autocomplete().keyup(function(){
				Lettre=$(this).val();
				recharger_autocomplete(Lettre);
			})
		$("#nom").autocomplete().keyup(function(){
				Lettre=$(this).val();
				recharger_autocomplete_chauffeur(this,Lettre);
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
				if($(filtre_1).val().length>0){
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
				cacher_filtre();
champs +="= '"+$("#filtre_1").val()+"' AND ";k=0;
chargement=1;


	$("input").next("select").find("option:selected").remove();
	$('tbody tr td .'+champ).foreach().remove();console.log($('.'+champ).val());
	console.log(champ)

										$("#defaut").attr("selected","selected");
										$("#filtre_1").val("");
				return false;}

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
			$(".A #name").attr("selected","selected");
			$(".B #matricule").attr("selected","selected");
			$(".C #nom_chauffeur").attr("selected","selected");
			$(".D #type").attr("selected","selected");
			
		 
		});
	</script>


</head> 
<body>
<div id="conteneur">
		<div id="notif">
		<div id="notifh">	
		<a href="#" id="notification" rel="#fond"></a>
				
		</div>
		<a href="parametres.php" ><img src="elements/index.png" alt="parametres" /></a>
	</div>
			
				<img src="elements/logo.png" alt="fastliner" />
			
		<div id="entete">
			<nav>
				<ul>
					<li><a href="routes" class="lien_page">FRoutes</a></li>
					<li><a href="etats" class="lien_page">Etats</a></li>
					<li><a href="projets" class="lien_page">Projets</a></li>
					<li><a href="camions" class="lien_page">Camions</a></li>
					<li ><a href="chauffeurs"  class="lien_page">Chauffeurs</a></li>
					<li class="lien_page active"><a href="prets" class="lien_page active">Préts</a></li>
				</ul>
			</nav>
		</div>


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
										foreach($champs_avances as $cle=>$valeur)
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
								<input type="text" id="date_min" name="date_min" placeholder="Date min"  />
							
								<input type="text" id="date_max" name="date_max" placeholder="Date max"  />

								
								<input id="btnFiltrer" type="submit" value="Filtrer" class="important"/>

								</div>
								<td>
						</tr>
					</table>
				</div>			
			</form>
		
	</div>
	<div id="formulaire_ajout">
		<?php require_once('ajouter_avances.php'); ?>
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
			foreach($champs_avances as $cle=>$valeur)
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
		<span id="cadre_pagination">
			<table id="pagination_page" style="float:top;color:black;padding:3px;">
			<thead>
			</thead>
		</table>
		</span>	
		</form>
			<?php
		?>
	</div>
	<?php include("notification/notification.php"); ?>
</div>
</body>
<script>
</script>
</html>