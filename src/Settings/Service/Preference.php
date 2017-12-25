<?php

namespace Lychee\Settings\Service;

use Lychee\Settings\Data\SettingsRepository;
use Silex\Application;
use Illuminate\Support\Collection;

class Preference implements \ArrayAccess, \JsonSerializable
{
    protected $repository;
    protected $cache;
    protected $hidden = [
        'username',
        'password',
        'identifier'
    ];

    public function __construct(SettingsRepository $repository)
    {
        $this->repository = $repository;
        $this->cache = new Collection([]);
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->cache[] = $value;
        } else {
            $this->cache[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->cache[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->cache[$offset]);
    }

    public function offsetGet($offset) {
        return $this->cache[$offset] ?? null;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        $pref = $this;

        return $this->cache->filter(function ($value, $key) use ($pref) {
            return !in_array($key, $pref->hidden);
        })->all();
    }

    public function pull()
    {        
        $this->cache = new Collection($this->repository->find());
    }

    public function push()
    {
        $this->repository->save($this->cache);
    }
}
