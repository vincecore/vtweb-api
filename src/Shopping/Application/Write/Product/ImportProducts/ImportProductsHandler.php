<?php

namespace VTweb\Shopping\Application\Write\Product\ImportProducts;

use ScriptFUSION\Porter\Import\Import;
use ScriptFUSION\Porter\Porter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use VTweb\Shopping\Integration\Dlez\Porter\Provider\Resource\GetProductList;

#[AsMessageHandler]
class ImportProductsHandler
{
    public function __construct(
        private readonly Porter $porter,
        private readonly GetProductList $getProductList
    ) {
    }

    public function __invoke(ImportProducts $message)
    {
        $import = new Import($this->getProductList);
        foreach ($this->porter->import($import) as $product) {
        }
    }
}
