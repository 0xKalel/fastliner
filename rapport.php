<?php session_start();
	$cle_actuelle="rapport";
	$reference="php/";
	include("php/config.php");
	if(isset($_SESSION["connecter"])&&isset($_SESSION["type"])){
		
	if($_SESSION["connecter"]){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>Rapport</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="UTF-8" />
	<meta name="author" content="mondersky" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/design.css?<?php echo date('l jS /of F Y h:i:s A'); ?>" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="js/date_piker/css/ui-darkness/jquery-ui-1.10.4.custom.css" />
	<script type="text/javascript" src="js/date_piker/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/autocomplete/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="js/date_fr.js"></script>
	<script type="text/javascript" src="js/notification/notification.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script>
	Cle_actuelle="rapports";

		function charger_rapports(){
			$.post("ajax/chargement/charger_rapports.php",function(resultat){
				var rapport="";
				var resultat = jQuery.parseJSON(resultat);
				
			})			
		}
		$(document).ready(function(){
			charger_rapports()
		});
	</script>


</head> 
<body>
<div id="conteneur" class="rapport">
		
	<?php include("php/entete.php"); ?>
	<div id="space">
	</div>
	<div class="conteneur elements" >
		
	</div>
	<div id="ajouter">
		<table>
			<tbody>
				<tr>
					<td>Revenues</td>
					<td id="revenues"></td>
				</tr>
				<tr>
					<td>Dépenses</td>
					<td id="depenses"></td>
				</tr>
				<tr>
					<td>Bénifices</td>
					<td id="benifices"></td>
				</tr>
			</tbody>
		</table>
	</div>

</div>
	<?php include("notification/notification.php"); ?>
</body>
<script>
</script>
</html>
<?php 
    }
    // redirection de des non cnecter ver la page login
    else{
    	header("location:index.php");
    }
}else{
	header("location:index.php");
}
?>