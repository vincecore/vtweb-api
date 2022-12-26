<?php

namespace VTweb\Shopping\Domain\Product;

use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findOneByCode(string $code): ?Product
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')
            ->from(Product::class, 'p')
            ->andWhere('p.code = :code')
            ->setParameter('code', $code);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
