 <?php

$reference="../../php/";
include("../../php/config.php");

foreach($_POST as $key=>$value)
{
	$$key=securiser($value);
}
if(isset($_POST["element"]))
{
		

	if($element=='date_chauffeur'){
			$ajouter_delai= "UPDATE $table SET $element=DATE_ADD($element,INTERVAL 1 MONTH) WHERE  $element <= '$fin'";
			
		}
				else{
					$ajouter_delai="UPDATE $table SET $element=DATE_ADD($element,INTERVAL 1 YEAR) WHERE  $element <= '$fin'";

				}
	
	if(isset($table))
	{		
		if($bdd->query("$ajouter_delai"))
		{		
		
			echo 1; //informations correctes
		}
		else echo -3;//informations incorrectes
	}
	else echo -2;
}
else echo -1; //

?>