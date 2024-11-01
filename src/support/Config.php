<?php

namespace PROJECT\support;

class Config implements \ArrayAccess
{
    protected array $items = [];

    public function __construct($items)
    {
        foreach ($items as $key => $item) {
            $this->items[$key] = $item;
        }
    }

    public function has($keys): bool
    {
        return Arr::has($this->items, $keys);
    }

    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->items, $key, $default);
    }

    public function getMany($keys): array
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }

            $config[$key] = Arr::get($this->items, $key, $default);
        }

        return $config;
    }

    public function set($key, $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->items, $key, $value);
        }
    }

    public function push($key, $value): void
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, ...$array);
    }

    public function all(): array
    {
        return $this->items;
    }

    public function exists($key): bool
    {
        return Arr::exists($this->items, $key);
    }

    public function offsetGet($offset): mixed
    {
        $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->set($offset, null);
    }

    public function offsetExists($offset): bool
    {
        $this->exists($offset);
    }
}