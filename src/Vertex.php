<?php declare(strict_types=1);

namespace EdgeTelemetrics\Graph;

class Vertex implements VertexInterface {

    use VertexTrait;

    public function __construct(public string $label) {}

    public function getLabel(): string
    {
        return $this->label;
    }

}