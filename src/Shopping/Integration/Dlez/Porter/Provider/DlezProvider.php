<?php
declare(strict_types=1);

namespace VTweb\Shopping\Integration\Dlez\Porter\Provider;

use Psr\Cache\CacheItemPoolInterface;
use ScriptFUSION\Porter\Connector\Connector;
use ScriptFUSION\Porter\Provider\Provider;
use VTweb\Shopping\Integration\Dlez\Porter\CachingConnector;
use VTweb\Shopping\Integration\Dlez\Porter\HttpConnector;

final class DlezProvider implements Provider
{
    private Connector $connector;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->connector = new CachingConnector(
            new HttpConnector(),
            $cache
        );
    }

    public function getConnector(): Connector
    {
        return $this->connector;
    }
}
