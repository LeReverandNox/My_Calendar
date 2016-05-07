<?php
function generate_content($year, $month)
{
	$d = 1;

		$first_day = mktime(0,0,0,$month,1,$year);
		$first_day = getdate($first_day);
		$first_day = $first_day['wday'];
		$number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		// Remplissage de la premiere ligne
		$content[0] = "|";
		if ($first_day == 0)
		{
			$first_day = 7;
		}
		$content[0] .= str_repeat("    |", $first_day - 1);
		for ($i = $first_day ; $i <= 7; $i++)
		{ 
			$content[0] .= "  $d |";
			$d++;
		}

		// Remplissage des lignes intermédiaires
		for ($i=1; $i < 6; $i++)
		{ 
			$content[$i] = "|";
			for ($j=0; $j < 7; $j++)
			{ 
				if ($d < 10)
				{
					$content[$i] .= "  $d |";
				}
				else
				{
					$content[$i] .= " $d |";
				}
				$d++;
				if ($d == $number_of_days + 1)
					break;
			}
			if ($d == $number_of_days + 1)
			break;
		}

		// Remplissage de la dernière ligne
		$last_row = array_pop($content);

		while (strlen($last_row) < 36)
		{
			$last_row .= "    |";
		}
		array_push($content, $last_row);

	return $content;
}

function print_calendar($year, $month, $content)
{
	$mois = array("Janvier",
				"Février",
				"Mars",
				"Avril",
				"Mai",
				"Juin",
				"Juillet",
				"Aout",
				"Septembre",
				"Octobre",
				"Novembre",
				"Décembre");

	$MY = $mois[$month - 1]. " " . $year;
	$lengthMY = strlen($MY);

	if (preg_match("/^.*é+.*$/", $MY))
	{
		$right = (32 - ($lengthMY) + 3)/2;
	}
	else
	{
		$right = (32 - ($lengthMY) + 1)/2;
	}

	$right = str_repeat(" ", $right);
	$left = (32 - $lengthMY) / 2;
	$left = str_repeat(" ", $left);

	// Création de l'entête du calendrier
	echo "====================================" . "\n";
	echo "||". $left . $MY . $right ."||" . "\n";
	echo "====================================" . "\n";
	echo "| Lu | Ma | Me | Je | Ve | Sa | Di |" . "\n";
	echo "------------------------------------" . "\n";

	// Remplissage du contenu
	foreach ($content as $week)
	{
		echo $week . "\n";
		echo "------------------------------------" . "\n";
	}
}

function print_calendar_year($year, $month, $content)
{
	$mois = array("Janvier",
				"Février",
				"Mars",
				"Avril",
				"Mai",
				"Juin",
				"Juillet",
				"Aout",
				"Septembre",
				"Octobre",
				"Novembre",
				"Décembre");

	$MY = $mois[$month - 1]. " " . $year;
	$lengthMY = strlen($MY);

	if (preg_match("/^.*é+.*$/", $MY))
	{
		$right = (32 - ($lengthMY) + 3)/2;
	}
	else
	{
		$right = (32 - ($lengthMY) + 1)/2;
	}

	$right = str_repeat(" ", $right);
	$left = (32 - $lengthMY) / 2;
	$left = str_repeat(" ", $left);

	// Création de l'entête du calendrier
	echo "====================================" . "\n";
	echo "||". $left . $MY . $right ."||" . "\n";
	echo "====================================" . "\n";
	echo "| Lu | Ma | Me | Je | Ve | Sa | Di |" . "\n";
	echo "------------------------------------" . "\n";

	//Remplissatge du contenu
	foreach ($content as $week)
	{
		echo $week . "\n";
		echo "------------------------------------" . "\n";
	}
	echo "\n";
	return true;
}

do
{
	echo "Choisissez une date : ";
	$date = readline();	

	if (preg_match("/^(0[1-9]|1[012])\s\d{4}$/", $date))
	{
		$arr = explode(" ", $date);
		$arr = array_reverse($arr);
		$date = implode("-", $arr);
	}
	elseif (preg_match("/^\d{4}$/", $date))
	{
		for ($i=1; $i <= 12; $i++)
		{ 
			$content = generate_content($date, $i);
			print_calendar_year($date, $i, $content);
		}
	}

	if (preg_match("/^\d{4}-(0[1-9]|1[012])$/", $date))
	{	
		$arr = explode("-", $date);
		$content = generate_content($arr[0], $arr[1]);
		print_calendar($arr[0], $arr[1], $content);
	}
} while (1);

?>