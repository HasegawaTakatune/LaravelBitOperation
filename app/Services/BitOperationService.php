<?php

namespace App\Services;

class BitOperationService
{
    public const OFF = 0;
    public const ON = 1;
    public const ALL_OFF = 0; // 0b00000000
    public const ALL_ON = 255; // 0b11111111

    public static function pointSwitch(string $baseBit, string $pointBit, int $operate): string|null
    {
        $bit = bindec($baseBit);
        $pBit = bindec($pointBit);

        return self::_switch($bit, $pBit, $operate);
    }

    public static function multiSwitch(string $baseBit, array $pointBit, int $operate): string|null
    {
        $bit = bindec($baseBit);
        $pBit = 0;

        foreach ($pointBit as $key => $value) {
            $pBit = $pBit | bindec($value);
        }

        return self::_switch($bit, $pBit, $operate);
    }

    private static function _switch(int $bit, int $pBit, int $opr): string|null
    {
        switch($opr) {
            case self::ON:
                return decbin($bit | $pBit);
                break;
            case self::OFF:
                return decbin($bit & (~$pBit));
                break;
            default:
                break;
        }
        return null;
    }

    public static function allOff(string $baseBit): string
    {
        return sprintf("%08d", decbin(bindec($baseBit) & self::ALL_OFF));
    }

    public static function allOn(string|int $baseBit): string
    {
        return sprintf("%08d", decbin(bindec($baseBit) | self::ALL_ON));
    }
}
