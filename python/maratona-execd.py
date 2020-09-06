#!/home/mzamith/Apps/anaconda3/bin/python
import requests
import os
import timeit
import glob
import shutil
import json
import getpass
import sys
from optparse import OptionParser
from time import sleep
from subprocess import PIPE, Popen

# python3 maratona-execd.py -u http://192.168.1.162/ -v -n node01
# -p <senha>

# authenticate in the server
def initialize(opt):
    
    if opt.pw == None:
        try: 
            opt.pw = getpass.getpass(prompt='Senha do usuário {}:'.format(opt.name))
        except Exception as error: 
            print('ERROR', error) 

    # update problem time in server
    data = {'nameLogin': opt.name,
            'namePassed': opt.pw}
    response = opt.session.post(url = opt.url+'dologin.php', data = data)

    if response.text == 'Ok':
        print(response.text)
    else:
        print('Erro de autenticação: nome de usuário e/ou senha inválido(s).')
        print(response.text)
        exit()

    return

# find src file
def find_mkfile(path):
    for root, dirs, files in os.walk(path):
        for name in files:
            if name == "Makefile":
                return root

# exec the binary file
def exec(binfile, param, mtimeout):
    str = '{0} {1}'.format(binfile, param)
    pprocess = Popen(str, shell=True, stdout=PIPE, stderr=PIPE)
    print("    Script PID:", os.getpid())
    print('Executing file:', pprocess.pid)
    print('    Timeout is: ', mtimeout, ' second(s)')

    stdout = b''
    stderr = b''
    a = 0
    b = 0
    elapsedtime = 0
    try:
        if mtimeout >= 0:
            a = timeit.default_timer()
            stdout, stderr = pprocess.communicate(timeout=mtimeout)
            b = timeit.default_timer()
        else:
            a = timeit.default_timer()
            stdout, stderr = pprocess.communicate()
            b = timeit.default_timer()
    except TimeoutExpired:
        Popen.kill(pprocess)
        a = 0
        b = 0
        stderr = b'timeout'

    elapsedtime = b - a

    print('Executed file:', pprocess.pid, ' elapsedtime: ', elapsedtime, ' in seconds')
    if len(stdout) > 0:
        str_stdout = '\t\t' + stdout.decode('utf-8').replace('\n', '\n\t\t')
        print('\tOUT:')
        print(str_stdout)

    if len(stderr) > 0:
        str_sterr = '\t\t' + stderr.decode('utf-8').replace('\n', '\n\t\t')
        print('\tERR:')
        print(str_sterr)

    return elapsedtime

# Compile project in according to created makefile file
def compile_make(path, clean = False):
    flag_ok = 1
    cur_path = os.getcwd()
    source_path = path
    os.chdir(source_path)
    if clean:
        pcompile = Popen('make -f Makefile clean', shell=True, stdout=PIPE, stderr=PIPE)
    else:
        pcompile = Popen('make -f Makefile', shell=True, stdout=PIPE, stderr=PIPE)

    stdout, stderr = pcompile.communicate()

    if not clean:
        print('Compiling file')
    else:
        print('Cleaning file')

    if len(stdout) > 0:
        str_stdout = '\t\t' + stdout.decode('utf-8').replace('\n', '\n\t\t')
        print('\tOUT:')
        print(str_stdout)

    if len(stderr) > 0:
        str_sterr = '\t\t' + stderr.decode('utf-8').replace('\n', '\n\t\t')
        print('\tERR:')
        print(str_sterr)

    os.chdir(cur_path)

    files = glob.glob(path + '/*')
    binfile = max(files, key=os.path.getctime)

    return binfile

# execute job
def exec_job(opt, job):
    
    # make temp dir
    if os.path.exists('tmp'):
        shutil.rmtree('tmp')
    os.mkdir('tmp')
    pwd = os.getcwd()
    tmpdir = os.path.join(pwd, 'tmp')

    # compile and exec original problem if needed
    if float(job['time']) < 0:
        
        response = opt.session.get(opt.url + job['path'])
        srczip = os.path.join(tmpdir, 'source.tar.gz')
        with open(srczip, "wb") as f:
            f.write(response.content)
        shutil.unpack_archive(srczip, tmpdir)

        # find src file
        srcpath = find_mkfile(tmpdir)
        binfile = compile_make(srcpath)

        # execute
        probtime = exec(binfile, job['param'], 30)

        # clean tmp folder
        os.remove(srczip)
        shutil.rmtree(srcpath)

        # update problem time in server
        data = {'prob_id': job['problem_id'], 'time': probtime, 'nameLogin': opt.name, 'namePassed': opt.pw}
        response = opt.session.post(url = opt.url+'setprobtime.php', data = data)
        print(response.text)

    else:
        probtime = float(job['time'])
        print(probtime)

    # compile and exec submission
    response = opt.session.get(opt.url + job['file'])
    srczip = os.path.join(tmpdir, 'source.tar.gz')
    
    with open(srczip, "wb") as f:
        f.write(response.content)


    shutil.unpack_archive(srczip, tmpdir)
    
    # find src file
    srcpath = find_mkfile(tmpdir)
    binfile = compile_make(srcpath)

    # execute

    subtime = exec(binfile, job['param'], 30)

    # clean tmp folder
    os.remove(srczip)
    shutil.rmtree(srcpath)

    # update problem time in server
    data = {'id': job['id'], 'prob_id': job['problem_id'], 'time': subtime, 'nameLogin': opt.name, 'namePassed': opt.pw, 'answer': 'accepted'}
    
    response = opt.session.post(url = opt.url+'setsubtime.php', data = data)
    print(response.text)

   # os.rmdir('tmp')

   

# main function
def main():

    # parse command line args
    parser = OptionParser()
    parser.add_option("-u", "--url", type="string", dest="url", help="url de acesso ao sistema de juiz da maratona")
    parser.add_option("-n", "--username", type="string", dest="name", help="nome de usuário para login no sistema de juiz da maratona")
    parser.add_option("-p", "--password", type="string", dest="pw", default=None, help="senha para login no sistema de juiz da maratona")
    parser.add_option("--compiler-path", type="string", default="/usr/bin/gcc", dest="compiler", help="caminho para o compilador")
    parser.add_option("-v", "--verbose", action="store_true", dest="verbose", default=False, help="imprimir mensagens de debug")
    (opt, args) = parser.parse_args()

    # start session
    opt.session = requests.Session()
    
    # authenticate in the server
  
    #initialize(opt)
    # verify new jobs in loop
    while True:

        response = opt.session.get(opt.url + 'getjob.php')
        
        if response.ok and response.text != "":
            job = json.loads(response.text)
            if (opt.verbose): print("new_job: ", job)
            
            # execute job
            exec_job(opt, job)

        # delay before getting new job
        sys.exit(0)
        

   

if __name__ == "__main__":
    main()

