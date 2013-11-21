#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-webserver.yml -u developer -k -K