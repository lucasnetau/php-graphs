<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph;

use Generator;

trait VertexTrait {

    protected array $edges = [];

    public function addEdge($label, VertexInterface $adjacentVertex, bool $bidirectional) {
        $edge = new Edge($label, $this, $adjacentVertex);
        $this->edges[] = $edge;
        if ($bidirectional) {
            $adjacentVertex->addEdge($label, $this, false);
        }
    }

    public function getLabel() : string {
        return '';
    }

    public function __toString() : string {
        return $this->getLabel();
    }

    public function getEdges(): Generator
    {
        yield from $this->edges;
    }

}