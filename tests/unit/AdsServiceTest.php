<?php

use App\Repository\{InMemoryAdsRepository, InMemoryAdsViewRepository};
use App\Service\AdsService;
use App\Entity\Ads;

class AdsServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCreate()
    {
        $adsRepo = $this->make(InMemoryAdsRepository::class);
        $adsViewRepo = $this->make(InMemoryAdsViewRepository::class);

        $adsService = $this->construct(AdsService::class, [$adsRepo, $adsViewRepo]);
        
        $ads = new Ads('test', 10, 10, 'http://banner.php');

        $createdAds = $adsService->create($ads);
        $this->assertNotNull($createdAds->getId());
    }
}