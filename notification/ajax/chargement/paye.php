<?php

$reference="../../../php/";
include("../../../php/config.php");
$fin =fin($delai_paye_chauffeur);
$camions=$bdd->get_results("SELECT * FROM vehicules WHERE date_chauffeur <= '$fin'");

if(count($camions)){
	?>
	<script src="js/scripts_notifications.js"></script>
		<div class="targ">
	<div id="scroll3" class="scroll" style="height: 448px; overflow: auto;">
			
		<table id="tableau_notifications" >
			<thead >
				<th class="d" id="matricule" >matricule</th>
				<th class="d" id="nom_chauffeur">nom chauffeur</th>
				<th class="d" id="date_paye">dernier réglement</th>
				<th class="d" id="prochain_reglement">prochain réglement</th>
				<th class="d" id="paye">paye </th>
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
					$prochain_reglement=prolonger($date_chauffeur,"+1 month");
					if($prochain_reglement>$fin)
						$etat_date="bon";
					else
						$etat_date="insuffisant";
					?>
					<tr id="<?php echo $id;	?>" >	
						<td id="matricule"><?php
						echo $matricule;
						?></td>
						<td id="nom_chauffeur"><?php
						echo $nom_chauffeur;
						?></td>
						<td id="date_chauffeur" class="date_notification"><?php
						echo formatter_date($date_chauffeur);
						?></td>
						<td   class="prochain_reglement <?php echo $etat_date;?>"><?php
						echo formatter_date($prochain_reglement);
						?></td>
						<td id="paye"><?php
						echo $paye_chauffeur;
						?></td>
						<td><div id="<?php echo $id;	?>" class="button" table="vehicules"> Regler</div></td>
						<?php
					}

					?>
				</tr>
			</tbody>
		</table>
		</div>
		<button id="regler_notifications" table="vehicules" name="ok" element="date_chauffeur"  fin="<?php echo $fin;?>">Tout Regler</button>
		<div class="notifications_regle">Réglé</div>
	</div>
	<div id="num" style="display: none ;"> 4</div>	
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