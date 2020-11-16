#!/usr/bin/bash
SERVER='https://www.dcc.ufrrj.br/maratona/'
SERVER_USER='node02'
SERVER_PASSWORD='node02'
WORK_DIR = '/online-judge/'
#while :
#do
	#echo "$SERVER, $SERVER_USER, $SERVER_PASSWORD"
    ./maratona-exec-v2.2.py -u $SERVER -v -n $SERVER_USER -p $SERVER_PASSWORD 
 #   sleep 5
#done

 #