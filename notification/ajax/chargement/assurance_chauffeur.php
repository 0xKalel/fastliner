<?php

$reference="../../../php/";
include("../../../php/config.php");
$datelocal=date("Y-m-d");
$debut=date("Y-m-d");
$secondes=strtotime($datelocal);
$secondes-=$delai_assurance_chauffeur*24*60*60;
$fin = date('Y-m-d', $secondes);
$camions=$bdd->get_results("SELECT * FROM vehicules WHERE date_assurance_chauffeur <= '$fin'");
if(count($camions)){
	?>
	<script src="js/scripts_notifications.js"></script>
	<div id="scroll2" class="scroll" style="height: 448px; overflow: auto;">
		<table id="tableau_notifications" >
			<thead >
				<th class="d" id="matricule">matricule</th>
				<th class="d" id="nom_chauffeur">nom chauffeur</th>
				<th class="d" id="paye">dernier réglement</th>
				<th class="d" id="prochain_reglement">prochain réglement</th>
				<th class="d" >assurance</th>
				<th class="d" id="Action">Action</th>
				<!-- champs observation a pr?voir -->
			</thead>	
			<tbody>
				<?php

				foreach($camions as $r)
				{
					foreach($r as $cle=>$valeur)
					{
						$$cle=securiser($valeur);
					}
					$prochain_reglement=prolonger($date_assurance_chauffeur,"+1 year");
					if($prochain_reglement>$fin)
						$etat_date="bon";
					else
						$etat_date="insuffisant";
					?>
					<tr id="<?php echo $id;	?>">	 
						<td id="matricule"><?php
						echo $matricule;
						?></td>	 
						<td id="nom_chauffeur"><?php
						echo $nom_chauffeur;
						?></td>
						<td id="date_assurance_chauffeur "   class="date_notification"><?php
						echo formatter_date($date_assurance_chauffeur) ;
						?></td>
						<td   class="prochain_reglement <?php echo $etat_date;?>"><?php
						echo formatter_date($prochain_reglement);
						?></td>
						<td id="assurance"><?php
						echo $assurance_chauffeur;
						?></td>
						<td><div id="<?php echo $id;?>" class="button" table="vehicules"> Regler</div></td>
						<?php
					}

					?>
				</tr>
			</tbody>
		</table>
		<button id="regler_notifications" table="vehicules" name="ok" element="date_assurance_chauffeur" fin="<?php echo $fin;?>">Tout Regler</button>
	</div>
	<div class="notifications_regle">Réglé</div>


	<?php 
}else{
	?>
	<div id="scroll5" class="scroll" style="height: 448px; overflow: auto;">
		<div class="notifications_regle" style="display:block">Réglé</div>
	</div>
	<?php 
}
?>