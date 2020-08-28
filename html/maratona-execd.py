import requests
import json
import getpass
from optparse import OptionParser
from time import sleep


# authenticate in the server
def initialize():
    #TODO
    return

# execute job
def exec_job(job):
    
    # get original problem

    return

# main function
def main():

    # parse command line args
    parser = OptionParser()
    parser.add_option("-u", "--url", type="string", dest="url", help="url de acesso ao sistema de juiz da maratona")
    parser.add_option("-v", "--verbose", action="store_true", dest="verbose", default=False, help="imprimir mensagens de debug")
    (opt, args) = parser.parse_args()

    # authenticate in the server
    initialize()

    # verify new jobs in loop
    while True:

        response = requests.get(opt.url + 'getjob.php')
        job = json.loads(response.text)
        if (opt.verbose): print("new_job: ", job)

        # execute job
        exec_job(job)

        # delay before getting new job
        sleep(5)

    return

if __name__ == "__main__":
    main()

