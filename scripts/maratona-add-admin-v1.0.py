#!/usr/bin/python3
import pandas as pd
import hashlib
import MySQLdb as mysql
import sys
db_host = 'localhost'
db_user = 'localuser'
db_pass = 'localuser'
db_name = 'dbMaratona'

m_user   = 'admin'
m_pass   = 'admin'
m_team   = 'Administrador'
m_email  = 'mzamith.prof@gmail.com'
m_passMD5 = ''

if __name__ == "__main__":
    m_passMD5 = hashlib.md5(str(m_pass).encode('utf-8')).hexdigest()
    print('Adicioando usuário [admin]:')
    print('\t    usuário:', m_user)
    print('\t      senha:', m_pass)
    print('\t  senha MD5:', m_passMD5)
    team_id = -1
    only_print = 0
    if len(sys.argv) > 1:
        only_print = 1

    if only_print == 0:
        dbMaratona = mysql.connect(host=db_host,user=db_user, passwd=db_pass,db=db_name)
        cursor = dbMaratona.cursor()
        sql = 'INSERT INTO teams (name) values ("{0}");'.format(m_team)
        print('SQL: ', sql)
        cursor.execute(sql)
        dbMaratona.commit()
        print('Time Administrador cadastrado')

        sql = 'SELECT id FROM teams WHERE name ="{0}";'.format(m_team)
        print('SQL: ', sql)

        ret = cursor.execute(sql)
        if ret != 1:
            print('[ERROR] SQL: ', ret);
            sys.exit(-1);
        row = cursor.fetchone()
        team_id = row[0];
        if team_id == -1:
            print('[ERROR] Team ID : ', ret);
            sys.exit(-1);


    sql = 'INSERT INTO login (name, username, email, type, password, actived, fasscess, team_id) values ("Administrador", "{0}", "{1}", "0", "{2}", "1", "0","{3}");'.format(m_user,  m_email, m_passMD5, team_id)
    print(sql)

    if only_print == 0:
        cursor.execute(sql)
        dbMaratona.commit()
        cursor.close()
        dbMaratona.close()
        print('Insert into database')
