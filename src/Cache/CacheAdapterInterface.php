<?php

namespace Cache;

Interface CacheAdapterInterface {
    public function get($key);
    public function set($key, $value);
}