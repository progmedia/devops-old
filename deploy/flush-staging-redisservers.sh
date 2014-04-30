#!/bin/sh

ansible-playbook -i hosts.ini playbooks/flush-staging-redisserver.yml -u ansible --private-key=~/.ssh/id_rsa