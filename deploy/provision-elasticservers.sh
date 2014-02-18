#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-elasticserver.yml -u ansible --private-key=~/.ssh/id_rsa