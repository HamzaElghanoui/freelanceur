<?php

namespace Tests;

use Cache\FakeCacheAdapter;
use Cache\FragmentCaching;
use PHPUnit_Framework_TestCase;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class FragmentCatchingTest extends PHPUnit_Framework_TestCase {



    /**
     * $cache = new FragmentCaching($cacheAdapter);
     * $cache->cache('test',function(){....})
     */
    public function testConstructorWithoutInterface(){
        // $this->expectedException(PHPUnit_Framework_Error::class);
        // new stdClass();
    }

    public function testConstructorWithInterface(){
        new FakeCacheAdapter();
    }

    public function testCacheWithoutCache(){
        $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
        ->setMethods(['get'])
        ->getMock();
        
        $cacheAdapter->method('get')->willReturn('en cache');
        $cacheAdapter = new FakeCacheAdapter($cacheAdapter);
        
        $cache = new FragmentCaching($cacheAdapter);
        // $this->expectOutputString('en cache');
        $cache->cache('test',function(){ echo "salue"; });
    }

    public function testCacheWithCache(){
        $cacheAdapter = $this->getMockBuilder(FakeCacheAdapter::class)
        ->setMethods(['get','set'])
        ->getMock();
        
        $cacheAdapter->method('get')->willReturn(false);
        $cacheAdapter->expects($this->once())->method('set')->with('test','salut');
        $cacheAdapter = new FakeCacheAdapter($cacheAdapter);
        
        $cache = new FragmentCaching($cacheAdapter);
        // $this->expectOutputString('en cache');
        $cache->cache('test',function(){ echo "salue"; });
    }

}