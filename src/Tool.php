<?php

declare(strict_types=1);

namespace Kvazar\Crypto;

class Tool
{
    public static function bc2bin($num)
    {
        return self::dec2base(
            $num,
            256
        );
    }

    public static function dec2base($dec, $base, $digits = false): ?string
    {
        if ($base < 2 || $base > 256)
        {
            return null;
        }

        bcscale(0);

        $value = '';

        if (!$digits)
        {
            $digits = self::digits(
                $base
            );
        }

        while ($dec > $base - 1)
        {
            $rest = bcmod(
                (string) $dec,
                (string) $base
            );

            $dec = bcdiv(
                (string) $dec,
                (string) $base
            );

            $value = $digits[$rest] . $value;
        }

        $value = $digits[intval($dec)] . $value;

        return (string) $value;
    }

    public static function base2dec($value, $base, $digits = false): ?string
    {
        if ($base < 2 || $base > 256)
        {
            return null;
        }

        bcscale(0);

        if ($base < 37)
        {
            $value = strtolower(
                $value
            );
        }

        if (!$digits)
        {
            $digits = self::digits(
                $base
            );
        }

        $size = strlen(
            $value
        );

        $dec = '0';

        for ($loop = 0; $loop < $size; $loop++)
        {
            $element = strpos(
                $digits,
                $value[$loop]
            );

            $power = bcpow(
                (string) $base,
                (string) ($size - $loop - 1)
            );

            $dec = bcadd(
                $dec,
                bcmul(
                    (string) $element,
                    (string) $power
                )
            );
        }

        return (string) $dec;
    }

    public static function digits($base): string
    {
        if ($base > 64)
        {
            $digits = '';

            for ($loop = 0; $loop < 256; $loop++)
            {
                $digits .= chr(
                    $loop
                );
            }
        }

        else
        {
            $digits = '0123456789abcdefghijklmnopqrstuvwxyz';
            $digits .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        }

        $digits = substr(
            $digits, 0, $base
        );

        return (string) $digits;
    }

    public static function bin2bc($num)
    {
        return self::base2dec(
            $num,
            256
        );
    }
}