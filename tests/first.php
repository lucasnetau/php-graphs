<?php

use EdgeTelemetrics\Graph\Graph;
use EdgeTelemetrics\Graph\Vertex;

include __DIR__ . '/../vendor/autoload.php';

function findPath(Graph $graph, $origin, $destination) {
    $path = $graph->shortestPath($origin, $destination)->getIterator();
    echo "BFS Search\n";
    if ($path->valid()) {
        $count = 0;
        $sep = '';
        foreach ($path as $vertex) {
            $count++;
            echo $sep, $vertex;
            $sep = '->';
        }
        echo "\n";
        echo "$origin to $destination in ",
            $count - 1,
        " hops\n";
    } else {
        echo "No route from $origin to $destination\n";
    }

    $paths = $graph->dfs($origin, $destination);
    echo "DFS Search\n";
    if ($paths->valid()) {
        $count = 0;
        $sep = '';
        foreach ($paths as $vertex) {
            $count++;
            echo $sep, $vertex;
            $sep = '->';
        }
        echo "\n";
        echo "$origin to $destination in ",
            $count - 1,
        " hops\n";
    } else {
        echo "No route from $origin to $destination\n";
    }
}

function findDependencies(Graph $graph, $origin) {
    $vertices = $graph->getDepthFirstIterator($origin)->getIterator();

    if ($vertices->valid()) {
        echo "Vertex $origin is dependant on ";
        $sep = '';
        foreach($vertices as $vertex) {
            echo $sep, $vertex;
            $sep = '->';
        }
        echo "\n";
    } else {
        echo "Vertex $origin is not dependent on any vertex\n";
    }

}

/** First Tests */


$graphArray = array(
    'A' => array('B', 'F'),
    'B' => array('A', 'D', 'E'),
    'C' => array('F'),
    'D' => array('B', 'E'),
    'E' => array('B', 'D', 'F'),
    'F' => array('A', 'E', 'C'),
    'G' => [],
);

$vertices = [];

foreach(array_keys($graphArray) as $key) {
    $vertices[$key] = new Vertex($key);
}

foreach($graphArray as $key => $adj) {
    foreach($adj as $item) {
        $tail = $vertices[$key];
        $head = $vertices[$item];
        $tail->addEdge('adj', $head, false);
    }
}

$graph = new Graph(...$vertices);
findPath($graph,$vertices['D'], $vertices['C']);
findPath($graph,$vertices['B'], $vertices['F']);
findPath($graph,$vertices['A'], $vertices['C']);
findPath($graph,$vertices['A'], $vertices['G']);

findDependencies($graph,$vertices['A']);
findDependencies($graph,$vertices['B']);
findDependencies($graph,$vertices['C']);
findDependencies($graph,$vertices['D']);
findDependencies($graph,$vertices['E']);
findDependencies($graph,$vertices['F']);
findDependencies($graph,$vertices['G']);