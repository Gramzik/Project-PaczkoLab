<?php

//Load all class
require (__DIR__ . '/config.php');

$response = [];
//connect to DB
try {
    $conn = new PDO(
        "mysql:host=".DB_SERVER_NAME.";dbname=".DB_BASE_NAME.";charset=utf8"
        , DB_USERNAME, DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    $response = ['error' => 'DB Connection error: '.$e->getMessage()];
}

######### Dynamic load php class file depend on request #########
//parsing url
//if request URI is router.php/size/1
//we will parse part size/1 and explode it
//to get name of class (size) and optional id from db (1)

$uriPathInfo = $_SERVER['PATH_INFO'];//w tym kluczu znajduja sie dane po nazwie pliku np. size/1

//explode path info

$path = explode('/', $uriPathInfo);
$requestClass = $path[1];

//load class file

$requestClass = preg_replace('#[^0-9a-zA-Z]#', '', $requestClass);//remove all non alfanum chars from request

$className = ucfirst(strtolower($requestClass));

//w $className znajduje sie nazwa klasy (taka jak nazwa pliku), która jest dynamicznie generowana z adresu URL
######### END DYNAMIC LOAD #########

//sprawdzamy czy w adresie przekazano cos poza nazwa klasy
//np. size/1 -> klasa size i parametr id = 1
//np. size -> sama klasa
$pathId = isset($path[2]) ? $path[2] : null;
if (!isset($response['error'])) {//process request if no db error
    include_once __DIR__.'/restEndPoints/'.$className.'.php';
}
header('Content-Type: application/json');//return json header
if (isset($response['error'])) {
    header("HTTP/1.0 400 Bad Request");//return proper http code if error
}
echo json_encode($response);
