<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph;

use EdgeTelemetrics\Graph\Iterator\BreadthFirstIterator;
use EdgeTelemetrics\Graph\Iterator\DepthFirstIterator;
use EdgeTelemetrics\Graph\Iterator\ShortestPath;
use Generator;
use JetBrains\PhpStorm\Pure;
use SplDoublyLinkedList;
use SplQueue;
use SplStack;
use Traversable;
use WeakMap;

class Graph {

    /**
     * @var Vertex[]
     */
    protected array $graph;

    public function __construct(Vertex...$vertices) {
        $this->graph = $vertices;
    }

    /**
     * Breadth First Search - Find the least number of hops (edges) between 2 vertices
     * @param Vertex $origin
     * @param Vertex $destination
     * @return Traversable
     */
    #[Pure] public function shortestPath(Vertex $origin, Vertex $destination): Traversable
    {
        return new ShortestPath($origin, $destination);
    }

    /**
     * Breadth First Traversal
     * @param Vertex $origin
     * @return Traversable
     */
    #[Pure] public function getBreadthFirstIterator(Vertex $origin) : Traversable {
        return new BreadthFirstIterator($origin);
    }

    /**
     * Depth First Search
     * @param Vertex $origin
     * @param Vertex $destination
     * @return Generator
     */
    public function dfs(Vertex $origin, Vertex $destination): Generator
    {
        $visited = new WeakMap();

        // create an empty stack
        $q = new SplStack();

        // enqueue the origin vertex and mark as visited
        $q->push($origin);
        $visited[$origin] = true;

        // this is used to track the path back from each node
        $path = new WeakMap();
        $path[$origin] = new SplDoublyLinkedList();

        $path[$origin]->push($origin);

        // while queue is not empty and destination not found
        while (!$q->isEmpty() && $q->bottom() !== $destination) {
            $t = $q->pop();
//echo "Vertex $t\n";
            // for each adjacent neighbor
            foreach ($t->getEdges() as $edge) {
                $vertex = $edge->head;
                if (!($visited[$vertex] ?? false)) {
                    // if not yet visited, enqueue vertex and mark
                    // as visited
                    $q->push($vertex);
                    $visited[$vertex] = true;
                    // add vertex to current path
                    $path[$vertex] = clone $path[$t];
                    $path[$vertex]->push($vertex);
                }
            }
        }

        if (isset($path[$destination])) {
            yield from $path[$destination];
        }
    }

    /**
     * Depth First Traversal
     * @param Vertex $origin
     * @return Traversable
     */
    #[Pure] public function getDepthFirstIterator(Vertex $origin): Traversable
    {
        return new DepthFirstIterator($origin);
    }
}