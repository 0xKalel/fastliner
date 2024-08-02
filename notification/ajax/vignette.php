<?php

	$reference="../../php/";
	include("../../php/config.php");
	$datelocal=date("Y-m-d");
	$debut=date("Y-m-d");
	$secondes=strtotime($datelocal);
	$secondes+=11*24*60*60;
	$fin = date('Y-m-d', $secondes);
	?>
<table id="tableau_routes" >
		<thead>
				<th class="d" id="matricule">matricule</th>
		       <th class="d" id="nom">nom</th>
			   <th class="d" id="type">type</th> 
			   <th class="d" id="date_vignette">date vignette</th>
			   <th class="d" id="prix_vignette">prix vignette</th>
			
			<!-- champs observation a prévoir -->
		</thead>	
<tbody>
<?php
		$camions=$bdd->get_results("SELECT * FROM camions WHERE date_vignette BETWEEN  '$debut' AND '$fin'");
		if(count($camions))
			foreach($camions as $r)
			{
					foreach($r as $cle=>$valeur)
					{
						$$cle=securiser($valeur);
					}
			?>
			<tr>	
						<td id="matricule"><?php
							echo $matricule;
						?></td>
						<td id="nom"><?php
							echo $nom;
						?></td>
							<td id="type"><?php
							echo $type;
						?></td>
						
							<td id="date_vignette"><?php
							echo $date_vignette;
						?></td>
							
							<td id="prix_assurance"><?php
							echo $prix_vignette;
						?></td>
							
							
			<?php
			}
			
			?>
			</tr>
		</tbody>
	</table>