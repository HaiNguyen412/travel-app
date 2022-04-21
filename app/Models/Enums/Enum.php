<?php

namespace App\Models\Enums;

class Enum
{
    public static function getConstants(): array
    {
        $oClass = new \ReflectionClass(static::class);

        return $oClass->getConstants();
    }

    public static function keys(): array
    {
        return array_keys(static::getConstants());
    }

    public static function values(): array
    {
        return array_values(static::getConstants());
    }
}
