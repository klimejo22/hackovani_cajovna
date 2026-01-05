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
        return false;
    }
     
}

function isQueryInvalid($qoutput) {
    return $qoutput === false;
}

// Bruteforcer modifikace
// SQL queries od chata
function saveToRainbowTables($hash, $string) {
    $args = [
        ":hash" => $hash,
        ":password" => $string
    ];

    $check = query("SELECT * FROM rainbow_table WHERE hash = :hash", [":hash" => $hash]);

    if (isQueryInvalid($check)) {
        return false;
    }

    if (!empty($check->fetchAll(PDO::FETCH_ASSOC))) {
        return false;
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

    $out = $out->fetchAll(PDO::FETCH_ASSOC);
    if (empty($out)) {
        return false;
    }

    return $out[0]["password"];


}

function loadProgress($hash) {
    $out = query("SELECT length, position FROM hash_progress WHERE hash = :hash ORDER BY updated_at DESC LIMIT 1", [":hash" => $hash]);
    
    if (isQueryInvalid($out)) {
        return false;
    }

    $r = $out->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($r)) {
        return $r[0];
    }
    
    return false;
}

function saveProgress($hash, $length, $position) {
    $q = "INSERT INTO hash_progress (hash, length, position)
          VALUES (:hash, :length, :position)
          ON DUPLICATE KEY UPDATE
            length = VALUES(length),
            position = VALUES(position)";

    $a = [":hash"=>$hash, ":length"=>$length, ":position"=>$position];
    return !isQueryInvalid(query($q,$a));
}

function clearProgress(string $hash) {
    $out = query("DELETE FROM hash_progress WHERE hash = :hash", [":hash" => $hash]);
    
    return !isQueryInvalid($out);
}
