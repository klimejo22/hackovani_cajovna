<?php
require_once "lib/bruteforce.php";
require_once "lib/csvToArray.php";
header("Content-Type: application/json; charset=utf-8");

function normalizeString($str) {
    $str = mb_strtolower($str, 'UTF-8');

    $map = [
        'á'=>'a','č'=>'c','ď'=>'d','é'=>'e','ě'=>'e','í'=>'i',
        'ň'=>'n','ó'=>'o','ř'=>'r','š'=>'s','ť'=>'t','ú'=>'u',
        'ů'=>'u','ý'=>'y','ž'=>'z',
        'Á'=>'a','Č'=>'c','Ď'=>'d','É'=>'e','Ě'=>'e','Í'=>'i',
        'Ň'=>'n','Ó'=>'o','Ř'=>'r','Š'=>'s','Ť'=>'t','Ú'=>'u',
        'Ů'=>'u','Ý'=>'y','Ž'=>'z'
    ];

    $str = strtr($str, $map);

    return $str;
}

$data = csvToArray("users.csv");

$input = json_decode(file_get_contents("php://input"), true);

// echo "<pre>";
// var_dump($data);
// echo "</pre>";

$length_data = count($data);

$returnVal = [];
for ($i=1; $i < $length_data; $i++) {
    $returnVal[normalizeString($data[$i][0])] = "cajovna-2025-".bruteForce($data[$i][2], 5);
}
$json = json_encode($returnVal);
file_put_contents("jsons/all.json", $json);
echo $json;