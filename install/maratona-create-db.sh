#!/usr/bin/bash
#DROP DATABASE dbMaratona apaga toda a base de dados
echo "Criando banco de dados - arquivo: [$1]"
echo "Usuário do mysql [$USER]"
echo "Crie o banco de dados no msysql: <CREATE DATABASE dbMaratona;>"
echo "antes de executar este script."
echo "ATENÇÃO: USE A SENHA DO MYSQL !!!!"
 mysql -p -u $USER dbMaratona < $1
