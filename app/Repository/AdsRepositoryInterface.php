<?php

namespace App\Repository;

use App\Entity\Ads;

interface AdsRepositoryInterface
{
    public function save(Ads $ads): Ads;

    public function find(int $adsId): ?Ads;

    public function update(int $adsId, array $fields = []): int;

    public function findRelevant(): ?Ads;

    public function incrementViewsCount(int $adsId): int;
}