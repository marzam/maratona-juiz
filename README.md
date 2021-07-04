# maratona-juiz

 - In order to enable php mod in public_html folder, following the tutorial in https://wiki.ubuntu.com/UserDirectoryPHP
 This tutorial requires to edit file /etc/apache2/mods-available/php7.4.conf as root and change:
<IfModule mod_userdir.c>
    <Directory /home/$USERNAME/public_html>
        php_admin_flag engine On
    </Directory>
</IfModule>
~                                                                                                                  
~
Create localuser user in mysql:
CREATE USER 'localuser'@'localhost' IDENTIFIED BY 'localuser';
GRANT ALL PRIVILEGES ON * . * TO 'localuser'@'localhost';
FLUSH PRIVILEGES;

- phpmyadmin is not installed by default. In order to install, execute:
