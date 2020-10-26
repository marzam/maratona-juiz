#!/usr/bin/bash
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 
   exit 1
fi
rsync -av --progress /home/localuser/sistema/maratona-juiz/html/  /var/www/html/
chown www-data.www-data -R  /var/www/html/