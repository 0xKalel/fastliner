
<?php

$reference="../../../php/";
include("../../../php/config.php");
$datelocal=date("Y-m-d");
$debut=date("Y-m-d");
$secondes=strtotime($datelocal);
$secondes-=$delai_vignette*24*60*60;
$fin = date('Y-m-d', $secondes);
$camions=$bdd->get_results("SELECT * FROM vehicules WHERE date_vignette <= '$fin'");
if(count($camions)){
	?>
	<script src="js/scripts_notifications.js"></script>
	<div id="scroll5" class="scroll" style="height: 448px; overflow: auto;">
		<table id="tableau_notifications" >
			<thead>
				<th class="d" id="matricule" >matricule</th>
				<th class="d" id="nom" >nom</th>
				<th class="d" id="type" >type</th> 
				<th class="d" id="date_vignette" >dernier réglement</th>
				<th class="d" id="prochain_reglement">prochain réglement</th>
				<th class="d" id="prix_vignette" >prix vignette</th>
				<th class="d" id="Action" >Action</th>

				<!-- champs observation a prévoir -->
			</thead>	
			<tbody>
				<?php
				foreach($camions as $r)
				{
					foreach($r as $cle=>$valeur)
					{
						$$cle=securiser($valeur);
					}
					$prochain_reglement=prolonger($date_vignette,"+1 year");
					if($prochain_reglement>$fin)
						$etat_date="bon";
					else
						$etat_date="insuffisant";
					?>
					<tr id="<?php echo $id;	?>">	
						<td id="matricule"><?php
						echo $matricule;
						?></td>
						<td id="nom"><?php
						echo $nom_chauffeur;
						?></td>
						<td id="type"><?php
						echo $type;
						?></td>
						<td id="date_vignette" class="date_notification"><?php
						echo formatter_date($date_vignette);
						?></td>
						<td   class="prochain_reglement <?php echo $etat_date;?>"><?php
						echo formatter_date($prochain_reglement);
						?></td>

						<td id="prix_assurance"><?php
						echo $prix_vignette;
						?></td>
						<td><div id="<?php echo $id;	?>" class="button" table="vehicules"> Regler</div></td>

						<?php
					}

					?>
				</tr>
			</tbody>
		</table>
		<button id="regler_notifications" table="vehicules" name="ok" element="date_vignette" fin="<?php echo $fin;?>">Tout Regler</button>
		<div class="notifications_regle">Réglé</div>
	</div>
	
	<?php 
}else{
?>
	<div id="scroll5" class="scroll" style="height: 448px; overflow: auto;">
		<div class="notifications_regle" style="display:block">Réglé</div>
		<script type="text/javascript">
			$("ul li.ui-state-active").toggleClass("incliquable")
		</script>
	</div>
<?php
}
?>