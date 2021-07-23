<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use App\Entity\AdsView;

class InMemoryAdsViewRepository implements AdsViewRepositoryInterface
{
    private array $adsViewList = [];
    private int $nextId = 1;

    public function save(AdsView $adsView): bool
    {
        $id = $this->nextId;
        $this->nextId++;

        $this->adsViewList[] = [
            'id' => $id,
            'ads_id' => $adsView->getAdsId(),
            'view_ate' => $adsView->getViewDate()->format('Y-m-d H:i')
        ];

        return true;
    }
}