<?php

namespace Storage;

use Concept\Distinguishable;
use Predis\Client;

class RedisStorage implements Storage
{
    use SerializationHelpers;

    private Client $redis;

    public function __construct()
    {
        $this->redis = new Client();
    }

    public function store(Distinguishable $distinguishable): void
    {
        $this->redis->set($distinguishable->key(), serialize($distinguishable));
    }

    public function loadAll(): array
    {
        $result = [];
        $keys=$this->redis->keys("*");
        foreach ($keys as $key) {
            $value=$this->redis->get($key);
            if ($value) {
                $result[] = self::deserializeAsDistinguishable($value);
            }
        }
        return $result;
    }
}
