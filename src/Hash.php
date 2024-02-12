<?php

declare(strict_types=1);

namespace Kvazar\Crypto;

class Hash
{
    public static function sha256(string $data, $raw = true): string
    {
        return hash(
            'sha256',
            $data,
            $raw
        );
    }

    public static function sha256d(string $data): string
    {
        return hash(
            'sha256',
            hash(
                'sha256',
                $data,
                true
            ),
            true
        );
    }

    public static function ripemd160(string $data, $raw = true): string
    {
        return hash(
            'ripemd160',
            $data,
            $raw
        );
    }
}