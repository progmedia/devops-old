#!/bin/sh

ansible-playbook -i hosts.ini playbooks/staging-neo4jserver.yml -u developer -k -K