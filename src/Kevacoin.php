<?php

declare(strict_types=1);

namespace Kvazar\Crypto;

class Kevacoin
{
    public static function decode(string $value)
    {
        if (is_numeric($string) && $string < 0xFFFFFFFF)
        {
            return mb_chr(
                $string,
                'ASCII'
            );
        }

        else
        {
            return hex2bin(
                $string
            );
        }
    }
}