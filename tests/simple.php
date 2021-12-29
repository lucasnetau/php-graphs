<?php declare(strict_types=1);

use EdgeTelemetrics\Graph\Graph;
use EdgeTelemetrics\Graph\Vertex;

include __DIR__ . '/../vendor/autoload.php';

/** Simple Traversal Tests */
$graphArray1 = [
    'A' => ['B', 'C'],
    'B' => ['A','D'],
    'C' => ['A','E','F'],
    'D' => ['B'],
    'E' => ['C'],
    'F' => ['C']
];

$graphArray2 = [
    'S' => ['A','B', 'C'],
    'A' => ['S','D'],
    'B' => ['S','E'],
    'C' => ['S','F'],
    'D' => ['A','G'],
    'E' => ['B','G'],
    'F' => ['C','G'],
    'G' => ['D','E','F'],
];

foreach(['A' => $graphArray1, 'S' => $graphArray2] as $origin => $graphArray) {
    $vertices = [];

    foreach (array_keys($graphArray) as $key) {
        $vertices[$key] = new Vertex($key);
    }

    foreach ($graphArray as $key => $adj) {
        foreach ($adj as $item) {
            $tail = $vertices[$key];
            $head = $vertices[$item];
            $tail->addEdge('adj', $head, false);
        }
    }

    $graph = new Graph(...$vertices);

    echo "Breath First Iterator (Expect ABCDEF): ";
    foreach ($graph->getBreadthFirstIterator($vertices[$origin]) as $vertex) {
        echo $vertex;
    }
    $start = hrtime(true);
    $iterations = 0;
    for ($i = 1; $i < 1000000; $i++) {
        foreach ($graph->getBreadthFirstIterator($vertices[$origin]) as $vertex) {
            ++$iterations;
        }
    }
    echo ". 1 million lookups took: " . (hrtime(true) - $start) / 1000000000 . ' seconds';
    echo PHP_EOL;

    echo "Depth First Iterator (Expect ACFEBD): ";
    foreach ($graph->getDepthFirstIterator($vertices[$origin]) as $vertex) {
        echo $vertex;
    }
    $start = hrtime(true);
    $iterations = 0;
    for ($i = 1; $i < 1000000; $i++) {
        foreach ($graph->getDepthFirstIterator($vertices[$origin]) as $vertex) {
            ++$iterations;
        }
    }
    echo ". 1 million lookups too: " . (hrtime(true) - $start) / 1000000000 . ' seconds';
    echo PHP_EOL;
}