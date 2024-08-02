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
 
	<link rel="stylesheet" href="js/ui/demos.css">
	<link rel="stylesheet" href="jquery.ui.all.css">
	<script>
	$(function() {
	   var notifications = new $.ttwNotificationMenu({
        notificationList:{
            anchor:'item',
            offset:'0 15'
        }
    });

   

		$( "#tabs" ).tabs({
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html(
						"<p style='color:red'>touts est régler pour ce champ <p> "  );
				});
			}
		});
	$("#close").click(function(){
	$( "#fond" ).toggle( "slide",100 );
	 $(".non_vide").toggleClass("non_vide_click");
				   
	
	});
	});
	
	</script>
<div  class="fond" id="fond" style="top : 0px">



<div style="margin: 50px 0 ;background:black;width:60%;height:60%;z-index:10;position:relative;float:left;margin-left: 20%; ">

<div id="tabs"  style="background:black !important;border: 1px solid #000000 !important;min-height:400px;">
	<ul style="color:white !imporatant;">
		<li id="assurance" ><a href="notification/ajax/assurance.php"><div style="height: 25px;">assurance</div></a></li>
		<li id="vignette"><a href="notification/ajax/vignette.php"><div style="height: 25px;">vignette</div></a></li>
		<li id="scanner"><a href="notification/ajax/scanner.php"><div style="height: 25px;">canner</div></a></li>
		<li id="controle_tecnique"><a href="notification/ajax/controle_tecnique.php"><div style="height: 25px;">controle tecnique</div></a></li>
		<li id="paye"><a href="notification/ajax/paye.php"><div style="height: 25px;">paye chauffeur</div></a></li>
		<li id="assurance_chauffeur"><a href="notification/ajax/assurance_chauffeur.php"><div style="height: 25px;">assurance chauffeur</div></a></li>
	</ul>
	
</div>
<button id="regler_tout"name="ok" >ok</button>
</div>
<div id="close"  style=" min-height: 300px;background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5);height: 100%;position: absolute;width: 100%;z-index: 9;">   </div>
</div>