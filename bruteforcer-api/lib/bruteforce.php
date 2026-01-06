<?php
require_once "lib/sql.php";
require_once "lib/db.php";

$charset = "abcdefghijklmnopqrstuvwxyz0123456789";

define("TRIES_TO_SAVE", 10000);
// Chat - modifikovano (algoritmus pomoci chata vse ostatni ja pokud neni receno jinak jinde)
function bruteForceIterative(string $targetHash, int $length, int $start = 0): ?string {
    global $charset;
    $pepper = "cajovna-2025-";

    $rtAttempt = tryRainbowTables($targetHash);
    if ($rtAttempt) return $rtAttempt;

    $base = strlen($charset);
    $max = pow($base, $length);

    for ($i = $start; $i < $max; $i++) {
        $n = $i;
        $candidate = "";

        for ($j = 0; $j < $length; $j++) {
            $candidate = $charset[$n % $base] . $candidate;
            $n = intdiv($n, $base);
        }

        if (hash('sha256', $pepper . $candidate) === $targetHash) {
            saveToRainbowTables($targetHash, $pepper.$candidate);
            clearProgress($targetHash);
            return $pepper.$candidate;
        }

        if ($i > 0 && $i % TRIES_TO_SAVE === 0) {
            saveProgress($targetHash, $length, $i);
        }
    }

    return null;
}

function bruteForce(string $hash, int $maxLength): ?string {
    $progress = loadProgress($hash);

    if ($progress) {
        $startLength = (int)$progress['length'];
        $startPos    = (int)$progress['position'];
    } else {
        $startLength = 1;
        $startPos    = 0;
    }
    
    for ($l = $startLength; $l <= $maxLength; $l++) {
        $res = bruteForceIterative(
            $hash,
            $l,
            $l === $startLength ? $startPos : 0
        );
        if ($res !== null) {
            clearProgress($hash);
            return $res;
        }
    }
    return null;
}
