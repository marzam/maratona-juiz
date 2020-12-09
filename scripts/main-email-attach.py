#!/usr/bin/python3
import smtplib
import random
import hashlib
import MySQLdb as mysql
import sys

def sendResetPassword(to_email):

    sender_email = "zamith.marcelo@yahoo.com"
    #password     = '102455PBC' 
    app_password = 'lrhlkkzkqpictzxe'
    msg = 'Subject: certificado ERAD-RJ 2020\nTo: {}\nFrom: {}\n\nPrezado(a),\n Em anexo o(s) certificado(s).\n Atenciosamente, \nUbiratam e Marcelo'.format(to_email, sender_email)

    smtpObj = smtplib.SMTP('smtp.mail.yahoo.com', 587)
    
    print('Hello', smtpObj.ehlo())
    print('Startls', smtpObj.starttls())
    print('Login', smtpObj.login(sender_email,  app_password))
    print('msg', msg)
    #print()

    smtpObj.sendmail(sender_email, to_email, msg)
    smtpObj.quit()

if __name__ == "__main__":
    email    = sys.argv[1]
    sendResetPassword( email)
#sendResetEmail('Hal9000', 'zamith.marcelo@gmail.com')