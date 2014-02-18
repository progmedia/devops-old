#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-redisserver.yml -u ansible --private-key=~/.ssh/id_rsa