<?php
declare(strict_types=1);

namespace VTweb\Shopping\Integration\Dlez\Porter\Provider\Resource;

use Psr\Log\LoggerInterface;
use ScriptFUSION\Porter\Connector\ImportConnector;
use ScriptFUSION\Porter\Net\Http\HttpDataSource;
use ScriptFUSION\Porter\Provider\Resource\ProviderResource;
use ScriptFUSION\Retry\ExceptionHandler\ExponentialBackoffExceptionHandler;
use VTweb\Shopping\Integration\Dlez\Porter\Provider\DlezProvider;
use function ScriptFUSION\Retry\retry;

class GetProductList implements ProviderResource, Url
{
    private int $pageNumber = 1;

    private string $hash = '';

    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function getProviderClassName(): string
    {
        return DlezProvider::class;
    }

    public function fetch(ImportConnector $connector): \Iterator
    {
        $pageNumber = 1;

        do {
            yield from retry(
                1,
                function () use ($connector, &$pageNumber): array {
                    $page = \json_decode(
                        (string)$connector->fetch(
                            new HttpDataSource($this->getUrl())
                        ),
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );

                    dump($page);

                    $this->logger->info('Import ' . $pageNumber, $page);

                    if (\count($page['data']['categoryProductSearch']['products']) === 0) {
                        $pageNumber = null;
                        return [];
                    }

                    $pageNumber++;

                    return $page['data']['categoryProductSearch']['products'];
                },
                new ExponentialBackoffExceptionHandler
            );
        } while ($pageNumber);
    }

    public function getUrl(): string
    {
        return 'https://api.delhaize.be?operationName=GetCategoryProductSearch&variables={"lang":"nl","searchQuery":"","category":"","pageNumber":' . $this->pageNumber . ',"pageSize":100,"filterFlag":true}&extensions={"persistedQuery":{"version":1,"sha256Hash":"' . $this->hash . '"}}';
    }
}
