<?php
// Vraci zacatky pro cally
header("Content-Type: application/json; charset=utf-8");
require_once "lib/csvToArray.php";
$filename = "data.csv";

function GetIncrement($length_data) {
    return ceil($length_data / intval($_GET["parts"]));
}
if (empty($_GET["parts"])) {
    echo json_encode("Neexistuje parts");
    die;
}

$data = csvToArray("users.csv");

$length_data = count($data);

$returnVal = [];
for ($i=0; $i < $length_data; $i = $i + GetIncrement($length_data)) {
    $returnVal[] = $i;
}

echo json_encode($returnVal);
