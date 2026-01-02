<?php
require_once "lib/bruteforce.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


$input = json_decode(file_get_contents("php://input"), true);   // Chat

if (!isset($input["hash"])) {
    echo "Spatny vstup";
    exit;
}

$result = bruteForce($input["hash"], 8);

if ($result !== null) {
    echo "cajovna-2025-" . $result;
} else {
    echo "Nenalezeno";
}
