#!/bin/sh

ansible-playbook -i hosts.ini playbooks/backup-staging-elasticsearch.yml -u ansible --private-key=~/.ssh/id_rsa -v