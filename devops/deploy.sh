#!/bin/sh

ansible-playbook devops/webserver.yml -i devops/hosts --private-key=$HOME/.vagrant.d/insecure_private_key -vvvv -u vagrant