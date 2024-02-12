<?php

declare(strict_types=1);

namespace Kvazar\Crypto;

use Kvazar\Crypto\Hash;
use Kvazar\Crypto\Tool;

class Base58
{
    private const AVAILABLE_CHARS = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    public static function encode(
        string $value,
        ?int   $prefix = 128,
        ?bool  $compressed = true
    ): string
    {
        $value = hex2bin(
            $value
        );

        if ($prefix)
        {
            $value = chr(
                $prefix
            ) . $value;
        }

        if ($compressed)
        {
            $value .= chr(
                0x01
            );
        }

        $value = $value . substr(
            Hash::sha256(
                Hash::sha256(
                    $value
                )
            ), 0, 4
        );

        $base58 = self::_encode(
            Tool::bin2bc(
                $value
            )
        );

        for ($i = 0; $i < strlen($value); $i++)
        {

            if ($value[$i] != '\x00')
            {
                break;
            }

            $base58 = '1' . $base58;
        }

        return $base58;
    }

    public static function decode(
        string $value,
        ?int $removeLeadingBytes  = 1,
        ?int $removeTrailingBytes = 4,
        ?bool $removeCompression  = true
    )
    {
        $value = bin2hex(
            Tool::bc2bin(
                self::_decode(
                    $value
                )
            )
        );

        if ($removeLeadingBytes)
        {
            $value = substr(
                $value,
                $removeLeadingBytes * 2
            );
        }

        if ($removeTrailingBytes)
        {
            $value = substr(
                $value, 0, -($removeTrailingBytes * 2)
            );
        }

        if ($removeCompression)
        {
            $value = substr(
                $value, 0, -2
            );
        }

        return $value;
    }

    private static function _encode($num, $length = 58): string
    {
        return Tool::dec2base(
            $num,
            $length,
            self::AVAILABLE_CHARS
        );
    }

    private static function _decode(string $value, int $length = 58): string
    {
        return Tool::base2dec(
            $value,
            $length,
            self::AVAILABLE_CHARS
        );
    }
}