<?php

namespace App\Entity;

abstract class BaseEntity implements \JsonSerializable
{
    abstract public static function getValidationRules(): array;
}