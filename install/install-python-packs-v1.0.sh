#!/usr/bin/bash
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 
   exit 1
fi
echo 'Instalando pacotes para o sistema da maratona - pacotes do python'
pip3 install pandas
pip3 install mysqlclient