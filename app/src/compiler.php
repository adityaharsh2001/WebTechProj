<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
$queue = file_get_contents(__DIR__ . '/queue.js');

    $language = strtolower($_POST['language']);
    $code = $_POST['code'];

    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $queue = str_replace("{{code}}", $code, $queue);
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);

    if($language == "php") {
        $output = shell_exec("php " . $filePath . " 2>&1");
        $queue = str_replace("{{output}}", $output, $queue);
        echo $output;
    }

    if(language == 'java') {
        $output = shell_exec("java " . $filePath . " 2>&1");
        $queue = str_replace("{{output}}", $output, $queue);
        
        echo $output;
    } 
    if($language == "python") {
        $output = shell_exec("python " . $filePath . " 2>&1");
        $queue = str_replace("{{output}}", $output, $queue);

        echo $output;
    }
    if($language == "c") {
        $outputExe = $random . ".exe";
        $queue = str_replace("{{output}}", $output, $queue);

        shell_exec("gcc $filePath -o $outputExe 2>&1");
        $output = shell_exec(__DIR__ . "/$outputExe");
        echo $output;
    }
    if($language == "c_cpp") {
        rename($filePath, $filePath.".cpp");
        $queue = str_replace("{{output}}", $output, $queue);

        $outputExe = $random . ".exe";
        try {
            $data = shell_exec("g++ $filePath.cpp -o $outputExe 2>&1");
            if($data){
                echo $data;
            } else {
                $output = shell_exec(__DIR__ . "/$outputExe");
                echo $output;
            };
        } catch (Exception $e) {
            console_log("Error: " . $e->getMessage());
            echo $e;
        }
    }

