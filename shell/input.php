<?php

$data = json_decode(file_get_contents('https://api.chucknorris.io/jokes/random'));

file_put_contents('chuck.txt', $data->value."\n");

file_put_contents('input.txt', $data->value."\n");