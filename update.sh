#!/usr/bin/env bash
#
# updateRepos
#
# Updated all git repositories in the first argument (or if not specified, the current directory), excluding any directories named 'vendor'.
#

DIR=$(pwd)

# if directory provided, make it absolute
if [ ! -z $1 ]
then
    DIR=$(readlink -f $1)
fi

# Sanity check
if [ ! -d $DIR ]; then
    echo "Error: Directory '$DIR' does not exist!"
    exit 1
fi

# Find all files containing the directory .git
FILES=$(find $DIR -type d -name .git)

echo -e "\033[32mPulling all git directories in $DIR\033[0m"

# Iterate directories, excluding vendor
for d in $FILES; do
    if [[ "$d" != *\/vendor\/* ]]
    then
	DIR=${d%/*}
	echo -e "\033[36mPulling $DIR\033[0m"
	cd $DIR
	git pull
    composer up
    fi
done

echo -e "\033[32mDone.\033[0m"

exit 0