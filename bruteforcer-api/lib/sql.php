<?php
require_once "db.php";


function query(string $sql, array $args = []) {
    global $db;
    $sql = $db->prepare($sql);
    try {
        if ($sql->execute($args)) {
            return $sql;
        }

        return array();
        
    } catch (PDOException $e) {
        return $e;
    }
     
}

function isQueryInvalid($qoutput) {
    return empty($qoutput) || gettype($qoutput) == "PDOException";
}

// Bruteforcer modifikace
function saveToRainbowTables($hash, $string) {
    $args = [
        ":hash" => $hash,
        ":password" => $string
    ]

    $check = query("SELECT * FROM rainbow_table WHERE hash = :hash", [":hash" => $hash]);

    if (isQueryInvalid($check)) {
        return false;
    }

    if (empty($check->fetchAll(PDO::FETCH_ASSOC))) {
        return false
    }

    $out = query("INSERT INTO rainbow_table (hash, password) VALUES (:hash, :password)", $args);

    if (isQueryInvalid($out)) {
        return false;
    }

    return true;
}

function tryRainbowTables($hash) {
    $arg = [":hash" => $hash];

    $out = query("SELECT * FROM rainbow_table WHERE hash = :hash", $arg);

    if (isQueryInvalid($out)) {
        return false;
    }

    $out = $out->fetchAll(PDO::FETCH_ASSOC)
    if (empty($out)) {
        return false
    }

    return $out;


}