#!/bin/bash
cd "$(dirname "$0")"

eval $(cat ../.env | sed 's/^/export /')

if [ -d "../storage/php_request" ]; then
    FILES=../storage/php_request/*
    for f in $FILES
    do
        if [[ $(basename $f) =~ ^[-+]?[0-9]+$ ]]
        then

            if [ -f "$FILE_model.def" ];
            then
               model=$( cat "$FILE_model.def" )
            else
               model=$DEFAULT_MODEL
            fi

            if ! screen -list | grep -q $(basename $f); then
                echo "./inout.sh $(basename $f) $model"
                touch "../storage/php_request/$(basename $f)_in.txt"
                screen -d -m -S $(basename $f) bash -c "./inout.sh $(basename $f) $model"
            else
                echo "$(basename $f) is active"
            fi

        fi
    done
else
    echo "Directory does not exist"
fi