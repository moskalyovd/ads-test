<?php

namespace App\Entity;

use JsonSerializable;

class Ads extends BaseEntity
{
    protected ?int $id = null;

    protected string $text;

    protected int $price;

    protected int $limit;

    protected string $banner;

    protected ?int $viewsCount = null;

    public function __construct(string $text, int $price, int $limit, string $banner, ?int $id = null)
    {
        $this->text = $text;
        $this->price = $price;
        $this->limit = $limit;
        $this->banner = $banner;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getBanner(): string
    {
        return $this->banner;
    }

    public function getViewsCount(): ?int
    {
        return $this->viewsCount;
    }

    public static function getValidationRules(): array
    {
        return [
            'text' => 'required',
            'price' => 'required|numeric',
            'limit' => 'required|numeric',
            'banner' => 'required|url',
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'banner' => $this->banner,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}