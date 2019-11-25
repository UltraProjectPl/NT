<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';


use App\Perceptron;

$csvFile = fopen('iris.csv', 'r');

$data = [];

while (false === feof($csvFile)) {
    $data[] = fgetcsv($csvFile);
}

fclose($csvFile);

$y = array_column(array_slice($data, 0, 100), 4);
$y = array_map(static function(string $item) {
    return $item === 'Iris-setosa' ? -1 : 1;
}, $y);

$X = array_slice($data, 0, 100);
$X = array_map(null, array_column($X, 0), array_column($X, 2));

$ppn = new Perceptron(0.1, 1+0);
$ppn->fit($X, $y);

