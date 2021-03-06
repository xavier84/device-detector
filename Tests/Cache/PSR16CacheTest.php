<?php
/**
 * Device Detector - The Universal Device Detection library for parsing User Agents
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/lgpl.html LGPL v3 or later
 */
namespace DeviceDetector\Tests\Cache;

use DeviceDetector\Cache\PSR16Bridge;
use MatthiasMullie\Scrapbook\Adapters\MemoryStore;
use MatthiasMullie\Scrapbook\Psr16\SimpleCache;

class PSR16CacheTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $cache = new PSR16Bridge(new SimpleCache(new MemoryStore()));
        $cache->flushAll();
    }

    public function testSetNotPresent()
    {
        $cache = new PSR16Bridge(new SimpleCache(new MemoryStore()));
        $this->assertFalse($cache->fetch('NotExistingKey'));
    }

    public function testSetAndGet()
    {
        $cache = new PSR16Bridge(new SimpleCache(new MemoryStore()));

        // add entry
        $cache->save('key', 'value');
        $this->assertEquals('value', $cache->fetch('key'));

        // change entry
        $cache->save('key', 'value2');
        $this->assertEquals('value2', $cache->fetch('key'));

        // remove entry
        $cache->delete('key');
        $this->assertFalse($cache->fetch('key'));

        // flush all entries
        $cache->save('key', 'value2');
        $cache->save('key3', 'value2');
        $cache->flushAll();
        $this->assertFalse($cache->fetch('key'));
        $this->assertFalse($cache->fetch('key3'));
    }

}
