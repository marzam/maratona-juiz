#!/usr/bin/python3
import pandas as pd
import hashlib
import MySQLdb as mysql
import sys
if __name__ == "__main__":
    print('Adicionando equipes')
    dbMaratona = mysql.connect(host="localhost",user="localuser", passwd="localuser",db="dbMaratona")
    cursor = dbMaratona.cursor()
    dbase = pd.read_csv('records.csv', delimiter=";", encoding='utf-8')
    for i in range(0, len(dbase)):
        r  = dbase.iloc[i]
        s_type = r['type']
        i_type = 0
        if s_type == 'team' :
            i_type = 1
        else :
            if s_type == 'judge':
                i_type = 0
            else:
                if s_type == 'node':
                    i_type = 2
                else:
                    print('Error i=on type')
                    sys.exit(-1)
        #m_facc = r['faccess']
        #sql = 'INSERT INTO login (name, username, password, type, email, actived) values ("{0:s}", "{1:s}", "{2:s}",  "{3:d}", "{4:s}","1");'.format(r['name'], r['username'],  r['email'],  i_type,  hashlib.md5(r['password']).hexdigest())
        sql = 'INSERT INTO login (name, username, email , type, password, actived) values ("{0}", "{1}", "{2}",  "{3}", "{4}","1");'.format(r['name'], r['username'],  r['email'],  i_type,  hashlib.md5(r['password']).hexdigest())
        
        cursor.execute(sql)
    
    result = cursor.fetchall()
    dbMaratona.commit()
    cursor.close()
    dbMaratona.close()