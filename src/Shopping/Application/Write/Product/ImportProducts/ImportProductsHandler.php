<?php

namespace VTweb\Shopping\Application\Write\Product\ImportProducts;

use Doctrine\ORM\EntityManagerInterface;
use ScriptFUSION\Porter\Import\Import;
use ScriptFUSION\Porter\Porter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use VTweb\Shopping\Domain\Product\Product;
use VTweb\Shopping\Domain\Product\ProductRepository;
use VTweb\Shopping\Integration\Dlez\Porter\Provider\Resource\GetProductList;

#[AsMessageHandler]
class ImportProductsHandler
{
    public function __construct(
        private readonly Porter $porter,
        private readonly GetProductList $getProductList,
        private readonly EntityManagerInterface $entityManager,
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function __invoke(ImportProducts $message)
    {
        $import = new Import(
            $this->getProductList
        );
        $import->enableCache();

        foreach ($this->porter->import($import) as $importProduct) {
            $code = $importProduct['code'];
            $product = $this->productRepository->findOneByCode($code);

            if ($product) {
                continue;
            }

            $product = new Product(
                $code,
                $importProduct['name'],
                $importProduct['manufacturerName'],
                $importProduct['manufacturerSubBrandName'],
                $importProduct['url'],
                $importProduct['price']['approximatePriceSymbol'],
                $importProduct['price']['currencySymbol'],
                $importProduct['price']['formattedValue'],
                $importProduct['price']['priceType'],
                $importProduct['price']['supplementaryPriceLabel1'],
                $importProduct['price']['supplementaryPriceLabel2'],
                $importProduct['price']['showStrikethroughPrice'],
                $importProduct['price']['discountedPriceFormatted'],
                $importProduct['price']['discountedUnitPriceFormatted'],
                $importProduct['price']['unit'],
                $importProduct['price']['unitPriceFormatted'],
                $importProduct['price']['unitCode'],
                $importProduct['price']['unitPrice'],
                $importProduct['price']['value'],
            );

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }
}
