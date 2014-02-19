#!/bin/sh

ansible-playbook -i hosts.ini playbooks/deploy-staging-api-pro-gmedia-com.yml -u ansible --private-key=~/.ssh/id_rsa -v