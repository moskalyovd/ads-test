<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use App\Entity\Ads;

class InMemoryAdsRepository implements AdsRepositoryInterface
{
    private array $adsList = [];
    private int $nextId = 1;

    public function find(int $adsId): ?Ads
    {
        $data = array_filter($this->adsList, function(array $ads) use ($adsId) {
            if ($ads['id'] === $adsId) {
                return $ads;
            }

        });

        if (count($data) > 0) {
            $data = $data[0];
        } else {
            return null;
        }

        return new Ads($data['text'], $data['price'], $data['limit'], $data['banner'], $data['id']);
    }

    public function save(Ads $ads): Ads
    {
        $id = $this->nextId;
        $this->nextId++;

        $this->adsList[] = [
            'id' => $id,
            'text' => $ads->getText(),
            'limit' => $ads->getLimit(),
            'price' => $ads->getPrice(),
            'banner' => $ads->getBanner(),
            'views_count' => 0
        ];


        return new Ads($ads->getText(), $ads->getPrice(), $ads->getLimit(), $ads->getBanner(), $id);
    }

    public function incrementViewsCount(int $adsId): int
    {
        $this->adsList = array_map(function (array $ads) use ($adsId) {
            if ($ads['id'] === $adsId) {
                $ads['views_count']++;
            }

            return $ads;
        }, $this->adsList);

        return 1;
    }

    public function update(int $adsId, array $fields = []): int
    {
        $this->adsList = array_map(function (array $ads) use ($adsId, $fields) {
            if ($ads['id'] === $adsId) {
                foreach ($fields as $key => $value) {
                    $ads[$key] = $value;
                }
            }

            return $ads;
        }, $this->adsList);

        return 1;
    }

    public function findRelevant(): ?Ads
    {
        $data = array_filter($this->adsList, function(array $ads) {
            return $ads['limit'] > $ads['views_count'];
        });

        $data = array_reduce($this->adsList, function($a, $b){
            return $a ? ($a['price'] > $b['price'] ? $a : $b) : $b;
        });

        return new Ads($data['text'], $data['price'], $data['limit'], $data['banner'], $data['id']);
    }
}