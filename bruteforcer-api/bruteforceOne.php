<?php
require_once "lib/bruteforce.php";
if (empty($_POST["hash"])) {
    echo "Spatny vstup";
    die;
}

$result = bruteForce($_POST["hash"], 4);

if ($result !== null) {
    echo "cajovna-2025-" . $result;
} else {
    echo "Nenalezeno";
}
