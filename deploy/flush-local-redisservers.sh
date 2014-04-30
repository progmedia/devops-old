#!/bin/sh

ansible-playbook -i hosts.ini playbooks/flush-local-redisserver.yml -u vagrant --private-key=~/.vagrant.d/insecure_private_key -v