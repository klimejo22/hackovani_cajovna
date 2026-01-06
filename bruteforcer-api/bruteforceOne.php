<?php
require_once "lib/bruteforce.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


$input = json_decode(file_get_contents("php://input"), true);   // Chat

if (isset($_POST["hash"])) {
    $hash = $_POST["hash"];
} else if (!isset($input["hash"])) {
    echo "Spatny vstup";
    exit;
} else {
    $hash = $input["hash"];
}



$result = bruteForce($hash, 8);

if ($result !== null) {
    echo $result;
} else {
    echo "Nenalezeno";
}
