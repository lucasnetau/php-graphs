<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph;

interface EdgeInterface {

    public function __construct(string $label, Vertex $tail, Vertex $head, int $cost = 1);

}