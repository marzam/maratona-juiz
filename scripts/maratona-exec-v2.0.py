#!/home/mzamith/Apps/anaconda3/bin/python
import difflib
import requests
import os
import timeit
import glob
import shutil
import json
import getpass
import sys
import subprocess
from optparse import OptionParser
from time import sleep
from subprocess import PIPE, Popen

# python3 ./maratona-execd.py  -u http://192.168.1.21/ -v -n node01 -p node01
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
    rootaux = None
    answer = 'no makefile'
    for root, dirs, files in os.walk(path):
        for name in files:
            if name == "Makefile":
                #return root, ''
                print(root)

                rootaux = root
                answer = ''
    return rootaux, answer



# exec the binary file
def exec(binfile, srcpath, param, mtimeout):
    cur_path = os.getcwd()
    source_path = srcpath
    os.chdir(source_path)

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
    except subprocess.TimeoutExpired:
        Popen.kill(pprocess)
        a = 1
        b = 0
        stderr = b'timeout'

    os.chdir(cur_path)
    elapsedtime = b - a
    a_stdout = ''
    print('Executed file:', pprocess.pid, ' elapsedtime: ', elapsedtime, ' in seconds')
    if len(stdout) > 0:
        str_stdout = '\t\t' + stdout.decode('utf-8').replace('\n', '\n\t\t')
        print('\tOUT:')
        print(str_stdout)
        a_stdout = stdout.decode('utf-8').replace('\n', '')

    if len(stderr) > 0:
        str_sterr = '\t\t' + stderr.decode('utf-8').replace('\n', '\n\t\t')
        print('\tERR:')
        print(str_sterr)

    return elapsedtime, a_stdout

# Compile project in according to created makefile file
def compile_make(path, clean = False):
    #flag_ok = 1
    answer = ''
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
        answer = 'compilation error'
        print('\tERR:')
        print(str_sterr)

    os.chdir(cur_path)

    files = glob.glob(path + '/*')
    binfile = max(files, key=os.path.getctime)

    return binfile, answer

def equal_bin (file1, file2):
    cmd = 'diff {} {}'.format(file1, file2)
    pprocess = Popen(cmd, shell=True, stdout=PIPE, stderr=PIPE)
    stdout = b''
    stderr = b''

    try:
        stdout, stderr = pprocess.communicate()
        output = stdout.decode('utf-8') 
    except subprocess.TimeoutExpired:
        Popen.kill(pprocess)
        stderr = b'wrong answer'
        output =  stderr.decode('utf-8') 

    return output

def equal (file1, file2):
    count = 0
    text1 = open(file1).readlines()
    text2 = open(file2).readlines()

    for line in difflib.unified_diff(text1, text2):
        count = count + 1

    if count == 0:
        return ''
    else:
        return 'wrong answer'
# execute job
def exec_job(opt, job):

    answer = ''
    # make temp dir
    if os.path.exists('tmp'):
        shutil.rmtree('tmp')
    os.mkdir('tmp')
    pwd = os.getcwd()
    tmpdir = os.path.join(pwd, 'tmp')

    # compile and exec original problem if needed
    '''
    if float(job['time']) < 0:

        response = opt.session.get(opt.url + job['file_prob'])
        srczip = os.path.join(tmpdir, 'source.tar.gz')
        with open(srczip, "wb") as f:
            f.write(response.content)
        shutil.unpack_archive(srczip, tmpdir)

        # find src file
        srcpath, anwser = find_mkfile(tmpdir)
        binfile, anwser = compile_make(srcpath)

        # execute
        probtime, answer = exec(binfile, srcpath, job['param'], -1)
        # clean tmp folder
        os.remove(srczip)
        shutil.rmtree(srcpath)

        # update problem time in server
        data = {'prob_id': job['problem_id'], 'time': probtime, 'nameLogin': opt.name, 'namePassed': opt.pw}
        response = opt.session.post(url = opt.url+'setprobtime.php', data = data)
        if (opt.verbose): print(response.text)

    else:
        '''
    
    probtime = float(job['time'])
    if (opt.verbose): print('Sequencial time:', probtime)

    # compile and exec submission
    response = opt.session.get(opt.url + job['file'])
    srczip = os.path.join(tmpdir, 'source.tar.gz')

    with open(srczip, "wb") as f:
        f.write(response.content)


    shutil.unpack_archive(srczip, tmpdir)

    # find src file
    srcpath, answer = find_mkfile(tmpdir)
    if answer != '':
        data = {'id': job['id'], 'nameLogin': opt.name, 'namePassed': opt.pw, 'answer': answer}
        if (opt.verbose): print(data)
        response = opt.session.post(url=opt.url + 'setsubtime.php', data=data)
        if (opt.verbose): print(response.text)
        return

    binfile, answer = compile_make(srcpath)
    if answer != '':
        data = {'id': job['id'], 'nameLogin': opt.name, 'namePassed': opt.pw, 'answer': answer}
        response = opt.session.post(url=opt.url + 'setsubtime.php', data=data)
        if (opt.verbose): print(response.text)
        return


    #check if the answer is equal to template
    auxtime, output_created = exec(binfile, srcpath, job['input'], probtime)

    
    answer = ''
    if job['stdout'].find('file') >= 0:
        file_template =  job['output']
        files = glob.glob(srcpath + '/*')
        file_created = max(files, key=os.path.getctime)

        #Download template answer        
        response = opt.session.get(opt.url + job['output'])
        srcfile = os.path.join(tmpdir, 'template.bin')
        with open(srcfile, "wb") as f:
            f.write(response.content)

        answer = equal_bin('template.bin', file_created)
        
    elif job['stdout'].find('stdout:') >= 0 :
        output_template = job['stdout'][7:]
        if output_template != output_created:
            answer = 'wrong answer'

    
    if answer != '':
        data = {'id': job['id'], 'nameLogin': opt.name, 'namePassed': opt.pw, 'answer': answer}
        if (opt.verbose): print(data)
        response = opt.session.post(url=opt.url + 'setsubtime.php', data=data)
        if (opt.verbose): print(response.text)
        if (opt.verbose): print('Answer is wrong or error')
        return
    else:
        if (opt.verbose): print('Answer is correct')


    # execute
    subtime, auxanswer = exec(binfile, srcpath, job['inputHPC'], probtime)

    os.remove(srczip)
    shutil.rmtree(srcpath)

    if subtime < 0.0:
        data = {'id': job['id'], 'nameLogin': opt.name, 'namePassed': opt.pw, 'answer': 'time out'}
        response = opt.session.post(url=opt.url + 'setsubtime.php', data=data)
        if (opt.verbose): print(response.text)
        return

    # clean tmp folder

    # update problem time in server
    data = {'id': job['id'], 'prob_id': job['problem_id'], 'time': subtime, 'nameLogin': opt.name, 'namePassed': opt.pw, 'answer': 'accepted'}
    response = opt.session.post(url = opt.url+'setsubtime.php', data = data)
    if (opt.verbose):print(response.text)

    #os.rmdir('tmp')



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
        sleep(5)
        print('Next')
        sys.exit(0)




if __name__ == "__main__":
    main()
