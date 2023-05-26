#!/bin/bash


#Mosquitto command in linux to retrieve the data from the broker
E208=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t Student/by-room/E208/data -C 1)
E207=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t Student/by-room/E207/data -C 1)

#Command that allow me to extract only the temperature in the room E208
temp_208=$(echo "$E208" | jq '.[0].temperature')
#Command that allow me to extract only the room
salle_208=$(echo "$E208" | jq '.[1].room')

#Command that allow me to extract only the temperature in the room E208
temp_207=$(echo "$E207" | jq '.[0].temperature')
#Command that allow me to extract only the room
salle_207=$(echo "$E207" | jq '.[1].room')

#Command that display the date when we got the data
date=$(date "+%d-%m-%Y %T")

#Right all the command's results of the room E208 in a text file 
echo "En" $salle_208 "le" $date ", la temperature etait de:" $temp_208 "degré celcius" >> /home/alami/Desktop/donnees/E208/resultat.txt

#Right all the command's results of the room E207 in a text file 
echo "En" $salle_207 "le" $date ", la temperature etait de:" $temp_207 "degré celcius" >> /home/alami/Desktop/donnees/E207/resultat.txt


echo $temp_208 >> /home/alami/Desktop/donnees/E208/temperature.txt
echo $temp_207 >> /home/alami/Desktop/donnees/E207/temperature.txt
echo $date >> /home/alami/Desktop/donnees/E208/date.txt
echo $date >> /home/alami/Desktop/donnees/E207/date.txt
