#!/usr/bin/python3
#   pip3 install mysqlclient
#   apt-get install python3-dev default-libmysqlclient-dev build-essential
import MySQLdb as mysql
import sys
import os
import shutil
import glob
source_path = '/j-files/answers/*.tar.gz'


print('ATENÇÃO:')
print('\tNecessário executar como root este script')
print('\tEste script apaga todos os registros de problemas ')
print('\t****Não é feito nenhum backup dos registros ou arquivos enviados')
inputword = input('Deseja realmente apagar (SIM/não) ? \n')
if inputword != 'SIM':
    sys.exit(0)


print('Apagando registros da base de dados')
dbMaratona = mysql.connect(host="localhost",user="localuser", passwd="localuser",db="dbMaratona")
cursor = dbMaratona.cursor()
number_of_rows = cursor.execute("DELETE FROM problem ;")
result = cursor.fetchall()
number_of_rows = cursor.execute("ALTER TABLE problem  AUTO_INCREMENT = 1 ;")
result = cursor.fetchall()
dbMaratona.commit()
cursor.close()
dbMaratona.close()

print('Apagando arquivos do diretório de problemas')

for file in glob.glob(source_path):
    print(file)
    os.remove(file)
