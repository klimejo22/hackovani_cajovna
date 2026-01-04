<?php
require_once "lib/bruteforce.php";
require_once "lib/csvToArray.php";
require_once "lib/sql.php";
require_once "lib/db.php";

header("Content-Type: application/json; charset=utf-8");

// DOCASNE
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

ini_set('max_execution_time', '0');
set_time_limit(0);
ignore_user_abort(true);
//

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

    return strtr($str, $map);
}

$data = csvToArray("users.csv");
$length_data = count($data);

$filename = time();
$path = "jsons/".$filename.".json";


$fp = fopen($path, "a");


$dehashedStrings = [];

for ($i = 1; $i < $length_data; $i++) {
    $user = normalizeString($data[$i][0]);

    $password = bruteForce($data[$i][2], 10);

    if ($password != null) {
        $dehashedStrings[$user] = $password;
    } else {
        $dehashedStrings[$user] = "Heslo se nepodarilo rozhashovat";
    }
    
}

fwrite($fp, json_encode($dehashedStrings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));     // Chat

fclose($fp);


echo json_encode([
    "Status" => "DONE",
    "Path" => "https://www.junglediff.cz/bruteforcer-api/".$path,
    "Passwords" => $dehashedStrings,
]);
