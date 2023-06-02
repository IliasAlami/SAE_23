#!/bin/bash

nombre_batiments=$(echo "SELECT COUNT (\`id_batiment\`) FROM \`sae23\`.\`batiment\`;" | /opt/lampp/bin/mysql -h localhost -u asuisse -pJuloto31 | sed -s 2p)

for ((i=0; i<$nombre_batiments; i++));
do
batiment=$(echo "SELECT nom FROM \`sae23\`.\`batiment\` LIMIT $i,1;" | /opt/lampp/bin/mysql -h localhost -u asuisse -pJuloto31 | sed -s 2p)

data=$(mosquitto_sub -h mqtt.iut-blagnac.fr -t "Student/by-room/$batiment/data" -C 1)
date=$(date "+%F")
horaire=$(date "+%X")
temp=$(echo "$data" | jq '.[0].temperature')
co2=$(echo "$data" | jq '.[0].co2')
capteur=$(echo "$data" | jq '.[1].devEUI')

echo "INSERT INTO sae23.mesure(\`date\`, \`horaire\`, \`valeur\`, \`id_capteur\`) VALUES ('$date', '$horaire', '$temp', '$capteur');" | /opt/lampp/bin/mysql -h localhost -u asuisse -pJuloto31
echo "INSERT INTO sae23.mesure(\`date\`, \`horaire\`, \`valeur\`, \`id_capteur\`) VALUES ('$date', '$horaire', '$co2', '$capteur');" | /opt/lampp/bin/mysql -h localhost -u asuisse -pJuloto31
done

