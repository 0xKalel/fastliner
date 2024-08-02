<?php

	$reference="../../php/";
	include("../../php/config.php");
	$datelocal=date("Y-m-d");
	$debut=date("Y-m-d");
	$secondes=strtotime($datelocal);
	$secondes+=31*24*60*60;
	$fin = date('Y-m-d', $secondes);

	?>
<table id="tableau_routes">
		<thead>
				<th class="d" id="matricule">matricule</th>
		       <th class="d" id="nom">nom</th>
			   <th class="d" id="type">type</th> 
			   <th class="d" id="controle_technique">controle technique</th>
			   <th class="d" id="prix_controle_technique">prix controle technique</th>
			
			<!-- champs observation a prévoir -->
		</thead>	
<tbody>
<?php
		$camions=$bdd->get_results("SELECT * FROM camions WHERE controle_technique  BETWEEN  '$debut' AND '$fin'");
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
						
							<td id="controle_technique"><?php
							echo $controle_technique;
						?></td>
							
							<td id="prix_controle"><?php
							echo $prix_controle;
						?></td>
							
							
			<?php
			}
			
			?>
			</tr>
		</tbody>
	</table>