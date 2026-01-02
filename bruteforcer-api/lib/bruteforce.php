<?php
$charset = "abcdefghijklmnopqrstuvwxyz0123456789";

function bruteForceIterative(string $targetHash, int $length): ?string {
    global $charset;
    $pepper = "cajovna-2025-";

    $base = strlen($charset);
    $max = pow($base, $length);

    for ($i = 0; $i < $max; $i++) {
        $n = $i;
        $candidate = "";

        for ($j = 0; $j < $length; $j++) {
            $candidate = $charset[$n % $base] . $candidate;
            $n = intdiv($n, $base);
        }

        if (hashPassword($pepper . $candidate) === $targetHash) {
            return $candidate;
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
