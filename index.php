<?php 
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
SESSION_start();
include("php/config.php");
$nom="";
if(!isset($_SESSION["nom"])){
	if(isset($_POST["nom"])){
		if($_POST["nom"]!=""){
			$nom=securiser($_POST["nom"]);
			if(isset($_POST["mp"])){
				if($_POST["mp"]!=""){
					$mpasse=securiser($_POST["mp"]);
					$login=$bdd->get_results("SELECT * FROM comptes WHERE nom='$nom'");
					if(count($login)){
						foreach($login as $r){
							foreach($r as $cle=>$valeur){
								$$cle=$valeur;
							}
							if($mpasse==$mdp){
								$_SESSION["connecter"]=true;
								$_SESSION["type"]=$type;
								$_SESSION["nom"]=$nom;
								header("location:routes");
							}else
							$test=3;
						}
					}
					else
						$test=2;
				}else
				$test=1;
			}
		}else
		$test=0;
	}else{
		$test=-1;


	}
}
else
header("location:routes");

?>
<html>
<head>
	
	<title>Login</title>
	<style type="text/css">
	body{
		margin: 0px; 
	}
	.page_login #topimg{
		background-color: #ed5b05; 
		margin-top: 0px;
		width: 100%; 
		height:350px; 
		padding: 0px; }
		.page_login #formulaire{
			width:960px; 
			margin:0 auto;  
			margin-top: 30px; 
			display: block;
		}
		.page_login #logo{
			margin-top: 140px;
		}


		@font-face {
			font-family: 'MyriadPro';
			src: url(../font/MyriadPro-Regular.otf);
			font-weight: normal;
			font-style: normal;
		}


		.tfd1{ width:260px; height:35px;  margin:auto; color:#413d3c;  }
		.tfd2{ width:260px; height:35px;  margin:auto;  color: #413d3c;}
		.btn{     background: linear-gradient(to bottom, rgb(255, 111, 35) 63%, rgb(237, 91, 5) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
			border: 1px solid rgb(215, 71, 5);
			border-radius: 2px;
			box-shadow: 1px 1px 0 rgb(255, 132, 45) inset;
			color: #ffffff;
			cursor: pointer;
			padding: 5px 40px;
			margin-top: 50px;  }

			input#ip1 {   padding: 0px 0px 0px 15px;font-family: 'MyriadPro'; font-size:16px; margin-left:350px ; margin-right: 200px; border:1px solid #413d3c;}
			input#ip2 {   padding: 0px 0px 0px 15px; font-size:16px; margin-left:350px ; margin-top: 10px; border:1px solid #413d3c; }
			input#btn {  font-family: 'MyriadPro'; font-size:16px; margin-left:450px ; margin-top: 10px;  }

			</style>
		</head>
		<body>

			<div id='contenaire' class="page_login">
				<div id='topimg'>
					<center><img id='logo' src="elements/logo_login.png"></center>
				</div>
				<div id="formulaire">

					<form action="" method='post'>

						<input id='ip1' type='text' class="tfd1" placeholder='Pseudo'   name="nom" value='khalil'>
						<input id='ip2' type='password' class="tfd2" placeholder="mot de passe"  name="mp" value='khalil'>
						<input id='btn' type='submit' class="btn" value='Connexion'>
						<?php 
						switch ($test) {
							case 0:
							echo '<b style="color:red;"> Veuillez entrer votre nom d\'utilisateur</b>';
							break;
							case 1:
							echo '<b style="color:red;"> Veuillez entrer un mot de passe';
							break;
							case 2:
							echo '<b style="color:red;"> nom d\' utilisateur n\'existe pas ou incorect</b>';
							break;
							case 3:
							echo '<b style="color:red;">mot de passe incorect</b>';
							break;
						}
						?>
					</form>		
				</div>			
			</div>
		</body>
		</html>