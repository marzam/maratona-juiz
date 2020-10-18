#!/usr/bin/python3
import hashlib
print(hashlib.md5(str('12345').encode('utf-8')).hexdigest())