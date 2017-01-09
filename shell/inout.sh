#!/usr/bin/expect

set instance [lindex $argv 0];
set model [lindex $argv 1];

set timeout 3

set inn "_in.txt"
set input_file "../storage/php_request/$instance$inn"


spawn python ../chatbot.py --save_dir ../models/$model --transcript ../storage/php_request/$instance --external ../storage/php_request/$instance

while true {

    expect -re ">"
    sleep 3
    send -- "[read [open $input_file r]]";
}