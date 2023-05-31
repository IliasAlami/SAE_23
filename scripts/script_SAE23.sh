#!/bin/bash


#Mosquitto command in linux to retrieve the data from the broker
E208=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t Student/by-room/E208/data -C 1)
E207=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t Student/by-room/E207/data -C 1)
C004=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t Student/by-room/C004/data -C 1)
C006=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t Student/by-room/C006/data -C 1)

#Command that allow me to extract only the temperature in the room E208
temp_208=$(echo "$E208" | jq '.[0].temperature')
#Command that allow me to extract only the room
salle_208=$(echo "$E208" | jq '.[1].room')

#Command that allow me to extract only the temperature in the room E208
temp_207=$(echo "$E207" | jq '.[0].temperature')
#Command that allow me to extract only the room
salle_207=$(echo "$E207" | jq '.[1].room')

#Command that allow me to extract only the temperature in the room E208
co2_004=$(echo "$C004" | jq '.[0].co2')
#Command that allow me to extract only the room
salle_004=$(echo "$C006" | jq '.[1].room')

#Command that allow me to extract only the temperature in the room E208
co2_006=$(echo "$C004" | jq '.[0].co2')
#Command that allow me to extract only the room
salle_006=$(echo "$C006" | jq '.[1].room')



#Command that display the date when we got the data
date=$(date "+%d-%m-%Y %T")


echo $temp_208 >> /home/alami/Desktop/donnees/E208/temperature.txt
echo $temp_207 >> /home/alami/Desktop/donnees/E207/temperature.txt
echo $date >> /home/alami/Desktop/donnees/E208/date.txt
echo $date >> /home/alami/Desktop/donnees/E207/date.txt

echo $co2_004 >> /home/alami/Desktop/donnees/C004/co2.txt
echo $co2_006 >> /home/alami/Desktop/donnees/C006/co2.txt
echo $date >> /home/alami/Desktop/donnees/C004/date.txt
echo $date >> /home/alami/Desktop/donnees/C006/date.txt
