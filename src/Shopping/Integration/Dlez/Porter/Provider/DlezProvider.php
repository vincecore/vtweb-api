<?php
declare(strict_types=1);

namespace VTweb\Shopping\Integration\Dlez\Porter\Provider;

use ScriptFUSION\Porter\Connector\Connector;
use ScriptFUSION\Porter\Net\Http\HttpConnector;
use ScriptFUSION\Porter\Provider\Provider;

final class DlezProvider implements Provider
{
    private Connector $connector;

    public function __construct(Connector $connector = null)
    {
        $this->connector = $connector ?? new HttpConnector();
    }

    public function getConnector(): Connector
    {
        return $this->connector;
    }
}
