#!/bin/sh

ansible-playbook -i hosts.ini playbooks/flush-redisserver.yml -u developer -k