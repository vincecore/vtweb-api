<?php

namespace VTweb\Shopping\Domain\Product;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "products")]
class Product
{
    #[Id, Column(type: "integer"), GeneratedValue('AUTO')]
    private int $id;
    #[Column(type: 'string', unique: true)]
    private string $code;
    #[Column(type: 'string')]
    private string $name;
    #[Column(type: 'string', nullable: true)]
    private ?string $manufacturerName;
    #[Column(type: 'string', nullable: true)]
    private ?string $manufacturerSubBrandName;
    #[Column(type: 'string')]
    private string $url;
    #[Column(type: 'string')]
    private ?string $priceApproximatePriceSymbol;
    #[Column(type: 'string')]
    private string $priceCurrencySymbol;
    #[Column(type: 'string')]
    private string $priceFormattedValue;
    #[Column(type: 'string')]
    private string $priceType;
    #[Column(type: 'string')]
    private string $priceSupplementaryPriceLabel1;
    #[Column(type: 'string')]
    private string $priceSupplementaryPriceLabel2;
    #[Column(type: 'boolean')]
    private bool $priceShowStrikethroughPrice;
    #[Column(type: 'string')]
    private string $priceDiscountedPriceFormatted;
    #[Column(type: 'string')]
    private string $priceDiscountedUnitPriceFormatted;
    #[Column(type: 'string')]
    private string $priceUnit;
    #[Column(type: 'string')]
    private string $priceUnitPriceFormatted;
    #[Column(type: 'string')]
    private string $priceUnitCode;
    #[Column(type: 'string')]
    private string $priceUnitPrice;
    #[Column(type: 'string')]
    private string $priceValue;

    public function __construct(
        string $code,
        string $name,
        ?string $manufacturerName,
        ?string $manufacturerSubBrandName,
        string $url,
        ?string $priceApproximatePriceSymbol,
        string $priceCurrencySymbol,
        string $priceFormattedValue,
        string $priceType,
        string $priceSupplementaryPriceLabel1,
        string $priceSupplementaryPriceLabel2,
        bool $priceShowStrikethroughPrice,
        string $priceDiscountedPriceFormatted,
        string $priceDiscountedUnitPriceFormatted,
        string $priceUnit,
        string $priceUnitPriceFormatted,
        string $priceUnitCode,
        string $priceUnitPrice,
        string $priceValue,
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->manufacturerName = $manufacturerName;
        $this->manufacturerSubBrandName = $manufacturerSubBrandName;
        $this->url = $url;
        $this->priceApproximatePriceSymbol = $priceApproximatePriceSymbol;
        $this->priceCurrencySymbol = $priceCurrencySymbol;
        $this->priceFormattedValue = $priceFormattedValue;
        $this->priceType = $priceType;
        $this->priceSupplementaryPriceLabel1 = $priceSupplementaryPriceLabel1;
        $this->priceSupplementaryPriceLabel2 = $priceSupplementaryPriceLabel2;
        $this->priceShowStrikethroughPrice = $priceShowStrikethroughPrice;
        $this->priceDiscountedPriceFormatted = $priceDiscountedPriceFormatted;
        $this->priceDiscountedUnitPriceFormatted = $priceDiscountedUnitPriceFormatted;
        $this->priceUnit = $priceUnit;
        $this->priceUnitPriceFormatted = $priceUnitPriceFormatted;
        $this->priceUnitCode = $priceUnitCode;
        $this->priceUnitPrice = $priceUnitPrice;
        $this->priceValue = $priceValue;
    }
}
