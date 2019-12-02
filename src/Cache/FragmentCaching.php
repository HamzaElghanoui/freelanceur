<?php

namespace Cache;


class FragmentCaching {
    
    private $cache;

    public function __construct(CacheAdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    public function cache($key, Callable $callback){
        $value = $this->cache->get($key);
        if($value){
            echo $value;
        } else {
            ob_start();
            $callback;
            $content = ob_get_clean();
            $this->cache->set($key, $content);
            echo $content;
        }
    }

}