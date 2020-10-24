#!/opt/anaconda3/bin/python3
import smtplib
import random
import hashlib
import MySQLdb as mysql
import sys
def getNewPassword():
    s = "abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()?"
    passlen = 8
    p =  "".join(random.sample(s,passlen ))
    return p

def sendResetPassword(username, to_email):
    userPasswd = getNewPassword()
    userPasswd_MD5 = hashlib.md5(str(userPasswd).encode('utf-8')).hexdigest()
    
    #conect into db
    dbMaratona = mysql.connect(host="localhost",user="localuser", passwd="localuser",db="dbMaratona")
    cursor = dbMaratona.cursor()
    sql = 'UPDATE login SET login.password = "{}", login.fasscess = "1" WHERE login.username = "{}" AND login.email = "{}";'.format(userPasswd_MD5, username, to_email)
    result = cursor.execute(sql)
    cursor.fetchall()
    print('SQL: ', sql, ' return: ', result)
    dbMaratona.commit()
    cursor.close()
    dbMaratona.close()

    if result != 1 :
        print('ERROR in sql')
        sys.exit(-1)
        
    sender_email = "zamith.marcelo@yahoo.com"
    #password     = '102455PBC' 
    app_password = 'lrhlkkzkqpictzxe'
    msg = 'Subject: reset password\nTo: {}\nFrom: {}\n\nLogin: {}\nNew password: {}\n'.format(to_email, sender_email, username, userPasswd)

    smtpObj = smtplib.SMTP('smtp.mail.yahoo.com', 587)
    
    print('Hello', smtpObj.ehlo())
    print('Startls', smtpObj.starttls())
    print('Login', smtpObj.login(sender_email,  app_password))
    print('msg', msg)
    #print()

    smtpObj.sendmail(sender_email, to_email, msg)
    smtpObj.quit()

if __name__ == "__main__":
    username = sys.argv[1]
    email    = sys.argv[2]
    sendResetPassword(username, email)
#sendResetEmail('Hal9000', 'zamith.marcelo@gmail.com')