#!/usr/bin/env python3

"""
Last modified: 18.05.10 02:20:19
Hash: b75c5dce8ed5ee2589ed4ab4cba08afa1ed0eb00
"""
from datetime import datetime
from hashlib import sha1
from os import stat
from os.path import isfile
from re import compile, sub
from subprocess import Popen, PIPE

TIME_FORMAT = '%y.%m.%d %H:%M:%S'
status_pattern = compile(r"^(bin/)|(.*\.(php|py|js|scss|conf|json|sql))$")
last_modified_pattern = compile(
    r"Last *[Mm]odified *: *(\d{2}[-.]\d{2}[-.]\d{2} \d{2}:\d{2}:\d{2})")
hash_pattern = compile(r"Hash *: *([a-f0-9]{40})")
zero_hash = 'Hash: ' + '000000000000000000000000000000000000'


def read_run(*args, **env):
    with Popen(args, stdout=PIPE, env=env) as p:
        return p.stdout.read().decode('utf-8')


def git(*args, **env):
    return read_run('git', *args, **env).split("\n")


for line in git('diff', '--name-only'):
    filename = line.strip()
    m = status_pattern.match(filename)
    if status_pattern.match(filename) and isfile(filename):
        info = stat(filename)
        t = datetime.fromtimestamp(info.st_mtime).strftime(TIME_FORMAT)
        s = None
        with open(filename, encoding='utf-8') as f:
            s = f.read()
        if s:
            is_changed = True
            moh = hash_pattern.findall(s)
            s = sub(hash_pattern, zero_hash, s)
            if len(moh) > 0:
                oh = sha1(s.encode('utf-8')).hexdigest()
                if moh[0] == oh:
                    is_changed = False
            if is_changed:
                s = sub(last_modified_pattern,
                        'Last modified: ' + t, s)
                h = sha1(s.encode('utf-8')).hexdigest()
                s = s.replace(zero_hash, 'Hash: ' + h)
                with open(filename, encoding='utf-8', mode='w') as f:
                    f.write(s)
