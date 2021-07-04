#!/usr/bin/bash
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root"
   exit 1
fi
echo 'Instalando pacotes para o sistema da maratona'
apt-get install build-essential gcc g++ rsync -y
apt-get install python3-pip -y
apt-get install git -y
apt-get install python3-dev default-libmysqlclient-dev  -y
apt-get install apache2 -y
apt-get install mysql-server -y
apt-get install php libapache2-mod-php php-mysql -y
apt-get install php-xml -y
apt-get install python3-pip -y
apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl -y
mysql_secure_installation
