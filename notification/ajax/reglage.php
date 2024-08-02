<?php
$reference="../../php/";
include("../../php/config.php");
foreach($_POST as $key=>$value)
{
	$$key=securiser($value);
}
if(isset($_POST["id"]))
{
	$date=formatter_date_inverse($date);
	$date=strtotime($date);
	if($element=='date_chauffeur'){	
		$final = date("Y-m-d", strtotime("+1 month", $date));	
	}
	else{
		$final = date("Y-m-d", strtotime("+1 year", $date));	

	}
	if(isset($date))
	{		
		if($bdd->query("UPDATE $table SET $element='$final' WHERE id=$id "))
		{		
			echo 1; //informations correctes
		}
		else echo "UPDATE $table SET $element='$final' WHERE id='$id'";
	}
	else echo -2;
}
else echo -1; //

?>