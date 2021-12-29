<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph\Iterator;

use EdgeTelemetrics\Graph\Vertex;
use IteratorAggregate;
use SplStack;
use Traversable;
use WeakMap;

class DepthFirstIterator implements IteratorAggregate
{
    public function __construct(private Vertex $origin) {}

    /**
     * @return Traversable
     * DFS using a Stack and Iterative process
     */
    public function getIterator() : Traversable
    {
        $visited = new WeakMap();

        // create an empty queue
        $q = new SplStack();

        // enqueue the origin vertex and mark as visited
        $q->push($this->origin);

        while (!$q->isEmpty()) {
            $t = $q->pop();

            if ($visited[$t] ?? false) {
                continue;
            }
            $visited[$t] = true;

            yield $t;

            foreach ($t->getEdges() as $edge) {
                $vertex = $edge->head;
                $q->push($vertex);
            }
        }
    }
}
