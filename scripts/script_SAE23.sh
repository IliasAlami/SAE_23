#!/bin/bash

##################################################################
# This script get MQTT data from sensors and update SQL database #
##################################################################

# Retrieve the total number of buildings in the sae23.batiment table
nombre_batiment=$(echo "SELECT COUNT(id_batiment) FROM sae23.batiment;" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot 2>/dev/null| tail -1)

# Loop through each building
for ((i=0; i<$nombre_batiment; i++)); do
    
    # Retrieve the id_batiment for the current iteration
    batiment=$(echo "SELECT id_batiment FROM sae23.batiment LIMIT $i,1;" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot  2>/dev/null| tail -1)

    ##echo  batiment $batiment
    
    # Retrieve the total number of rooms in the sae23.capteur table in a building
    nombre_room=$(echo "SELECT COUNT(salle) FROM sae23.capteur WHERE id_batiment=${batiment};" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot 2>/dev/null| tail -1)

    # Loop through each room in the current building
    for ((x=0; x<$nombre_room; x++)); do

   	 # Retrieve the salle value for the current building in sae23.capteur table
   	 room=$(echo "SELECT salle FROM sae23.capteur WHERE id_batiment=${batiment} LIMIT $x,1;" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot  2>/dev/null| tail -1)

   	 ##echo room $room

   	 # Subscribe to MQTT topic and get the latest data
   	 data=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t "Student/by-room/$room/data" -C 1)

   	 ##echo $data

   	 # Get the current system date and time
   	 date=$(date "+%F")
   	 horaire=$(date "+%X")

   	 # Extract temperature, CO2, and capteur values from the data
   	 temp=$(echo "$data" | jq '.[0].temperature')
   	 co2=$(echo "$data" | jq '.[0].co2')
   	 capteur=$(echo "$data" | jq '.[1].devEUI' | sed -e 's/"//g')

   	 ##echo "capteur "$capteur

   	 # Retrieve the type of the current sensor
   	 typeCapt=$(echo "SELECT type FROM sae23.capteur WHERE salle='${room}';" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot  2>/dev/null | tail -1)
   	 
   	 ##echo "type : $typeCapt"

   	 # Check the sensor type and insert value in the table sae23.mesure
   	 case $typeCapt in
   		 "temperature")
   			 echo "INSERT INTO sae23.mesure(date, horaire, valeur, id_capteur) VALUES ('$date', '$horaire', '$temp', '$capteur');" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot
   		 ;;
   		 "co2")
   			 echo "INSERT INTO sae23.mesure(date, horaire, valeur, id_capteur) VALUES ('$date', '$horaire', '$co2', '$capteur');" | /opt/lampp/bin/mysql -h localhost -u root -ppassroot
   		 ;;
   	 esac    
    done   	 
done