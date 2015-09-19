<?php

/*
 * This file is part of the Rollerworks URIEncoder Component package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\UriEncoder\Tests\Cache;

use Doctrine\Common\Cache\ArrayCache;
use Rollerworks\Component\UriEncoder\Cache\DoctrineCache;

final class DoctrineCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DoctrineCache
     */
    private function createCacheProvider()
    {
        return new DoctrineCache(new ArrayCache());
    }

    /**
     * @test
     */
    public function it_returns_null_for_missing_metadata()
    {
        $provider = $this->createCacheProvider();

        $this->assertFalse($provider->fetch('foo'));
        $this->assertFalse($provider->fetch('bar'));
        $this->assertFalse($provider->contains('bar'));
    }

    /**
     * @test
     */
    public function it_can_save_metadata()
    {
        $provider = $this->createCacheProvider();
        $provider->save('Zm9vLWJhci1jYXI', 'foo-bar-car');

        $this->assertEquals('foo-bar-car', $provider->fetch('Zm9vLWJhci1jYXI'));
        $this->assertEquals('foo-bar-car', $provider->fetch('Zm9vLWJhci1jYXI'));
        $this->assertTrue($provider->contains('Zm9vLWJhci1jYXI'));

        $this->assertFalse($provider->fetch('bar'));
        $this->assertFalse($provider->contains('bar'));
    }

    /**
     * @test
     */
    public function it_can_delete_stored_metadata()
    {
        $provider = $this->createCacheProvider();
        $provider->save('Zm9vLWJhci1jYXI', 'foo-bar-car');
        $provider->save('Zm9vLWJhci1jYXIy', 'foo-blar-car');

        $this->assertTrue($provider->contains('Zm9vLWJhci1jYXI'));
        $this->assertTrue($provider->contains('Zm9vLWJhci1jYXIy'));

        $provider->delete('Zm9vLWJhci1jYXI');

        $this->assertFalse($provider->fetch('Zm9vLWJhci1jYXI'));
        $this->assertFalse($provider->contains('Zm9vLWJhci1jYXI'));

        $this->assertTrue($provider->contains('Zm9vLWJhci1jYXIy'));
        $this->assertEquals('foo-blar-car', $provider->fetch('Zm9vLWJhci1jYXIy'));
    }
}
