<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
    $language = strtolower($_POST['language']);
    $code = $_POST['code'];

    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);

    if($language == "php") {
        $output = shell_exec("php " . $filePath . " 2>&1");
        echo $output;
    }
    if($language == "python") {
        $output = shell_exec("python " . $filePath . " 2>&1");
        echo $output;
    }
    if($language == "node") {
        rename($filePath, $filePath.".js");
        $output = shell_exec("node $filePath.js 2>&1");
        echo $output;
    }
    if($language == "c") {
        $outputExe = $random . ".exe";
        shell_exec("gcc $filePath -o $outputExe 2>&1");
        $output = shell_exec(__DIR__ . "/$outputExe");
        echo $output;
    }
    if($language == "c_cpp") {
        rename($filePath, $filePath.".cpp");
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