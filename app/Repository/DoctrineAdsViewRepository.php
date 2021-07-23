<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use App\Entity\AdsView;

class DoctrineAdsViewRepository implements AdsViewRepositoryInterface
{
    private Connection $connection;
    private $qb;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->qb = $connection->createQueryBuilder();
    }

    public function save(AdsView $adsView): bool
    {
        return $this->qb
            ->insert('ads_view')
            ->values([
                'ads_id' => '?',
                'view_date' => '?',
            ])
            ->setParameter(0, $adsView->getAdsId())
            ->setParameter(1, $adsView->getViewDate()->format('Y-m-d H:i'))
            ->execute();
    }
}