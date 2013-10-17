#!/bin/sh

ansible-playbook devops/migrate-db.yml -i devops/hosts --private-key=$HOME/.vagrant.d/insecure_private_key -vvvv -u vagrant