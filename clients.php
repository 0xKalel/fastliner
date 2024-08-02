<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>	
	<title>home</title>
	<meta http-equiv="Content-Type" content="utf8" />
	<meta name="author" content="mondersky" />
	<link rel="stylesheet" href="css/design.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/utilities.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/messages_fr.js"></script>
	<script type="text/javascript" src="js/notification/notification.js"></script>
	
<script>
$(document).ready(function() {
notification();
 function validation(){
  return  $("#form").validate({
      rules: {
         "nom":{
            "required": true,
            "minlength": 5,
         },
         "wilaya": {
            "required": true,
            "maxlength": 255
         },
         "adresse": {
            "required": true
         },         
		
		 }
  })
  }
  if (validation())
  {
  $("#form").submit(function()
		{	
				var parametres=
				{
					nom:$(this).find("input[name='nom']").val(),
					wilaya:$(this).find("input[name='wilaya']").val(),
					adresse:$(this).find("input[name='adresse']").val(),
					observation:$(this).find("input[name='observation']").val(),
				}
				if(validation())
				{
					$.post("ajax/enregistrement/nouveau_client.php",parametres)
					$( ".reussi" ).show().html("chargement réussi").fadeOut(2000);
				}
				
				return false;
		})
		

									}});

</script>
</head> 
<body class="conteneur">
	<div class="reussi" style="float:right"></div>
		<div id="formulaire" >
		
			<form id="form" class="cmxform" method="post" >
		<fieldset>
				<p>
				<label for="nom">Nom</label>
				<input type="text" name="nom" id="nom"  placeholder="EX : Arcelor Mittal" />
				</p>	
					
				<p>
				<label for="wilaya">wilaya</label>
				<input type="text" name="wilaya" id="wilaya" placeholder=" EX :Annaba" />
				</p>	
					
				<p>
				<label for="adresse">Adresse</label>
				<input type="text" name="adresse" id="adresse" placeholder=" EX :Elhadjar " />
				</p>	
				<p>	
				<label for="observation">observation</label>
				<input type="text" name="observation" id="observation" placeholder=" EX :WTF??" />
				</p>	
		</div>
				<input class= "conex" style="vertical-align:top;" type="submit" value="envoyer " />
		</fieldset>
				
			</form>
			</div>
			
</body>
</html>