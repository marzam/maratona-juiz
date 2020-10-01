#!/usr/bin/python3
#   pip3 install mysqlclient
#   apt-get install python3-dev default-libmysqlclient-dev build-essential
import MySQLdb as mysql
import sys
import os
import shutil
import glob
import hashlib

print('ATENÇÃO:')
print('\tExibindo os usuários cadastrados')
dbMaratona = mysql.connect(host="localhost",user="localuser", passwd="localuser",db="dbMaratona")
cursor = dbMaratona.cursor()
number_of_rows = cursor.execute("SELECT * FROM login;")
result = cursor.fetchall()
mType = ''
for i in range(0, len(result)):
    if result[i][4] == 0 :
        mType = 'Judged'
    else:
        if result[i][4] == 1 :
            mType = 'Marathonist'
        else:
            if result[i][4] == 2 :
                mType = 'Agent Judged'
            else:
                mType = 'Unknown'

    print('      ID:', result[i][0])
    print('username:', result[i][1])
    print('password:', result[i][2])
    print('    name:', result[i][3])
    print('    type:', result[i][4], '\t', mType)
    print('  e-mail:', result[i][5])
    print('  Active:', result[i][6])
    print('-------------------------------------------------------------')


cursor.close()
dbMaratona.close()

print( hashlib.md5(b'12345').hexdigest() )