<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!is_array($_REQUEST) || count($_REQUEST) == 0){
    //crazy informational onliner
    die ('send params [NEW] with variable of needed model (leave empty to use default). If you have bot - send IDENT to get responses ,or add IN param to send message <br/>More info <a href="https://github.com/dosjein/chatbot-rnn">dosjein/chatbot-rnn</a>');
}

if (isset($_REQUEST['MODELS'])){
    $cdir = scandir('../models'); 
    echo(json_encode(
        array(
            'models_list' => $cdir
        )
    )); 
    die();
}


if (isset($_REQUEST['NEW'])){

    $workFile = rand();
    if (!file_exists('../storage/php_request')) {
        mkdir("../storage/php_request", 0777);
    }

    $transcriptFile = "../storage/php_request/".$workFile;

    if($fh = fopen($transcriptFile,'w')){
        $stringData = "Bot Created by ".$_SERVER['REMOTE_ADDR'];
        fwrite($fh, $stringData,1024);
        fclose($fh);
        chmod($transcriptFile, 0777); 
    }

    //specific model requested !!!
    if (trim($_REQUEST['NEW']) != ''){
        $model = preg_replace('|https?://www\.[a-z\.0-9]+|i', '', trim($_REQUEST['NEW']));
        $model = preg_replace('/\s+/', '', trim($model));
        $definitionFile = "../storage/php_request/".$workFile.'_model.def';

        if($fh = fopen($definitionFile,'w')){
            fwrite($fh, $model,1024);
            fclose($fh);
            chmod($definitionFile, 0777); 
        }      
    }


    echo(json_encode(
        array(
            'ident' => $workFile,

        )
    )); 
    die();
}

//1861057470
if (isset($_REQUEST['IDENT']) && file_exists('../storage/php_request/'.intval($_REQUEST['IDENT']))){

    $status = 0;


    if (isset($_REQUEST['IN']) && trim($_REQUEST['IN']) != ''){

        $filePath = "../storage/php_request/".intval($_REQUEST['IDENT']).'_in.txt';
        if($fh = fopen($filePath,'w')){
            $stringData = trim($_REQUEST['IN'])."\n";
            fwrite($fh, $stringData,1024);
            fclose($fh);
            chmod($filePath, 0777); 
            $status = 1;
        }       
    }

    $outFile = "../storage/php_request/".intval($_REQUEST['IDENT']).'_out.txt';

    $message = '';
    $editTime = false;

    if (file_exists($outFile)) {
        $message = file_get_contents($outFile);
        $editTime = date ("d-m-Y H:i:s.", filemtime($outFile));
    }


    echo(json_encode(
        array(
            'status' => $status,
            'message' => $message,
            'edit_time' => $editTime
        )
    )); 
    die();
}