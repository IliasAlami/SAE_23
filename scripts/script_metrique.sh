#!/bin/bash

#E208

#Variable declaration

tE208=$(cat /home/alami/Desktop/donnees/E208/temperature.txt)
tE207=$(cat /home/alami/Desktop/donnees/E207/temperature.txt)
HTML208=$(cat /home/alami/Desktop/donnees/E208/temperature.txt | tail -n1)
HTML207=$(cat /home/alami/Desktop/donnees/E207/temperature.txt | tail -n1)

#Command that count the number of lines in this file
denominateur208=$(wc -l /home/alami/Desktop/donnees/E208/temperature.txt | cut -d ' ' -f1)
denominateur207=$(wc -l /home/alami/Desktop/donnees/E207/temperature.txt | cut -d ' ' -f1)


#Command that add values together
somme208=$(grep . /home/alami/Desktop/donnees/E208/temperature.txt | paste -sd+ | bc)
somme207=$(grep . /home/alami/Desktop/donnees/E207/temperature.txt | paste -sd+ | bc)

#This command will search the minimum
minimum208=$(cut -f1 -d "." /home/alami/Desktop/donnees/E208/temperature.txt | sort -n | head -1)
minimum207=$(cut -f1 -d "." /home/alami/Desktop/donnees/E207/temperature.txt | sort -n | head -1)

#This command will search the maximum
maximum208=$(cut -f1 -d "." /home/alami/Desktop/donnees/E208/temperature.txt | sort -n | tail -1)
maximum207=$(cut -f1 -d "." /home/alami/Desktop/donnees/E207/temperature.txt | sort -n | tail -1)

#This command will search the date
date_1_208=$(cat /home/alami/Desktop/donnees/E208/date.txt | tail -n1)
date_1_207=$(cat /home/alami/Desktop/donnees/E208/date.txt | tail -n1)

#This will put the values in the file
echo "Date :" $date_1_208 > /home/alami/Desktop/donnees/E208/metrique.txt
echo "Date :" $date_1_207 > /home/alami/Desktop/donnees/E207/metrique.txt

echo "Valeur :" $tE208 >> /home/alami/Desktop/donnees/E208/metrique.txt
echo "Valeur :" $tE207 >> /home/alami/Desktop/donnees/E207/metrique.txt
 
echo "Somme des valeurs :" $somme208 >> /home/alami/Desktop/donnees/E208/metrique.txt
echo "Somme des valeurs :" $somme207 >> /home/alami/Desktop/donnees/E207/metrique.txt

echo "Nombre des valeurs :" $denominateur208 >> /home/alami/Desktop/donnees/E208/metrique.txt
echo "Nombre des valeurs :" $denominateur207 >> /home/alami/Desktop/donnees/E207/metrique.txt

#Average calculation
moyenne208=$(bc <<<"scale=2; $somme208 / $denominateur208")
moyenne207=$(bc <<<"scale=2; $somme207 / $denominateur207")

#This will display the average calculation, the max and min values too
echo "Temperature moyenne :" $moyenne208 "C" >> /home/alami/Desktop/donnees/E208/metrique.txt
echo "Temperature moyenne :" $moyenne207 "C" >> /home/alami/Desktop/donnees/E207/metrique.txt

echo "Temperature max :" $maximum208 "C" >> /home/alami/Desktop/donnees/E208/metrique.txt
echo "Temperature max :" $maximum207 "C" >> /home/alami/Desktop/donnees/E207/metrique.txt

echo "Temperature min :" $minimum208 "C" >> /home/alami/Desktop/donnees/E208/metrique.txt
echo "Temperature min :" $minimum207 "C" >> /home/alami/Desktop/donnees/E207/metrique.txt
