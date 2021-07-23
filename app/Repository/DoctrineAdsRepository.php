<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use App\Entity\Ads;

class DoctrineAdsRepository implements AdsRepositoryInterface
{
    private Connection $connection;
    private $qb;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(int $adsId): ?Ads
    {
        $qb = $this->connection->createQueryBuilder();

        $data = $qb
              ->select('*')
              ->from('ads')
              ->where('id = :id')
              ->setParameter('id', $adsId)
              ->setMaxResults(1)
              ->fetchAssociative();

        if (!$data || $data['id'] === null) {
            return null;
        }

        return new Ads($data['text'], $data['price'], $data['limit'], $data['banner'], $data['id']);
    }

    public function save(Ads $ads): Ads
    {
        $qb = $this->connection->createQueryBuilder();

        $result = $qb
                ->insert('ads')
                ->values([
                    'text' => '?',
                    'price' => '?',
                    '`limit`' => '?',
                    'banner' => '?',
                    'views_count' => 0,
                ])
                ->setParameter(0, $ads->getText())
                ->setParameter(1, $ads->getPrice())
                ->setParameter(2, $ads->getLimit())
                ->setParameter(3, $ads->getBanner())
                ->executeQuery();

        $id = $this->connection->lastInsertId();

        return new Ads($ads->getText(), $ads->getPrice(), $ads->getLimit(), $ads->getBanner(), $id);
    }

    public function incrementViewsCount(int $adsId): int
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb
            ->update('ads')
            ->set('views_count', 'views_count + 1')
            ->where('id = :id')
            ->setParameter('id', $adsId)
            ->executeStatement()
            ;
    }

    public function update(int $adsId, array $fields = []): int
    {
        $qb = $this->connection->createQueryBuilder();

        $qb = $qb
            ->update('ads')
            ->where('id = :id')
            ->setParameter('id', $adsId);
        ;

        foreach ($fields as $key => $value) {
            $qb
                ->set($this->connection->quote($key), ':' . $key)
                ->setParameter($key, $value);
        }

        return $qb->executeStatement();
    }

    public function findRelevant(): ?Ads
    {
        $qb = $this->connection->createQueryBuilder();

        $data = $qb
              ->select('max(price) as price, id, text, `limit`, banner')
              ->from('ads')
              ->where('`limit` > views_count')
              ->addOrderBy('views_count
', 'DESC')
              ->setMaxResults(1)
              ->fetchAssociative();

        if (!$data || $data['id'] === null) {
            return null;
        }

        return new Ads($data['text'], $data['price'], $data['limit'], $data['banner'], $data['id']);
    }
}