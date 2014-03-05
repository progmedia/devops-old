#!/bin/sh

ansible-playbook -i hosts.ini playbooks/deploy-staging-videogamer-com.yml -u ansible --private-key=~/.ssh/id_rsa -v