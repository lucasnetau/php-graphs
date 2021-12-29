<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph\Iterator;

use EdgeTelemetrics\Graph\Vertex;
use IteratorAggregate;
use SplQueue;
use Traversable;
use WeakMap;

class BreadthFirstIterator implements IteratorAggregate
{
    public function __construct(private Vertex $origin) {}

    public function getIterator() : Traversable
    {
        $visited = new WeakMap();

        // create an empty queue
        $q = new SplQueue();

        // enqueue the origin vertex and mark as visited
        $q->enqueue($this->origin);
        $visited[$this->origin] = true;

        while (!$q->isEmpty()) {
            $t = $q->dequeue();
            yield $t;
            foreach ($t->getEdges() as $edge) {
                $vertex = $edge->head;
                if (!($visited[$vertex] ?? false)) {
                    $q->enqueue($vertex);
                    $visited[$vertex] = true;
                }
            }
        }
    }
}
