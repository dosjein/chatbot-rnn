<?php

function prepend($string, $orig_filename) {
  $context = stream_context_create();
  $orig_file = fopen($orig_filename, 'r', 1, $context);

  $temp_filename = tempnam(sys_get_temp_dir(), 'php_prepend_');
  file_put_contents($temp_filename, $string);
  file_put_contents($temp_filename, $orig_file, FILE_APPEND);

  fclose($orig_file);
  unlink($orig_filename);
  rename($temp_filename, $orig_filename);
}

if (!isset($argv[1]) || !isset($argv[2])){
    var_dump($argv);
    die('missing arguments');
}

$handle = fopen($argv[1], "r");
if ($handle) {

        $dataGathered = '';

    while (($line = fgets($handle)) !== false) {

        if (strpos($line, 'M):') > -1){
            $start = explode('M):', $line);
            $finalText = preg_replace('|https?://www\.[a-z\.0-9]+|i', '', trim($start[1].$dataGathered)));
            $dataGathered = preg_replace('/\s+/', ' ', '>'.$finalText."\n";
            prepend($dataGathered , $argv[2]);
            echo $dataGathered;
            $dataGathered = '';
        }else{

                $dataGathered = $line.$dataGathered;
                $dataGathered = preg_replace('/\s+/', ' ', trim($dataGathered));
        }

    }

    fclose($handle);
} 
