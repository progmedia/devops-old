#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-webserver.yml -u ansible --private-key=~/.ssh/id_rsa