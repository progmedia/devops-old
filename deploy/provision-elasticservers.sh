#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-elasticserver.yml -u developer -k -K