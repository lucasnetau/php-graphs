<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph;

trait EdgeTrait {

    public function __construct(public string $label, public Vertex $tail, public Vertex $head, public int $cost = 1) {}

}