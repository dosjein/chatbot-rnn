#!/usr/bin/expect
set timeout 3

spawn python chatbot.py

while true {

    expect -re ">"
    sleep 3
    send -- "[read [open "input.txt" r]]"
}