#!/usr/bin/python3
import pandas as pd
import hashlib
import MySQLdb as mysql
import sys
import smtplib
import random
def getNewPassword():
    s = "abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()?"
    passlen = 8
    p =  "".join(random.sample(s,passlen ))
    return p

def sendResetPassword(username, to_email, userPasswd):
        
    sender_email = "zamith.marcelo@yahoo.com"
    #password     = '102455PBC' 
    app_password = 'lrhlkkzkqpictzxe'
    msg = 'Subject: cadastro no sistema da maratona da ERAD-RJ\nTo: {}\nFrom: {}\n\nCadastro realizado com sucesso\nLink: https://www.dcc.ufrrj.br/maratona/login.php \nLogin: {}\nSenha: {}\n'.format(to_email, sender_email, username, userPasswd)

    smtpObj = smtplib.SMTP('smtp.mail.yahoo.com', 587)
    
    print('Hello', smtpObj.ehlo())
    print('Startls', smtpObj.starttls())
    print('Login', smtpObj.login(sender_email,  app_password))
    print('msg', msg)
    #print()

    smtpObj.sendmail(sender_email, to_email, msg)
    smtpObj.quit()

if __name__ == "__main__":
    print('Adicionando equipes')
    print('Arquivo: [', sys.argv[1], ']')
    dbMaratona = mysql.connect(host="localhost",user="localuser", passwd="localuser",db="dbMaratona")
    cursor = dbMaratona.cursor()
    dbase = pd.read_csv(sys.argv[1], delimiter=";", encoding='utf-8')
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
        userPasswd = getNewPassword()
        userPasswd_MD5 = hashlib.md5(str(userPasswd).encode('utf-8')).hexdigest()
        sql = 'INSERT INTO login (name, username, email , type, password, actived, fasscess, team_id) values ("{0}", "{1}", "{2}", "{3}", "{4}", "1","{5}","{6}");'.format(r['name'], r['username'],  r['email'],  i_type, userPasswd_MD5, r['faccess'], r['id_tem'])
        #sql = 'INSERT INTO login (name, username, email , type, password, actived, fasscess) values ("{0}", "{1}", "{2}", "{3}", "{4}", "1","{5}");'.format(r['name'], r['username'],  r['email'],  i_type,  r['password'], r['faccess'])
        #print(sql)
        cursor.execute(sql)
        sendResetPassword(r['username'], r['email'], userPasswd)
    result = cursor.fetchall()
    dbMaratona.commit()
    cursor.close()
    dbMaratona.close()
