<?php

namespace App\Repository;

use App\Entity\AdsView;

interface AdsViewRepositoryInterface
{
    public function save(AdsView $adsView): bool;
}