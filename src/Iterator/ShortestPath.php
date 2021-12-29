<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph\Iterator;

use EdgeTelemetrics\Graph\Vertex;
use IteratorAggregate;
use SplDoublyLinkedList;
use SplQueue;
use Traversable;
use WeakMap;

class ShortestPath implements IteratorAggregate
{
    public function __construct(private Vertex $origin, private Vertex $destination) {}

    public function getIterator() : Traversable
    {
        $visited = new WeakMap();

        // create an empty queue
        $q = new SplQueue();

        // create path tracking queue
        $path = new WeakMap();
        $path[$this->origin] = new SplDoublyLinkedList();

        $path[$this->origin]->push($this->origin);

        // enqueue the origin vertex and mark as visited
        $q->enqueue($this->origin);
        $visited[$this->origin] = true;

        while (!$q->isEmpty() && $q->bottom() !== $this->destination) {
            $t = $q->dequeue();
            foreach ($t->getEdges() as $edge) {
                $vertex = $edge->head;
                if (!($visited[$vertex] ?? false)) {
                    $q->enqueue($vertex);
                    $visited[$vertex] = true;
                    // add vertex to current path
                    $path[$vertex] = clone $path[$t];
                    $path[$vertex]->push($vertex);
                }
            }
        }

        if (isset($path[$this->destination])) {
            yield from $path[$this->destination];
        }
    }
}
