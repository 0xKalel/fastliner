<?php $champs_actuels=$liste_champs[$cle_actuelle]; ?>
<form method="post" onSubmit="return false" id="form_filtre">
	<div class="bloc_fitres">
		<center>
		<table id="Table-filter">
			
			<tr>
				<td>
				</td>
				<?php
					for ($i=0; $i <=3 ; $i++) { 
				?>
					<td>
					<div class="filtres">
						<input type="text" placeholder="Filtre <?php echo $i;?>" name="filtre_<?php echo $i;?>" id="filtre_<?php echo $i;?>" autocomplete="off"/>
						<select name="selection1" class="selections">
						<?php
							foreach($champs_actuels as $cle=>$valeur)
							{
							?>
								<option id="<?php echo $cle ?>" value="<?php echo $cle ?>" id="<?php echo $cle ?>"><?php echo $valeur ?></option>
							<?php
							}
							
						?>
						</select>
					</div>
				</td>
				<?php
					}
				?>
				
				
			</tr>
			<td >
				<div class="bloc_bouttons">
					<button id="btnAjouter" type="button" class="plus">+Ajouter un filtre</button>
					<input id="btnFiltrer" type="submit" value="Filtrer" class="important"/>
				</div>
				<div class="bloc_bouttons">
					<input type="text" id="date_min" name="date_min" placeholder="Date min"  autocomplete="off" />
					<input type="text" id="date_max" name="date_max" placeholder="Date max"  autocomplete="off" />
				</div>
			</td>
		</table>
		</center>
	</div>
</form>