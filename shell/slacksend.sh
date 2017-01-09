#!/bin/bash -e
eval $(cat .env | sed 's/^/export /')

if [ -s chuck.txt ]
then
        curl -F text="$(cat chuck.txt)" -F channel=#log_chat -F token=$SLACK_TOKEN https://slack.com/api/chat.postMessage
        rm -f chuck.txt
        touch chuck.txt
fi

if [ -s response.txt ]
then
        curl -F text="$(cat response.txt)" -F channel=#log_chat -F token=$SLACK_TOKEN2 https://slack.com/api/chat.postMessage
        rm -f response.txt
        touch response.txt
fi

#if ! screen -list | grep -q "chuck"; then
#    screen -d -m -S chuck bash -c 'while true; do  php input.php ; sleep 45 ; done'
#else
#    echo "chuck is active"
#fi

#if ! screen -list | grep -q "slackinform"; then
#    screen -d -m -S slackinform bash -c 'while true; do  ./slacksend.sh ; sleep 5 ; done'
#else
#    echo "slackinform is active"
#fi