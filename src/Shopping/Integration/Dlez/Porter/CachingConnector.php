<?php
declare(strict_types=1);

namespace VTweb\Shopping\Integration\Dlez\Porter;

use Psr\Cache\CacheItemPoolInterface;
use ScriptFUSION\Porter\Cache\InvalidCacheKeyException;
use ScriptFUSION\Porter\Connector\Connector;
use ScriptFUSION\Porter\Connector\DataSource;

/**
 * Wraps a connector to cache fetched data using PSR-6-compliant objects.
 */
class CachingConnector extends \ScriptFUSION\Porter\Connector\CachingConnector
{
    public const RESERVED_CHARACTERS = '{}()/\@:';

    private CacheItemPoolInterface $cache;

    public function __construct(
        private Connector $connector,
        CacheItemPoolInterface $cache
    ) {
        parent::__construct($this->connector, $cache);
        $this->cache = $cache;
    }

    /**
     * @throws InvalidCacheKeyException Cache key contains invalid data.
     */
    public function fetch(DataSource $source): mixed
    {
        $key = $source->computeHash();
        $this->validateCacheKey($key);

        if ($this->cache->hasItem($key)) {
            return $this->cache->getItem($key)->get();
        }

        $data = $this->connector->fetch($source);

        $item = $this->cache->getItem($key)
            ->expiresAfter(new \DateInterval('P1D'))
            ->set($data);

        $this->cache->save($item);

        return $data;
    }

    /**
     * @throws InvalidCacheKeyException Cache key contains invalid data.
     */
    private function validateCacheKey(string $key): void
    {
        if (strpbrk($key, self::RESERVED_CHARACTERS) !== false) {
            throw new InvalidCacheKeyException(sprintf(
                'Cache key "%s" contains one or more reserved characters: "%s".',
                $key,
                self::RESERVED_CHARACTERS
            ));
        }
    }

    public function getWrappedConnector(): Connector
    {
        return $this->connector;
    }
}
