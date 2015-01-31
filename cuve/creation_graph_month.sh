#!/bin/bash
DIR="/home/webide/repositories/my-pi-projects/cuve"

JOUR=$(date '+%d-%m-%Y %H-%M-%S')

# Affichage en degre C
ECHELLE="cm"
VOLUME="litres"

#Choix des couleurs
COUL_ECHELLE="#000099" COUL_VOLUME="#FF0000"


#Graphs pour 3 mois
rrdtool graph $DIR/h_cuve_3m.png --start -25w  --title="Hauteur d'eau sur 3 mois" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf

#Graphs pour 6 mois
#rrdtool graph $DIR/h_cuve_6m.png --start -25w  --title="Hauteur d'eau sur 6 mois" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" 
#rrdtool graph $DIR/v_cuve_6m.png --start -25w  --title="Volume sur 6 mois" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf" 

#Graphs par an
#rrdtool graph $DIR/h_cuve_1y.png --start -1y  --title="Hauteur d'eau sur 1 an" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf"
#rrdtool graph $DIR/v_cuve_1y.png --start -1y  --title="Volume sur 1 an" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf"

#Transfert des données sur le serveur We
#chown www-data:www-data $source
#sudo mv $source $destination
