<?php 

if($parametres["type"]=="prestataire"){  
	?>

	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="js/ui/jquery.ui.effect.js"></script>
	<script src="js/ui/jquery.ui.effect-blind.js"></script>
	<script src="js/ui/jquery.ui.effect-bounce.js"></script>
	<script src="js/ui/jquery.ui.effect-clip.js"></script>
	<script src="js/ui/jquery.ui.effect-drop.js"></script>
	<script src="js/ui/jquery.ui.effect-explode.js"></script>
	<script src="js/ui/jquery.ui.effect-fold.js"></script>
	<script src="js/ui/jquery.ui.effect-highlight.js"></script>
	<script src="js/ui/jquery.ui.effect-pulsate.js"></script>
	<script src="js/ui/jquery.ui.effect-scale.js"></script>
	<script src="js/ui/jquery.ui.effect-shake.js"></script>
	<script src="js/ui/jquery.ui.effect-slide.js"></script>
	<script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.tabs.js"></script>
	<script src="js/notification_menu/js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
	<script src="js/notification_menu/js/ttw-notification-menu.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery-form.js"></script>
	<link rel="stylesheet" href="css/notification.css" />
	<link rel="stylesheet" href="js/ui/demos.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css" />
	<script>
	$(function() {
		var num;
		
		var notifications = new $.ttwNotificationMenu({
			notificationList:{
				anchor:'item',
				offset:'0 15'
			}
		});
		$("#tabs ul li").click(function(){
			$(".ui-state-default").addClass("nonactive");
			$(".ui-tabs-active").removeClass("nonactive");	
		})



		$( "#tabs" ).tabs({
			
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html(
						"<p style='color:red'>erreur connexion <p> "  );
				});
			}
		});
		$(".bouton_fermer1").click(function(){
			$( "#fond" ).toggle( "slide",100 );
			$(".non_vide").toggleClass("non_vide_click");
			notification();		   

		});

	});

	</script>
	<div  class="fond" id="fond" style="top : 0px">
		<div style="min-height:500px;min-width:920px;border-radius: 8px;margin: 50px 0 ;width:73%;height:60%;z-index:10;position:relative;float:left;margin-left: 13.5%; ">
			<div id="tabs"  style="min-height:400px;">
				<ul style="color:black !imporatant;">
					<li id="assurance" class="non nonactive"><a id="0" href="notification/ajax/chargement/assurance.php"><div style="line-height: 25px;">Assurance</div></a></li>
					<li id="vignette" class="non nonactive"><a id="1" href="notification/ajax/chargement/vignette.php"><div style="line-height: 25px;">Vignette</div></a></li>
					<li id="scanner" class="non nonactive"><a id="2" href="notification/ajax/chargement/scanner.php"><div style="line-height: 25px;">Scanner</div></a></li>
					<li id="controle_tecnique" class="non nonactive"><a id="3" href="notification/ajax/chargement/controle_tecnique.php"><div style="line-height: 25px;">Controle technique</div></a></li>
					<li id="paye" class="non nonactive"><a id="4" href="notification/ajax/chargement/paye.php"><div style="line-height: 25px;">Paye chauffeur</div></a></li>
					<li id="assurance_chauffeur" class="non nonactive"><a id="5" href="notification/ajax/chargement/assurance_chauffeur.php"><div style="line-height: 25px;">Assurance chauffeur</div></a></li>
				</ul>

				<a class="bouton_fermer1" href="javascript:"></a>
			</div>

		</div>
		<div id="close"  style=" min-height: 300px;background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);height: 100%;position: absolute;width: 100%;z-index: 9;">   </div>
	</div>

	<?php 
}
?>