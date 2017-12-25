<?php

namespace Lychee\Settings\Data;

class SettingsHydrator
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function hydrate(): array
    {
        $settings = [];

        foreach ($this->data as $datum) {
            $settings[$datum['key']] = $datum['value'];
        }

        $settings['plugins'] = explode(';', $settings['plugins']);

        return $settings;
    }
}
