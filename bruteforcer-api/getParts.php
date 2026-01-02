<?php
// Vraci zacatky pro cally
header("Content-Type: application/json; charset=utf-8");
require_once "lib/csvToArray.php";
$filename = "data.csv";

function GetIncrement() {
    return ceil($length_data / intval($_GET["parts"]));
}
if (empty($_GET["parts"])) {
    echo json_encode("Neexistuje parts");
    die;
}

$data = csvToArray();

$length_data = count($data)

$returnVal = [];
for ($i=0; $i < $length_data; $i + GetIncrement()) { 
    $returnVal[] = $i;
}

echo json_encode($returnVal);
