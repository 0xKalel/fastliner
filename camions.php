<?php
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
	<script type="text/javascript" src="js/notification/notification.js"></script>
	<script type="text/javascript" src="js/showHide.js" ></script>

	<script>
		var changement=0;
	var k=0;
	var champ;
	    var champs=" ";

	var champs_slectionné=" ";
	var str="";
		var ordre_prec;
		var Sort="id",Ordre="DESC",Filtre,Interval_date={min:"0",max:"0"},Page=1;Lettre="";Champ="";filtres_caché=Array();Page=1,Nbr_page=5;champs_slectionné=" ";

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
			var table="camions"
			var champ=$("input").next("select").find("option:selected").val();
			$.post("ajax/chargement/charger_autocomplete.php",{Lettre:Lettre,champ:champ,table:table},function(results){
				results=jQuery.parseJSON(results);
				$( "input" ).autocomplete({source:results});
			})
		}
		function charger_routes(sort,ordre,filtre,interval_date,page){
			var param={sort:sort,ordre:ordre,filtre:filtre,interval_date:Interval_date,page:page};
			$.post("ajax/chargement/charger_camions.php",param,function(resultat){
				
				var resultat = jQuery.parseJSON(resultat);
				var camions="";
				Champ=$("input").next("select").find("option:selected").val();
				filtres_caché.push(Champ); 
				for(var i=0; i<resultat.length; i++) {
					camions+="<tr  onClick='voir_feuille("+resultat[i].id+")'>";
							
							var id="<td id='id' style='display: none;'>"+resultat[i].id+"</td>";
							var nom="<td id='nom'> "+resultat[i].nom+"</td>";
							var type="<td id='type'> "+resultat[i].type+"</td>";
							var matricule="<td id='matricule'> "+resultat[i].matricule+"</td>";
							var date_assurance="<td id='date_assurance'> "+resultat[i].date_assurance+"</td>"
							var date_scanner="<td id='date_scanner'> "+resultat[i].date_scanner+"</td>";
							var date_vignette="<td id='date_vignette'> "+resultat[i].date_vignette+"</td>"
							var controle_technique="<td id='controle_technique'> "+resultat[i].controle_technique+"</td>"
							var prix_assurance="<td id='prix_assurance'> "+resultat[i].prix_assurance+"</td>"
							var prix_vignette="<td id='prix_vignette'> "+resultat[i].prix_vignette+"</td>"
							var prix_controle="<td id='prix_controle'> "+resultat[i].prix_contole+"</td></tr>"
							if($(filtre_1).val().length>0){
	                        	for(var j=0;j<filtres_caché.length;j++)  {
	                        		console.log(filtre_caché[1]);
						
						if( filtres_caché[j]=="nom")				nom="<td style='display: none' id='nom'> "+resultat[i].nom+"</td>";
						if( filtres_caché[j]=="type")				type="<td style='display: none' id='type'> "+resultat[i].type+"</td>";
						if( filtres_caché[j]=="matricule")			matricule="<td style='display: none' id='matricule'> "+resultat[i].matricule+"</td>";
						if( filtres_caché[j]=="date_assurance")		date_assurance="<td style='display: none' id='date_assurance'> "+resultat[i].date_assurance+"</td>"
						if( filtres_caché[j]=="date_scanner")		date_scanner="<td style='display: none' id='date_scanner'> "+resultat[i].date_scanner+"</td>";
						if( filtres_caché[j]=="date_vignette")		date_vignette="<td style='display: none' id='date_vignette'> "+resultat[i].date_vignette+"</td>";
						if( filtres_caché[j]=="controle_technique")	controle_technique="<td style='display: none' id='controle_technique'> "+resultat[i].controle_technique+"</td>";
						if( filtres_caché[j]=="prix_assurance")		prix_assurance="<td style='display: none' id='prix_assurance'> "+resultat[i].prix_assurance+"</td>";
						if( filtres_caché[j]=="prix_vignette")		prix_vignette="<td style='display: none' id='prix_vignette'> "+resultat[i].prix_vignette+"</td></tr>";
						if( filtres_caché[j]=="prix_controle")		prix_contole="<td style='display: none' id='prix_controle'> "+resultat[i].prix_controle+"</td></tr>";
						
						
						
					
						}
							}
							camions+=id+nom+type+matricule+date_assurance+date_vignette+date_scanner+controle_technique+prix_assurance+prix_assurance+prix_vignette+prix_scanner+prix_controle+nom_chauffeur;
						
							

						camions+="</tr>";
				}
				
				$("#tableau_routes tbody").html(camions);
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
			afficher_page(1);
		notification();
		$("input").next("select").click( function(){
		k=0;
		
		
		if(chargement==0){
										champs=Remplace(champs, champ);}
		else{
									
										
		}
		});
            
			
			
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
			$(".A #nom").attr("selected","selected");
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
				        <li class="lien_page active"><a href="" class="lien_page active">Camions</a></li>
						<li><a href="chauffeurs" class="lien_page ">Chauffeurs</a></li>
						<li><a href="prets" class="lien_page">Prets</a></li>
						
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
										foreach($champs_camions as $cle=>$valeur)
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
							</td>
						</tr>
					</table>
				</div>			
			</form>
			
		</div>
		

			<div id="formulaire_ajout" >
			<?php require_once('ajouter_camion.php'); ?>
		
		 </div>
		<div id="space">
		</div>
		<div id="ouvrir_formulaire" >
						Ajouter
		</div>
	
		<div class="conteneur Routes">
			<div id="entete_tableau"></div>
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
				foreach($champs_camions as $cle=>$valeur)
					{
					?>
						<th class="d" id="<?php echo $cle ?>"><?php echo $valeur ?></th>
					<?php
					}
			?>
				<!-- champs observation a prévoir -->
			</thead>
			<tbody id="tab">
			<?php
			/*$camions=$bdd->get_results('SELECT * FROM camions ORDER BY id DESC');
			if(count($camions))
				foreach($camions as $r)
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
								<td id="type"><?php
								echo $type;
							?></td>
								<td id="matricule"><?php
								echo $matricule;
							?></td>
								<td id="date_assurance"><?php
								echo $date_assurance;
							?></td>
								<td id="date_vignette"><?php
								echo $date_vignette;
							?></td>
								<td id="date_scanner"><?php
								echo $date_scanner;
							?></td>
								<td id="controle_technique"><?php
								echo $controle_technique;
							?></td>
								<td id="prix_assurance"><?php
								echo $prix_assurance;
							?></td>
								<td id="prix_vignette"><?php
								echo $prix_vignette;
							?></td>
								<td id="prix_scanner"><?php
								echo $prix_scanner;
							?></td>
								<td id="prix_controle"><?php
								echo $prix_controle;
							?></td>
						</tr>
								
				<?php
				}*/
				?>
			</tbody>
			</table>
			<span id="cadre_pagination">
				<table id="pagination_page">
					<thead>
					</thead>
				</table>
			</span>	
			</form>
				<?php
			?>
		</div>
	</div>
	<?php require_once("notification/notification.php"); ?>
</body>
<script>
</script>
</html>