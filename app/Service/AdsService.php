<?php

namespace App\Service;

use App\Repository\{AdsRepositoryInterface, AdsViewRepositoryInterface};
use App\Entity\{Ads, AdsView};
use App\Exception\ResourceNotFoundException;

class AdsService
{
    private AdsRepositoryInterface $adsRepo;
    private AdsViewRepositoryInterface $adsViewRepo;
    
    public function __construct(AdsRepositoryInterface $adsRepo, AdsViewRepositoryInterface $adsViewRepo)
    {
        $this->adsRepo = $adsRepo;
        $this->adsViewRepo = $adsViewRepo;
    }

    public function create(Ads $ads): Ads
    {
        return $this->adsRepo->save($ads);
    }

    public function update(int $id, array $dataToUpdate): ?Ads
    {
        $result = $this->adsRepo->update($id, $dataToUpdate);

        if (!$result) {
            throw new ResourceNotFoundException('Ads not found');
        }

        $updatedAds = $this->adsRepo->find($id);

        return $updatedAds;
    }

    public function getRelevant(): ?Ads
    {
        $ads = $this->adsRepo->findRelevant();

        if (!$ads) {
            return null;
        }

        $adsView = new AdsView($ads->getId(), new \DateTime());

        // start transaction
        $this->adsViewRepo->save($adsView);
        $this->adsRepo->incrementViewsCount($ads->getId());
        // end transaction

        return $ads;
    }
}