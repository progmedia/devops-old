#!/bin/sh

ansible-playbook -i hosts.ini playbooks/import-migrations-data-locally.yml -u vagrant --private-key=~/.vagrant.d/insecure_private_key -v