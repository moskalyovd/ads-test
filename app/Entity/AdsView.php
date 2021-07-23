<?php

namespace App\Entity;

use JsonSerializable;

class AdsView extends BaseEntity
{
    protected ?int $id = null;

    protected int $adsId;

    protected \DateTime $viewDate;

    public function __construct(int $adsId, \DateTime $viewDate)
    {
        $this->adsId = $adsId;
        $this->viewDate = $viewDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdsId(): int
    {
        return $this->adsId;
    }

    public function getViewDate(): \DateTime
    {
        return $this->viewDate;
    }

    public static function getValidationRules(): array
    {
        return [
        ];
    }

    public function jsonSerialize()
    {
        return [];
    }
}