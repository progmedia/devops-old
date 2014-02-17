#!/bin/sh

ansible-playbook -i hosts.ini playbooks/copy-public-key-to-server.yml -u developer -k