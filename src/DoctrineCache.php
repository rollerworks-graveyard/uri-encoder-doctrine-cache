<?php

/*
 * This file is part of the Rollerworks URIEncoder Component package.
 *
 * (c) Sebastiaan Stok <s.stok@rollerscapes.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Rollerworks\Component\UriEncoder\Cache;

use Doctrine\Common\Cache\Cache;
use Rollerworks\Component\UriEncoder\CacheAdapterInterface;

final class DoctrineCache implements CacheAdapterInterface
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($key)
    {
        return $this->cache->fetch($key);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($key)
    {
        return $this->cache->contains($key);
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = 0)
    {
        return $this->cache->save($id, $data, $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        return $this->cache->delete($key);
    }
}
