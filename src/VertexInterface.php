<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph;

use Generator;
use Stringable;

interface VertexInterface extends Stringable
{
    public function __construct(string $label);

    public function addEdge(string $label, VertexInterface $adjacentVertex, bool $bidirectional);

    public function getEdges(): Generator;

    public function getLabel(): string;

    public function __toString();
}