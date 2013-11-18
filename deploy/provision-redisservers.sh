#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-redisserver.yml -u developer -k -K