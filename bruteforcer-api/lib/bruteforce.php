<?php
function bruteForceIterative(string $targetHash, int $length): ?string {
    global $charset;
    $base = strlen($charset);
    $max = pow($base, $length);

    for ($i = 0; $i < $max; $i++) {
        $n = $i;
        $candidate = "";

        for ($j = 0; $j < $length; $j++) {
            $candidate = $charset[$n % $base] . $candidate;
            $n = intdiv($n, $base);
        }

        if (hashPassword($candidate) === $targetHash) {
            return $candidate;
        }
    }

    return null;
}
