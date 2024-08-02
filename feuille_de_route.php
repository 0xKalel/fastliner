	<?php
	
	$reference="php/";
	include("php/config.php");
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns:="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<head>	
		<title>feuille de route <?php echo $_GET["id"] ?></title>
		<meta charset="ANSI">
		<meta http-equiv="Content-Type" content="ANSI" />
		<meta name="author" content="mondersky" />
		<link media="screen" type="text/css" href="../css/design_fr.css" rel="stylesheet">
		<link media="print" type="text/css" href="../css/design_print_fr.css" rel="stylesheet">
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
	</head> <body>
	<div id="entet"><div style="float:right; width: 450px;"id="cordoner" >
		<h3 >SPA FAST LINER TRANSPORT</h3>
		<br style="margin-top: 25px;">Avenue de l'ALN,rue ABDAOUI Mouloud local n°07 , Annaba<br>
		<b>Tel:</b>+213(0)38833454
		<BR><b>Tel/Fax:</b>038434448
			<br><b>Mobile:</b>+213(0)552774857
			<BR><b>Email:</b> fastliner_dz@yahoo.fr
			</div>
			<DIV  style="width: 200px;float:left;" id="fast"><h1>FASTLINER</h1>
				<BR><h5 style="margin-left: 0px !important;">t</h5><h5>r</h5><h5>a</h5><h5>n</h5><h5>s</h5><h5>p</h5><h5>o</h5><h5>r</h5><h5>     t</h5>

				</div></div>
				<?php $rt= $_GET["id"];
				$routes=$bdd->get_results("SELECT r.*,i.depart,i.destination 
											FROM routes AS r,itineraires AS i 
											WHERE r.id =$rt AND r.iditineraire=i.id ");

				foreach($routes as $r)
				{
					foreach($r as $cle=>$valeur)
					{
						$$cle=securiser($valeur);
					}?>

					<div id="orange"><H1 style="margin-left: 30%;"id="titre">FEUILLE DE ROUTE N°<?php echo $nfr; ?></h1></div>
					<div class="conteneur">

						

						<br><div id="entet">
						<table  style=" background:white;width: 900px;margin-left: 50px;"  id="feuille">
							<tr>
								<td>
									<label><h4>Nom et Prenom du Conducteur :</h4></label>
									<label ><?php echo $nom; ?></label>
									<br >	<label><h4>N° du permis de conduite :  </h4></label>
								</td>
							</tr>
							<tr>
								<td>
									<label><h4>Immatriculation  :  </h4></label><?php echo $matricule; ?>
								</td>
							</tr>
							<tr>
								<td>
									<label><h4>trajet   </h4><b style="margin-left:40px;">depart :</b> <?php echo $depart;?>      <b style="margin-left:100px;">destination :</b><?php echo $destination;?></label>
								</td>
							</tr>
							<tr>
							</table>

							<table style="background:white;width: 900px;margin-left: 50px;" id="bas">
								<tr>
									<td style="width:500px;">
										<div style="text-align: center;"><h4 id="entet" style="text-align: center;text-decoration: underline;">cadre reserve a l'expedition</h4></div>
										<br><h4 id="cadre">Date :</h4><B ><?php echo $date; ?>      </B>
										<br><h4 id="cadre">Produit :</h4><B ><?php echo $idproduit; ?>    </B>
										<br><h4 id="cadre">N°BCH :</h4><B >      </B>
										<br><h4 id="cadre">N°Exp :</h4><B > <?php echo $ndocument;  ?>      </B>
										<br><h4 id="cadre">tonnage :</h4><B ><?php echo $poids; ?>    </B>

									</td>
									<td  style="width:500PX;">
										<div style="text-align: center;margin-top: -20px;"><h4 style="text-decoration: underline;">cadre reserve au depot de reception</h4></div>
										<br><h4 style="margin: 0px;"id="cadre l">Date de reception :</h4><B >      </B>
										<br><B style="float: right;">        </B>
										<br><h4 style="float:left;"id="cadre">Nom receptionnaire :</h4><B >    </B>
										<br><h4 id="cadre">Visa :</h4>
										<br><h4 id="cadre">Observations :</h4><?php echo $observation; ?>


									</td>
								</tr>
							</table>

						</tr>
					</div>
					<div id="affichage1">
						<table  style="background:white;width: 900px;margin-left: 50px;"id="feuille">
							<tr>
								<td class="labeltd">
									<label><b>Nom et Prenom du Conducteur :</b></label>
								</td>
								<td>
									<label ><?php echo $nom; ?></label>
								</td>
							</tr>
							<tr>
								<td class="labeltd">
									<label><b>N° du permis de conduite : </b> </label>
								</td>
								<td></td>
								<tr>
									<td class="labeltd">
										<label><b>Immatriculation  :</b> 
										</td>
										<td>
										</label><?php echo $matricule; ?>
									</td>
								</tr>
								<tr >

									<td class="labeltd"><label><b>trajet :  </b> </td><td><b >                                </b> <?php echo $depart;?>      <b style="margin:0 5px;color:rgb(200, 200, 200)">-</b><?php echo $destination;?></label></td>
								</tr>
								<tr>
									<td class="labeltd"><label><b>Date :</b></label></td><td><label><?php echo $date; ?>      </laBel></td></tr>
									<tr><td class="labeltd"><label><b>Produit :</b></label></td><td><laBel ><?php echo $idproduit; ?>    </laBel></td></tr>
									<tr><td class="labeltd"><label><b>N°BCH :</b></label></td><td><label>      </laBel></td></tr>
									<tr><td class="labeltd"><label><b>N°Exp :</b></label></td><td><laBel ><?php echo $ndocument;  ?>    </laBel></td><tr>
										<tr><td class="labeltd"><label><b>tonnage :</b></label></td><td><label ><?php echo $poids; ?>    </laBel></td></tr>

									</table>

									<?php




								}
								?>


								<center> <button onclick="window.print()" class="button_orange" >imprimer</button></center>
							</div>
						</div>
					</body>
					<script>






					</script>
					</html>