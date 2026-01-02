<?php
function csvToArray(string $filename): array {
    $data = [];

    if (($handle = fopen($filename, "r")) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }

    return $data;
}
