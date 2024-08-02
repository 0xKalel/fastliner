	<div id="entete"> 	
		<?php 
		if($parametres["type"]=="prestataire"){
			?>

			<div id="notif">
				<div id="notifh">	
					<a style="padding-left: 10px; padding-right: 11px;"  id="notification" rel="#fond"></a>
				</div>
			</div>
			<?php 
		}
		if(!isset($facturation))
		{
		?>
		<img src="elements/logo.png" alt="fastliner" id="logo" />
		<?php }else{?>
		<center><span style="font-size:20px;font-weight:300;margin:20px 0;display:inline-block;color:black" class="nom_projet"></span>
	</center>
		<center>
			<span style="font-size:20px;font-weight:300;display:inline-block">Sélectionnez les feuilles de routes a assigner</span>
		<center>
		<?php } ?>
		<nav>
			<ul>
				<?php
				if(!isset($facturation)) 
				if($_SESSION["type"]=="administrateur"){
					foreach($liste_pages as $cle=>$valeur){
						if(!in_array($cle,$liste_pages_inaccesibles)){
							?>
							<li class="lien_page <?php if($cle==$cle_actuelle || (($cle=="dettes")&&($cle_actuelle=="dettes_personnel")) || (($cle=="creances")&&($cle_actuelle=="creances_personnel"))) echo 'active'; ?>"><a href="<?php echo $cle; ?>"><?php echo $valeur;?></a></li>
							<?php
						}
					}
					?>
					<li class="lien_page "><form action="php/deconnexion.php"method="post">
						<div id="deconnexion">
							<input name="deconnexion"type="submit" value="" title="Deconnecter"class="lien_page deconnexion"></input>
						</div>
					</form>
				</li>

				<?php
			}else{
				if(!isset($facturation))
				if($_SESSION["type"]=="super-administrateur"){	
					foreach($liste_pages as $cle=>$valeur){
						?>
						<li class="lien_page <?php if($cle==$cle_actuelle || (($cle=="dettes")&&($cle_actuelle=="dettes_personnel")) || (($cle=="creances")&&($cle_actuelle=="creances_personnel"))) echo 'active'; ?>"><a href="<?php echo $cle; ?>"><?php echo $valeur; ?></a></li>
						<?php
					}
				}	
			}
			?>
			<?php if(!isset($facturation)) if($_SESSION["type"]=="super-administrateur") {?>
				<li style="width: auto;">
					<a href="parametres" title="<?php echo MESSAGE_PARAMETRES;?>"><img src="elements/index.png" alt="parametres" style="margin-top:4px"/></a>
				</li>
			<?php }?>
		</ul>
	</nav>
</div>
<div id="moteur" class="etats">
	<form method="post" onSubmit="return false" id="form_filtre">
		<div class="bloc_fitres">

			<div class="filtres">
				<input type="text" placeholder="Filtre" name="filtre_1" id="filtre_1" class="filtre" autocomplete="off" title="<?php echo MESSAGE_CHAMP_FILTRE;?>" />
				<select name="filtre_1" id="filtre_2" disabled class="filtre">
					<option value="1">Oui</option>
					<option value="0">Non</option>
				</select>
				<select name="selection1" id="selection_filtres" class="selections  A" autocomplete="off"  title="<?php echo MESSAGE_SELECTION_FILTRE;?>">
					<?php
					foreach($liste_champs[$cle_actuelle] as $cle=>$valeur)
					{
						?>
						<option id="<?php echo $cle ?>" value="<?php echo $cle ?>" ><?php echo $valeur ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="bloc_bouttons">
				<input id="btnFiltrer" type="submit" value="Filtrer" class="important" title="<?php echo MESSAGE_FILTRER ;?>"/>
			</div>
			<?php if($cle_actuelle!="vehicules"){?>
			<div class="bloc_bouttons" style="margin-right: 20px;">
				<input type="text" id="date_min" name="date_min" placeholder="Date min"  autocomplete="off" title="<?php echo MESSAGE_INTERVALLE_DATE ;?>"/>
				<input type="text" id="date_max" name="date_max" placeholder="Date max"  autocomplete="off" title="<?php echo MESSAGE_INTERVALLE_DATE ;?>" />
			</div>
			<?php } ?>
		</div>
	</form>
</div>