<?php
require_once "lib/sql.php";
require_once "lib/db.php";

$charset = "abcdefghijklmnopqrstuvwxyz0123456789";

// Chat - modifikovano (algoritmus pomoci chata vse ostatni ja)
function bruteForceIterative(string $targetHash, int $length): ?string {
    global $charset;
    $pepper = "cajovna-2025-";

    $rtAttempt = tryRainbowTables($targetHash);
    if ($rtAttempt) {
        return $rtAttempt;
    }

    $base = strlen($charset);
    $max = pow($base, $length);

    for ($i = 0; $i < $max; $i++) {
        $n = $i;
        $candidate = "";

        for ($j = 0; $j < $length; $j++) {
            $candidate = $charset[$n % $base] . $candidate;
            $n = intdiv($n, $base);
        }

        if (hash('sha256', $pepper . $candidate) === $targetHash) {
            saveToRainbowTables($targetHash, $pepper.$candidate);
            return $pepper.$candidate;
        }
    }

    return null;
}

function bruteForce(string $hash, int $maxLength): ?string {
    for ($l = 1; $l <= $maxLength; $l++) {
        $res = bruteForceIterative($hash, $l);
        if ($res !== null) return $res;
    }
    return null;
}
