#!/bin/bash

#E208

#Variable declaration

tE208=$(cat /home/alami/Desktop/SAE_15/donnees/E208/temperature.txt)
tE207=$(cat /home/alami/Desktop/SAE_15/donnees/E207/temperature.txt)
HTML208=$(cat /home/alami/Desktop/SAE_15/donnees/E208/temperature.txt | tail -n1)
HTML207=$(cat /home/alami/Desktop/SAE_15/donnees/E207/temperature.txt | tail -n1)

#Command that count the number of lines in this file
denominateur208=$(wc -l /home/alami/Desktop/SAE_15/donnees/E208/temperature.txt | cut -d ' ' -f1)
denominateur207=$(wc -l /home/alami/Desktop/SAE_15/donnees/E207/temperature.txt | cut -d ' ' -f1)


#Command that add values together
somme208=$(grep . /home/alami/Desktop/SAE_15/donnees/E208/temperature.txt | paste -sd+ | bc)
somme207=$(grep . /home/alami/Desktop/SAE_15/donnees/E207/temperature.txt | paste -sd+ | bc)

#This command will search the minimum
minimum208=$(cut -f1 -d "." /home/alami/Desktop/SAE_15/donnees/E208/temperature.txt | sort -n | head -1)
minimum207=$(cut -f1 -d "." /home/alami/Desktop/SAE_15/donnees/E207/temperature.txt | sort -n | head -1)

#This command will search the maximum
maximum208=$(cut -f1 -d "." /home/alami/Desktop/SAE_15/donnees/E208/temperature.txt | sort -n | tail -1)
maximum207=$(cut -f1 -d "." /home/alami/Desktop/SAE_15/donnees/E207/temperature.txt | sort -n | tail -1)

#This command will search the date
date_1_208=$(cat /home/alami/Desktop/SAE_15/donnees/E208/date.txt | tail -n1)
date_1_207=$(cat /home/alami/Desktop/SAE_15/donnees/E208/date.txt | tail -n1)

#This will put the values in the file
echo "Date :" $date_1_208 > /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Date :" $date_1_207 > /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt

echo "Valeur :" $tE208 >> /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Valeur :" $tE207 >> /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt
 
echo "Somme des valeurs :" $somme208 >> /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Somme des valeurs :" $somme207 >> /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt

echo "Nombre des valeurs :" $denominateur208 >> /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Nombre des valeurs :" $denominateur207 >> /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt

#Average calculation
moyenne208=$(bc <<<"scale=2; $somme208 / $denominateur208")
moyenne207=$(bc <<<"scale=2; $somme207 / $denominateur207")

#This will display the average calculation, the max and min values too
echo "Temperature moyenne :" $moyenne208 "C" >> /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Temperature moyenne :" $moyenne207 "C" >> /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt

echo "Temperature max :" $maximum208 "C" >> /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Temperature max :" $maximum207 "C" >> /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt

echo "Temperature min :" $minimum208 "C" >> /home/alami/Desktop/SAE_15/donnees/E208/metrique.txt
echo "Temperature min :" $minimum207 "C" >> /home/alami/Desktop/SAE_15/donnees/E207/metrique.txt




#The following code is for the web site:


echo "<!doctype html>
<html lang=\"fr\">
<head>
  <meta charset=\"utf-8\">
  <title>Données de la salle E207 et E208</title>
  <link rel=\"stylesheet\" href=\"style.css\">
  <script src=\"script.js\"></script>
</head>
<body>

	<table>

		<caption> Relevé de températures <caption>
		<tr>
			<th>Pièces</th> <th>Température</th> <th>Date & heure</th>
		</tr>

		<tr>
			<td>E208</td> <td>$HTML208</td> <td>$date_1_208</td> 
		</tr>

		<tr>
			<td>E207</td> <td>$HTML207</td> <td>$date_1_207</td>
		</tr>

	</table>

</br></br>

<p>Nombre de valeurs pour la salle E208: $denominateur208 </br>
Moyenne de température de la salle E208: $moyenne208 </br>
Température maximum de la salle E208: $maximum208 </br>
Température minimum de la salle E208: $minimum208 </br>
</p>

</br></br>

<p>Nombre de valeurs pour la salle E207: $denominateur207 </br>
Moyenne de température de la salle E207: $moyenne207 </br>
Température maximum de la salle E207: $maximum207 </br>
Température minimum de la salle E207: $minimum207 </br>
</p>




</body>
</html>" > /home/alami/Desktop/SAE_15/site_web/index.html





curl -u 3963408:
