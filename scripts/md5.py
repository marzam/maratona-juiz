#!/usr/bin/python3
import hashlib
print(hashlib.md5(str('node02').encode('utf-8')).hexdigest())