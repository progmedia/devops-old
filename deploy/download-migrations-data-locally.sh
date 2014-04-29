#!/bin/sh

ansible-playbook -i hosts.ini playbooks/download-migrations-data-locally.yml -u ansible --private-key=~/.ssh/id_rsa -v