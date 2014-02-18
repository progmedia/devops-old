#!/bin/sh

ansible-playbook -i hosts.ini playbooks/flush-redisserver.yml -u developer --private-key=~/.ssh/id_rsa