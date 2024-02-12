<?php

declare(strict_types=1);

namespace Kvazar\Crypto;

class Kevacoin
{
    public static function decode(string $value): mixed
    {
        if (is_numeric($value) && $value < 0xFFFFFFFF)
        {
            return mb_chr(
                (int) $value,
                'ASCII'
            );
        }

        else
        {
            return hex2bin(
                $value
            );
        }
    }
}