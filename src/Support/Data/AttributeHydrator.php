<?php

namespace Lychee\Support\Data;

class AttributeHydrator
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function hydrate(): array
    {
        $attributes = [];

        foreach ($this->data as $datum) {
            $attributes[$datum['key']] = $datum['value'];
        }

        return $attributes;
    }
}
